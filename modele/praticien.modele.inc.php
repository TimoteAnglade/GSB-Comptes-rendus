<?php

include_once 'bd.inc.php';

function getAllInformationPraticien($numero)
{

    try {
        $monPdo = connexionPDO();
        $req = $monPdo->prepare('SELECT p.`PRA_NUM` AS `numero`,p.`PRA_NOM` AS `nom`,p.`PRA_PRENOM` AS `prenom`,p.`PRA_ADRESSE` AS `adresse`,p.`PRA_CP` AS `cp`,p.`PRA_VILLE` AS `ville`,p.`PRA_COEFNOTORIETE` AS `notoriete`,tp.`TYP_LIBELLE` AS `type`,p.`REG_CODE` AS `region` FROM praticien p JOIN type_praticien tp ON tp.`TYP_CODE`=p.`TYP_CODE` WHERE PRA_NUM=:numero');
        $req->bindParam(':numero', $numero, PDO::PARAM_STR);
        $req->execute();
        $res = $req->fetch();

        return $res;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getAllLibellePraticien()
{

    try {

        $monPdo = connexionPDO();
        $req = 'SELECT PRA_NUM,PRA_NOM,PRA_PRENOM FROM praticien ORDER BY PRA_NUM';
        $res = $monPdo->query($req);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getAllLibellePraticienParRegion($region)
{

    try {

        $monPdo = connexionPDO();
        $req = $monPdo->prepare('SELECT PRA_NUM,PRA_NOM,PRA_PRENOM FROM praticien WHERE REG_CODE=:region ORDER BY PRA_NUM');
        $res = execute(array(':region' => $region ));
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getAllRegionPraticien()
{

    try {

        $monPdo = connexionPDO();
        $req = 'SELECT DISTINCT p.REG_CODE,r.REG_NOM FROM praticien p JOIN region r ON r.REG_CODE = p.REG_CODE';
        $res = $monPdo->query($req);
        $result = $res->fetchAll();

        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

?>