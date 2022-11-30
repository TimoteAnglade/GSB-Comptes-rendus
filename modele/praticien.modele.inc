<?php

include_once 'bd.inc.php';

function getAllInformationPraticien($numero)
{

    try {
        $monPdo = connexionPDO();
        $req = $getInfo->prepare('SELECT p.`PRA_NUM` AS `numero`,p.`PRA_NOM` AS `nom`,p.`PRA_ADRESSE` AS `adresse`,p.`PRA_CP` AS `cp`,p.`PRA_VILLE` AS `ville`,p.`PRA_COEFNOTORIETE` AS `notoriete`,tp.`TYP_LIBELLE` AS `type` FROM praticien p JOIN type_praticien tp ON tp.`TYP_CODE`=p.`TYP_CODE` WHERE PRA_NUM=:numero');
        $req->bindParam(':numero', $numero, PDO::PARAM_STR);
        $req->execute();
        $res = $req->fetch();

        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getAllNumPraticien()
{

    try {

        $monPdo = connexionPDO();
        $req = 'SELECT PRA_NUM FROM praticien ORDER BY PRA_NUM';
        $res = $monPdo->query($req);
        $result = $res->fetchAll();

        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getAllNomPraticien()
{

    try {

        $monPdo = connexionPDO();
        $req = 'SELECT PRA_NOM FROM praticien ORDER BY PRA_NOM';
        $res = $monPdo->query($req);
        $result = $res->fetchAll();

        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

?>