<?php

include_once 'bd.inc.php';

function getContenuRapport($id, $matricule)
{

    try {
        $monPdo = connexionPDO();
        $req = 'SELECT rap_num, 
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
        rap_definitif, 
        med_depotlegal, 
        med_depotlegal2 
        FROM rapport_visite r 
        INNER JOIN collaborateur c ON r.col_matricule=c.col_matricule 
        INNER JOIN praticien p1 ON r.pra_num_praticien=p1.pra_num 
        LEFT JOIN praticien p2 ON r.pra_num_remplacant=p2.pra_num 
        WHERE rap_num='.$id.' AND r.col_matricule="'.$matricule.'";';
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
        $req = 'SELECT rap_num, 
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
        rap_definitif, 
        FROM rapport_visite r 
        INNER JOIN collaborateur c ON r.col_matricule=c.col_matricule 
        INNER JOIN praticien p1 ON r.pra_num_praticien=p1.pra_num 
        LEFT JOIN praticien p2 ON r.pra_num_remplacant=p2.pra_num 
        INNER JOIN medicament m1 ON m1.MED_DEPOTLEGAL=r.MED_DEPOTLEGAL
        LEFT JOIN medicament m2 ON m2.MED_DEPOTLEGAL=r.MED_DEPOTLEGAL2
        WHERE rap_num='.$id.' AND r.col_matricule="'.$matricule.'";';
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
        $req = 'SELECT rap_num
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
        $req = 'SELECT r.rap_num, r.col_matricule FROM rapport_visite r
        WHERE r.col_matricule in (
        SELECT col_matricule FROM travailler t WHERE reg_code=(
        SELECT reg_code FROM travailler WHERE col_matricule="'.$matricule.'" and tra_role="Délégué"
        ) AND tra_role="Visiteur"
        ) AND RAP_DEFINITIF=1;';
        $res = $monPdo->query($req);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function filtrerLu(){}

function getDateRapport($id, $matricule) {
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT RAP_DATE
                FROM rapport_visite
                WHERE rap_num="'.$id.'" and col_matricule="'.$matricule.'";';
        $res = $monPdo->query($req);
        $result = $res->fetch();
        return $result[0];
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }   
}

function getPraticienRapport($id, $matricule) {
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT pra_num_praticien
                FROM rapport_visite
                WHERE rap_num="'.$id.'" and col_matricule="'.$matricule.'";';
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
            $autorise = $autorise|($key['rap_num']==$id&$key['col_matricule']==$matriculeRap);
        }
    }

    return $autorise;
}

function estBrouillon($id, $matricule)
{
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT rap_definitif
                FROM rapport_visite
                WHERE rap_num="'.$id.'" and col_matricule="'.$matricule.'";';
        $res = $monPdo->query($req);
        $result = $res->fetch();
        return $result[0];
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getOffresRapport($id, $matricule)
{
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT med_nomcommercial, off_qte
                FROM rapport_visite r
                INNER JOIN offrir o ON o.RAP_NUM=r.RAP_NUM
                INNER JOIN medicament m ON m.MED_DEPOTLEGAL=o.MED_DEPOTLEGAL
                WHERE r.rap_num="'.$id.'" and col_matricule="'.$matricule.'";';
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
                WHERE r.rap_num="'.$id.'" and col_matricule="'.$matricule.'";';
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
                WHERE r.rap_num="'.$id.'" and col_matricule="'.$matricule.'";';
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
                WHERE r.rap_num="'.$id.'" and col_matricule="'.$matricule.'";';
        $res = $monPdo->query($req);
        $result = $res->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function filtrerParPeriode($liste, $matricule, $date1, $date2) {
    $result = array();
    foreach($liste as $rapport){
        $dateRap=date_create(getDateRapport($rapport['rap_num'], $matricule));
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
        $praticienRap=getPraticienRapport($rapport['rap_num'], $matricule);
        if($praticien==$praticienRap)
        {
            $result[]=$rapport;
        }
    }
    return $result;
}

function isLu($matricule_lect, $rapport){
    $monPdo = connexionPDO();
    $matricule_redac = $rapport['col_matricule'];
    $id = $rapport['rap_num'];
    $req = "select * from a_lu_rapport where COL_MATRICULE_LECTEUR='".$matricule_lect."' and COL_MATRICULE_REDACTEUR='".$matricule_redac."'and rap_num=".$id.";";
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

function lire($id, $matricule_redac, $matricule_lect) {
    if(!isLu($matricule_lect, array('rap_num' => $id , 'col_matricule' => $matricule_redac))) {
    try {
    $monPdo = connexionPDO();
    $req = $monPdo->prepare("insert into a_lu_rapport (COL_MATRICULE_LECTEUR, COL_MATRICULE_REDACTEUR, RAP_NUM) VALUES (:mat_lec,:mat_redac,:rap_num);");
    $res = $req->execute(array('mat_lec'=>$matricule_lect, 'mat_redac'=>$matricule_redac, 'rap_num'=>$id));
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    }
}