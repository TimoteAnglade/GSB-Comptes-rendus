<?php

include_once 'bd.inc.php';

function getAllInfoPraticien($numero)
{

    try {
        $monPdo = connexionPDO();
        $req = $monPdo->prepare('SELECT 
            p.`PRA_NUM` AS `numero`,
            p.`PRA_NOM` AS `nom`,
            p.`PRA_PRENOM` AS `prenom`,
            p.`PRA_ADRESSE` AS `adresse`,
            p.`PRA_CP` AS `cp`,
            p.`PRA_VILLE` AS `ville`,
            p.`PRA_COEFNOTORIETE` AS `notoriete`,
            tp.`TYP_LIBELLE` AS `type` 
            FROM praticien p 
            JOIN type_praticien tp 
            ON tp.`TYP_CODE`=p.`TYP_CODE` 
            WHERE PRA_NUM=:numero');
        $req->bindParam(':numero', $numero, PDO::PARAM_STR);
        $req->execute();
        $res = $req->fetch();

        return $res;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getInfoPraticien()
{

    try {

        $monPdo = connexionPDO();
        $req = 'SELECT PRA_NUM,PRA_NOM,PRA_PRENOM 
        FROM praticien 
        ORDER BY PRA_NUM';
        $res = $monPdo->query($req);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getInfoPraticienParRegion($region)
{
    try {
        $monPdo = connexionPDO();
        // $req = $monPdo->prepare('SELECT PRA_NUM,PRA_NOM,PRA_PRENOM FROM praticien WHERE REG_CODE=:region ORDER BY PRA_NUM');
        $req = $monPdo->prepare('SELECT p.PRA_NUM,p.PRA_NOM,p.PRA_PRENOM 
            FROM praticien p
            INNER JOIN departement d ON SUBSTRING(p.PRA_CP,1,2)=d.DEP_NUM 
            WHERE REG_CODE=:region 
            ORDER BY PRA_NUM');
        $res = $req->execute(array('region' => $region));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
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

function getAllRegionPraticien()
{
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT DISTINCT p.REG_CODE,r.REG_NOM 
        FROM praticien p 
        JOIN region r ON r.REG_CODE = p.REG_CODE';
        $res = $monPdo->query($req);
        $result = $res->fetch();

        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getLesRegions()
{
    try {
        $monPdo = connexionPDO();
        $req = 'SELECT REG_CODE,REG_NOM FROM region';
        $res = $monPdo->query($req);
        $result = $res->fetchAll();
        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getLesTypes()
{
    try {

        $monPdo = connexionPDO();
        $req = 'SELECT TYP_CODE,TYP_LIBELLE FROM type_praticien';
        $res = $monPdo->query($req);
        $result = $res->fetchAll();
        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getRegionParDep($depcode){
    try {

        $monPdo = connexionPDO();
        $req = $monPdo->prepare('SELECT r.REG_NOM 
            FROM departement d 
            INNER JOIN region r ON r.REG_CODE=d.REG_CODE 
            WHERE d.DEP_NUM=:code');
        $res = $req->execute(array('code' => $depcode ));
        $result = $req->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getDepartement($regcode){
    try {
        $monPdo = connexionPDO();
        $req = $monPdo->prepare('SELECT DEP_NUM 
            FROM departement 
            WHERE REG_CODE=:code');
        $res = $req->execute(array('code' => $regcode ));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function enregistrementPraticien($num,$nom,$prenom,$adresse,$cp,$ville,$notor,$type,$region){
    $tmp = false;
    try {
        $monPdo = connexionPDO();
        $req = $req = $monPdo->prepare('SELECT PRA_NUM FROM praticien WHERE PRA_NUM=:num');
        $res = $req -> execute(array('num'=>$num));
        $result = $req->fetch(PDO::FETCH_ASSOC);
        if (!empty($result['PRA_NUM'])){
            $req = $req = $monPdo->prepare('UPDATE praticien
            PRA_NOM= :nom,
            PRA_PRENOM= :prenom,
            PRA_ADRESSE= :adresse,
            PRA_CP= :ville,
            PRA_VILLE= :ville,
            PRA_COEFNOTORIETE= :notor,
            TYP_CODE=:type
            WHERE PRA_NUM=:num');
            $res = $req->execute(array('num'=>$num,'nom'=>$nom,'prenom'=>$prenom,'cp'=>$cp,'ville'=>$ville,'notor'=>$notor,'type'=>$type,'region'=>$region));
            $tmp = true;
        } else {
            $req = $req = $monPdo->prepare('INSERT INTO praticien
            (PRA_NUM,PRA_NOM,PRA_PRENOM,PRA_ADRESSE,PRA_CP,PRA_VILLE,PRA_COEFNOTORIETE,TYP_CODE) 
            VALUES (:num,:nom,:prenom,:adresse,:ville,:ville,:notor,:type)');
            $res = $req->execute(array('num'=>$num,'nom'=>$nom,'prenom'=>$prenom,'cp'=>$cp,'ville'=>$ville,'notor'=>$notor,'type'=>$type,'region'=>$region));
            $tmp = true;
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $tmp;
}
?>