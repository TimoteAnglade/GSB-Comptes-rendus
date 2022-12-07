<?php

include_once 'bd.inc.php';

function getContenuRapport($id, $matricule)
{

    try {
        $monPdo = connexionPDO();
        $req = 'SELECT rap_num, c.col_nom, c.col_prenom, pra_num_praticien, p1.pra_nom, p1.pra_prenom, pra_num_remplacant, p2.pra_nom, p2.pra_prenom, rap_date, rap_bilan, mot_code, rap_motif_autre, rap_definitif, med_depotlegal, med_depotlegal2 FROM rapport_visite r INNER JOIN collaborateur c ON r.col_matricule=c.col_matricule LEFT JOIN praticien p1 ON r.pra_num_praticien=p1.pra_num LEFT JOIN praticien p2 ON r.pra_num_remplacant=p2.pra_num WHERE rap_num='.$id.' AND r.col_matricule="'.$matricule.'";';
        $res = $monPdo->query($req);
        $result = $res->fetch();
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