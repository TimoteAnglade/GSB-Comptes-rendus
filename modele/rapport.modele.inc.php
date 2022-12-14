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

function getRapportsCollaborateur() {
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT rap_num
        		FROM rapport_visite
        		WHERE col_matricule="'.$_SESSION['matricule'].'";';
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

function flitrerParPraticien($liste, $matricule, $praticien){
    $result = array();
    foreach($liste as $rapport){
        $praticienRap=date_create(getPraticienRapport($rapport['rap_num'], $matricule));
        if($praticien==$praticien)
        {
            $result[]=$rapport;
        }
    }
    return $result;
}

function getInfoPraticienParCollaborateur($matricule)
{

    try {

        $monPdo = connexionPDO();
        $req = 'SELECT p.PRA_NUM,p.PRA_NOM,p.PRA_PRENOM 
        FROM rapport_visite r
        INNER JOIN praticien p
        ON p.PRA_NUM=r.PRA_NUM_PRATICIEN
        WHERE r.COL_MATRICULE="'.$matricule.'"
        union
        SELECT p2.PRA_NUM, p2.PRA_NOM, p2.PRA_PRENOM
        FROM rapport_visite r1
        INNER JOIN praticien p2
        ON p2.PRA_NUM=r1.PRA_NUM_REMPLACANT
        WHERE r1.COL_MATRICULE="'.$matricule.'";';
        $res = $monPdo->query($req);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}