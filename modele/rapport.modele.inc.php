<?php

include_once 'bd.inc.php';

function getContenuRapport($id, $matricule)
{

    try {
        $monPdo = connexionPDO();
        $req = 'SELECT RAP_NUM, 
        c.col_nom, 
        c.col_prenom, 
        pra_num_praticien, 
        p1.pra_nom, 
        p1.pra_prenom, 
        pra_num_remplacant, 
        p2.pra_nom as pra_rem_nom, 
        p2.pra_prenom as pra_rem_prenom, 
        rap_date, 
        rap_bilan, 
        mot_code, 
        rap_motif_autre, 
        rap_brouillon, 
        med_depotlegal, 
        med_depotlegal2 
        FROM rapport_visite r 
        INNER JOIN collaborateur c ON r.col_matricule=c.col_matricule 
        INNER JOIN praticien p1 ON r.pra_num_praticien=p1.pra_num 
        LEFT JOIN praticien p2 ON r.pra_num_remplacant=p2.pra_num 
        WHERE RAP_NUM='.$id.' AND r.col_matricule="'.$matricule.'";';
        $res = $monPdo->query($req);
        $result = $res->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getContenuRapportLight($id, $matricule)
{

    try {
        $monPdo = connexionPDO();
        $req = 'SELECT RAP_NUM, 
        pra_num_praticien, 
        p1.pra_nom, 
        p1.pra_prenom, 
        mot_code, 
        rap_motif_autre, 
        rap_date, 
        med_depotlegal,
        m1.med_nomcommercial as med_nomcommercial1,
        med_depotlegal2,
        m2.med_nomcommercial as med_nomcommercial2,
        rap_brouillon, 
        FROM rapport_visite r 
        INNER JOIN collaborateur c ON r.col_matricule=c.col_matricule 
        INNER JOIN praticien p1 ON r.pra_num_praticien=p1.pra_num 
        LEFT JOIN praticien p2 ON r.pra_num_remplacant=p2.pra_num 
        INNER JOIN medicament m1 ON m1.MED_DEPOTLEGAL=r.MED_DEPOTLEGAL
        LEFT JOIN medicament m2 ON m2.MED_DEPOTLEGAL=r.MED_DEPOTLEGAL2
        WHERE RAP_NUM='.$id.' AND r.col_matricule="'.$matricule.'";';
        $res = $monPdo->query($req);
        $result = $res->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getListePraticiensVisitePar($matricule){
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT distinct(p.PRA_NUM),
        PRA_NOM,
        PRA_PRENOM 
        FROM rapport_visite r 
        INNER JOIN praticien p ON p.pra_num=r.pra_num_praticien
        ORDER BY PRA_NUM';
        $res = $monPdo->query($req);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getRapportsCollaborateur($matricule) {
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT RAP_NUM, COL_MATRICULE
                FROM rapport_visite
                WHERE col_matricule="'.$matricule.'"
                ORDER BY rap_date;';
        $res = $monPdo->query($req);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getRapportsRegion($matricule) {
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT r.RAP_NUM, r.col_matricule FROM rapport_visite r
        WHERE r.col_matricule in (
        SELECT col_matricule FROM travailler t WHERE reg_code=(
        SELECT reg_code FROM travailler WHERE col_matricule="'.$matricule.'" and tra_role="Délégué"
        ) AND tra_role="Visiteur"
        ) AND rap_brouillon=0;';
        $res = $monPdo->query($req);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getDateRapport($id, $matricule) {
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT RAP_DATE
                FROM rapport_visite
                WHERE RAP_NUM="'.$id.'" and col_matricule="'.$matricule.'";';
        $res = $monPdo->query($req);
        $result = $res->fetch();
        return $result[0];
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        return '';
    }   
}

function getPraticienRapport($id, $matricule) {
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT pra_num_praticien
                FROM rapport_visite
                WHERE RAP_NUM="'.$id.'" and col_matricule="'.$matricule.'";';
        $res = $monPdo->query($req);
        $result = $res->fetch();
        return $result[0];
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }   
}

function estAutorise($id, $matriculeRap, $matriculePersonne){
    $autorise = false;
    $autorise = $autorise|empty($matriculeRap);
    $autorise = $autorise|$matriculeRap==$matriculePersonne;

    if(!$autorise){
        $result = getRapportsRegion($matriculePersonne);
        foreach($result as $key){
            $autorise = $autorise|($key['RAP_NUM']==$id&$key['col_matricule']==$matriculeRap);
        }
    }

    return $autorise;
}

function filtrerParBrouillon($liste, $matricule){
    $result = array();
    foreach($liste as $rapport){
        if($rapport['COL_MATRICULE']==$matricule){
            if(estBrouillon($rapport['RAP_NUM'],$rapport['COL_MATRICULE']))
            {
                $result[]=$rapport;
            }
            else{
            }
        }
    }
    return $result;
}

function estBrouillon($id, $matricule)
{
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT rap_brouillon
                FROM rapport_visite
                WHERE RAP_NUM="'.$id.'" and col_matricule="'.$matricule.'";';
        $res = $monPdo->query($req);
        $result = $res->fetch();
        if($result){
            return $result[0];   
        }
        else{
            return [];
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getOffresRapport($id, $matricule)
{
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT o.med_depotlegal, med_nomcommercial, off_qte
                FROM rapport_visite r
                INNER JOIN offrir o ON o.RAP_NUM=r.RAP_NUM AND o.col_matricule=r.col_matricule
                INNER JOIN medicament m ON m.MED_DEPOTLEGAL=o.MED_DEPOTLEGAL
                WHERE r.RAP_NUM="'.$id.'" and r.col_matricule="'.$matricule.'";';
        $res = $monPdo->query($req);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getPresentesRapport($id, $matricule)
{
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT MED_DEPOTLEGAL, MED_DEPOTLEGAL2
                FROM rapport_visite r
                WHERE r.RAP_NUM="'.$id.'" and col_matricule="'.$matricule.'";';
        $res = $monPdo->query($req);
        $result = $res->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getPresentesNomRapport($id, $matricule)
{
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT m1.med_nomcommercial as med_nomcommercial1, m2.med_nomcommercial as med_nomcommercial2
                FROM rapport_visite r
                INNER JOIN medicament m1 ON m1.MED_DEPOTLEGAL=r.MED_DEPOTLEGAL
                LEFT JOIN medicament m2 ON m2.MED_DEPOTLEGAL=r.MED_DEPOTLEGAL2
                WHERE r.RAP_NUM="'.$id.'" and col_matricule="'.$matricule.'";';
        $res = $monPdo->query($req);
        $result = $res->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getMotifRapport($id, $matricule)
{
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT MOT_CODE, rap_motif_autre
                FROM rapport_visite r
                WHERE r.RAP_NUM="'.$id.'" and col_matricule="'.$matricule.'";';
        $res = $monPdo->query($req);
        $result = $res->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function filtrerParPeriode($liste, $matricule, $date1, $date2, $special=0) {
    $result = array();
    foreach($liste as $rapport){
        if($special){
            $date = getDateRapport($rapport['RAP_NUM'], $rapport['col_matricule']);
        } else {
            $date = getDateRapport($rapport['RAP_NUM'], $matricule);
        }
        $dateRap=date_create($date);
        if(($dateRap>=$date1)&&($dateRap<=$date2))   
        {
            $result[]=$rapport;
        }
    }
    return $result;
}

function filtrerParPraticien($liste, $matricule, $praticien){
    $result = array();
    foreach($liste as $rapport){
        $praticienRap=getPraticienRapport($rapport['RAP_NUM'], $matricule);
        if($praticien==$praticienRap)
        {
            $result[]=$rapport;
        }
    }
    return $result;
}

function filtrerParCollaborateur($liste, $matricule, $collaborateur){
    $result = array();
    foreach($liste as $rapport){
        $colRap=$rapport['col_matricule'];
        if($collaborateur==$colRap)
        {
            $result[]=$rapport;
        }
    }
    return $result;
}

function isLu($matricule_lect, $rapport){
    $monPdo = connexionPDO();
    $matricule_redac = $rapport['col_matricule'];
    $id = $rapport['RAP_NUM'];
    $req = "select * from a_lu_rapport where COL_MATRICULE_LECTEUR='".$matricule_lect."' and COL_MATRICULE_REDACTEUR='".$matricule_redac."'and RAP_NUM=".$id.";";
    $res = $monPdo->query($req);
    $result = $res->fetch(PDO::FETCH_ASSOC);
    $booleanRes = false;
    if(!empty($result)){
        if(count($result)>0){
            $booleanRes=true;
        }
    }
    return $booleanRes;
}

function filtrerParLu($liste, $matricule_lect){
    $result = [];
    foreach($liste as $rapport){
        if(!isLu($matricule_lect, $rapport)){
            $result[]=$rapport;
        }
    }
    return $result;
}

function filtrerParNonLu($liste, $matricule_lect){
    $result = [];
    foreach($liste as $rapport){
        if(isLu($matricule_lect, $rapport)){
            $result[]=$rapport;
        }
    }
    return $result;
}

function lire($id, $matricule_redac, $matricule_lect) {
    if(!isLu($matricule_lect, array('RAP_NUM' => $id , 'col_matricule' => $matricule_redac))) {
    try {
    $monPdo = connexionPDO();
    $req = $monPdo->prepare("insert into a_lu_rapport (COL_MATRICULE_LECTEUR, COL_MATRICULE_REDACTEUR, RAP_NUM) VALUES (:mat_lec,:mat_redac,:RAP_NUM);");
    $res = $req->execute(array('mat_lec'=>$matricule_lect, 'mat_redac'=>$matricule_redac, 'RAP_NUM'=>$id));
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    }
}

function getInfoCollaborateurParDelegue($matricule)
{

    try {
        $monPdo = connexionPDO();
        $req = 'SELECT c.COL_MATRICULE, c.COL_NOM, c.COL_PRENOM FROM rapport_visite r
        INNER JOIN collaborateur c ON c.col_matricule = r.col_matricule
        WHERE r.col_matricule in (
        SELECT col_matricule FROM travailler t WHERE reg_code=(
        SELECT reg_code FROM travailler WHERE col_matricule="'.$matricule.'" and tra_role="Délégué"
        ) AND tra_role="Visiteur"
        ) AND rap_brouillon=0;';
        $res = $monPdo->query($req);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function assigner($texte)
{
    $result = "";
    if(isset($_REQUEST[$texte])){
        if(empty($_REQUEST[$texte])){
        $result = $_REQUEST[$texte];
        }
    }
    return $result;
}

function getAllMotifs()
{
    try{
            $monPdo = connexionPDO();
            $req = 'SELECT MOT_CODE, MOT_LIBELLE FROM motif';
            $res = $monPdo->query($req);
            $result = $res->fetchAll();
            return $result;
        } 

        catch (PDOException $e){
            print "Erreur !: " . $e->getMessage();
            die();
        }
}

function ajoutOuModif($donnees)
{
    $canEdit=!empty($donnees['matricule'])&&!empty($donnees['rapport'])&&!empty($donnees['praticien'])&&!empty($donnees['bilanContent'])&&!empty($donnees['motif'])&&(!empty($donnees['brouillon'])||$donnees['brouillon']=='0')&&!empty($donnees['dateVis']);
    $vraimatricule=$_SESSION['matricule'];
    $canEdit=$canEdit&&$donnees['matricule']==$vraimatricule;

    //vérification de si le rapport existe et est éditable
    $publiable="";
    try{
    $monPdo = connexionPDO();
    $req="SELECT count(RAP_NUM) as 'publiable' FROM rapport_visite WHERE col_matricule=:mat AND RAP_NUM=:rap AND rap_brouillon=1";
    $req = $monPdo->prepare($req);
    $req->execute(array('mat'=>$vraimatricule, 'rap'=>$donnees['rapport']));
    $publiable = $req->fetch(PDO::FETCH_ASSOC)['publiable'];
    }catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    $canEdit=$canEdit&&($publiable||$donnees['isNew']);


    $isNew = true;

    $req="SELECT (count(RAP_NUM)=0) as 'isThere' FROM rapport_visite WHERE col_matricule=:mat AND RAP_NUM=:rap";
    $req = $monPdo->prepare($req);
    $req->execute(array('mat'=>$vraimatricule, 'rap'=>$donnees['rapport']));
    $isNew = $req->fetch(PDO::FETCH_ASSOC)['isThere'];
    if($canEdit){
        if($isNew){
            $preparation = [
            'mat'=>$donnees['matricule'],
            'rap' => $donnees['rapport'],
            'praPra' => $donnees['praticien'],
            'dat' => date('Y-m-d'),
            'datvis' => $donnees['dateVis'],
            'bil' => $donnees['bilanContent'],
            'mot' => $donnees['motif'],
            'brou' => $donnees['brouillon']];

            $req = "INSERT INTO rapport_visite (COL_MATRICULE, RAP_NUM, PRA_NUM_PRATICIEN, PRA_NUM_REMPLACANT, RAP_DATE, RAP_DATE_VIS, RAP_BILAN, MOT_CODE, RAP_MOTIF_AUTRE, rap_brouillon, MED_DEPOTLEGAL, MED_DEPOTLEGAL2) VALUES (:mat, :rap, :praPra, ";
            if(empty($donnees['praticienremp'])){
                $req = $req."NULL, ";
            }
            else{
                $req = $req.':praremp'.", ";
                $preparation['praremp']=$donnees['praticienremp'];
            }
            $req = $req.":dat, :datvis, :bil, :mot, ";
            if($donnees['motif']!="Autre"){
                $req = $req."NULL, ";
            }
            else{
                $req = $req.':motaut'.", ";
                $preparation['motaut']=$donnees['motifautre'];
            }
            $req = $req.":brou, ";
            if(empty($donnees['medicamentproposer'])){
                $req = $req."NULL, ";
            }
            else{
                $req = $req.':medpro1'.', ';
                $preparation['medpro1']=$donnees['medicamentproposer'];
            }
            if(empty($donnees['medicamentproposer2'])){
                $req = $req."NULL";
            }
            else{
                $req = $req.':medpro2';
                $preparation['medpro2']=$donnees['medicamentproposer2'];
            }
            $req = $req.");";
            $req = $monPdo->prepare($req);
            $req->execute($preparation);

            foreach($donnees['echantillions'] as $ech){
                $qte = getValeurEch($donnees['matricule'], $donnees['rapport'], $ech[0]);
                if($qte){
                    $req = "UPDATE offrir SET OFF_QTE=OFF_QTE+:qte WHERE COL_MATRICULE=:mat AND RAP_NUM=:rap AND MED_DEPOTLEGAL=:med";
                    $reqprep = $monPdo->prepare($req);
                    $res = $reqprep->execute(['rap'=>$donnees['rapport'], 'mat'=>$donnees['matricule'], 'med'=>$ech[0], 'qte'=>$ech[1]]);
                }
                else{
                    $req="INSERT INTO offrir (RAP_NUM, COL_MATRICULE, MED_DEPOTLEGAL, OFF_QTE) VALUES (:rap, :mat, :med, :qte)";
                    $reqprep = $monPdo->prepare($req);
                    $res = $reqprep->execute(['rap'=>$donnees['rapport'], 'mat'=>$donnees['matricule'], 'med'=>$ech[0], 'qte'=>$ech[1]]);
                }
            }


        }
        else{           //Update si c'est pas new
            $preparation = [
            'mat'=>$donnees['matricule'],
            'rap' => $donnees['rapport'],
            'praPra' => $donnees['praticien'],
            'dat' => date('Y-m-d'),
            'datVis' => $donnees['dateVis'],
            'bil' => $donnees['bilanContent'],
            'mot' => $donnees['motif'],
            'brou' => $donnees['brouillon']];


            $req = "UPDATE rapport_visite SET PRA_NUM_PRATICIEN=:praPra,";

             
            if(empty($donnees['praticienremp'])){
            }
            else{
                $req = $req.'PRA_NUM_REMPLACANT=:praremp, ';
                $preparation['praremp']=$donnees['praticienremp'];
            }

            $req = $req."RAP_DATE=:dat, RAP_DATE_VIS=:datVis, RAP_BILAN=:bil, MOT_CODE=:mot, ";


            if($donnees['motif']!="Autre"){
            }
            else{
                $req = $req.'RAP_MOTIF_AUTRE=:motAut, ';
                $preparation['motAut']=$donnees['motifautre'];
            }

            $req = $req."RAP_BROUILLON=:brou ";

            if(empty($donnees['medicamentproposer'])){
                $req = $req.", MED_DEPOTLEGAL=NULL" ;
            }
            else{
                $req = $req.', MED_DEPOTLEGAL=:med1';
                $preparation['med1']=$donnees['medicamentproposer'];
            }


            if(empty($donnees['medicamentproposer2'])){
                $req = $req.", MED_DEPOTLEGAL2=NULL ";
            }
            else{
                $req = $req.', MED_DEPOTLEGAL2=:med2 ';
                $preparation['med2']=$donnees['medicamentproposer2'];
            }

            $req = $req."WHERE COL_MATRICULE=:mat AND RAP_NUM=:rap;";
            $req = $monPdo->prepare($req);
            $req->execute($preparation);




            $req = "DELETE FROM offrir WHERE COL_MATRICULE=:mat AND RAP_NUM=:rap";
            $reqprep = $monPdo->prepare($req);
            $res = $reqprep->execute(['rap'=>$donnees['rapport'], 'mat'=>$donnees['matricule']]);
            foreach($donnees['echantillions'] as $ech){
                $qte = getValeurEch($donnees['matricule'], $donnees['rapport'], $ech[0]);
                if($qte){

                    $req = "UPDATE offrir SET OFF_QTE=OFF_QTE+:qte WHERE COL_MATRICULE=:mat AND RAP_NUM=:rap AND MED_DEPOTLEGAL=:med";
                    $reqprep = $monPdo->prepare($req);
                    $res = $reqprep->execute(['rap'=>$donnees['rapport'], 'mat'=>$donnees['matricule'], 'med'=>$ech[0], 'qte'=>$ech[1]]);
                }
                else{
                    $req="INSERT INTO offrir (RAP_NUM, COL_MATRICULE, MED_DEPOTLEGAL, OFF_QTE) VALUES (:rap, :mat, :med, :qte)";
                    $reqprep = $monPdo->prepare($req);
                    $res = $reqprep->execute(['rap'=>$donnees['rapport'], 'mat'=>$donnees['matricule'], 'med'=>$ech[0], 'qte'=>$ech[1]]);
                }
            }
        }
        return true;   
    }
    else{
        return false;
    }


}

function getEchantillions($rapport, $matricule){
    try{
            $monPdo = connexionPDO();
            $req = 'SELECT o.MED_DEPOTLEGAL, m.MED_NOMCOMMERCIAL, o.OFF_QTE FROM offrir o INNER JOIN medicament m ON m.med_depotlegal=o.med_depotlegal WHERE o.RAP_NUM='.$rapport.' AND o.col_matricule="'.$matricule.'" ORDER BY MED_NOMCOMMERCIAL';
            $res = $monPdo->query($req);
            $result = $res->fetchAll();
            return $result;
        } 
    catch (PDOException $e){
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getNouveauRapNum(){
    try{
            $matricule=$_SESSION['matricule'];
            $monPdo = connexionPDO();
            $req = 'SELECT (max(RAP_NUM)+1) as "code" FROM rapport_visite WHERE COL_MATRICULE="'.$matricule.'";';
            $res = $monPdo->query($req);
            $result = $res->fetch()['code'];
            return $result;
    }
    catch (PDOException $e){
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getValeurEch($mat, $rap, $med){

    try {
        $monPdo = connexionPDO();
        $req="SELECT IFNULL(SUM(OFF_QTE),0) as 'qte' FROM `offrir` WHERE COL_MATRICULE=:mat AND RAP_NUM=:rap AND MED_DEPOTLEGAL=:med;";
        $req = $monPdo->prepare($req);
        $res = $req->execute(['mat' => $mat, 'rap' => $rap, 'med' => $med, ]);
        $result = $req->fetch()[0];
        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}