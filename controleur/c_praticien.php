<?php
if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
	$action = "formulairepraticien";
} else {
	$action = $_REQUEST['action'];
}
switch ($action) {
	case 'formulairepraticien': {
			$result = getInfoPraticien();
			$word = "Formulaire de praticien";
			$quote = "d'afficher";
			$button = "Afficher";
			include("vues/v_formulairePraticien.php");
			break;
		}

	case 'afficherpraticien': {

		if (isset($_REQUEST['praticien']) && getAllInfoPraticien($_REQUEST['praticien'])) {
			$pra = $_REQUEST['praticien'];
			$carac = getAllInfoPraticien($pra);
			$code = substr($carac[4],0,2);
			$regfonc = getRegionParDep($code);
			$region = $regfonc['REG_NOM'];
			include("vues/v_afficherPraticien.php");
		} else {
			$_SESSION['erreur'] = true;
			header("Location: index.php?uc=praticien&action=formulairepraticien");
		}
		break;
	}
	case 'ajoutpraticien': {
			$region = $_SESSION['region'];
			$depcode = getDepartement($_SESSION['codeR']);
			// var_dump(getNumInutilisee());
			$num=getNumInutilisee();
			$nom='';$prenom='';$adresse='';$cp='';$ville='';$notor='0';$conf='0';$type='';
			$lesTypes = getLesTypes();
			include("vues/v_modificationPraticien.php");
			break;
		}
	case 'gererpraticien': {
			$depcode = getDepartement($_SESSION['codeR']);
			$code = $_SESSION['codeR'];
			$result = getInfoPraticienParRegion($code);
			$word = "Gestion des praticien";
			$quote = "d'afficher et de gérer";
			$button = "Modifier";
			include("vues/v_formulairePraticien.php");
			break;
		}
	case 'modifierpraticien': {
		if (isset($_POST['praticien']) && getAllInfoPraticien($_POST['praticien'])) {
			$pra = $_POST['praticien'];
			$carac = getAllInfoPraticien($pra);
			$code = substr($carac[4],0,2);
			$depcode = getDepartement($_SESSION['codeR']);
			$region = $_SESSION['region'];
			$num=$carac[0];$nom=$carac[1];$prenom=$carac[2];$adresse=$carac[3];$cp=substr($carac[4],2,5);$ville=$carac[5];$notor=$carac[6];$conf=$carac[7];$type=$carac[8];
			$lesTypes = getLesTypes();
			include("vues/v_modificationPraticien.php");
		} else {
			$_SESSION['erreur'] = true;
			header("Location: index.php?uc=praticien&action=gererpraticien");
		}
		break;
	}
	case 'enregistrermodif':{
		// var_dump($_POST);
		$num = getNumInutilisee();
		$region = $_SESSION['region'];
		$nom=$_POST['nom'];$prenom=$_POST['prenom'];$adresse=$_POST['adresse'];$code=$_POST['depcode'];$cp=$_POST['cp'];$ville=$_POST['ville'];$notor=$_POST['notor'];$conf=$_POST['conf'];$type=$_POST['type'];$depcode=getDepartement($_SESSION['codeR']);
		$cp=$code.$cp;
		$tmp=enregistrePraticien($num,$nom,$prenom,$adresse,$cp,$ville,$notor,$conf,$type);
		if ($tmp = 1){
			$_SESSION['rajout'] = "<strong>".$nom."</strong> a bien été modifié";
			header("Location: index.php?uc=praticien&action=gererpraticien");
		}elseif ($tmp = 2) {
			$_SESSION['rajout'] = "<strong>".$nom."</strong> a bien été ajouté";
			header("Location: index.php?uc=praticien&action=gererpraticien");
		} else {
			$_SESSION['erreur'] = true;
			$lesTypes = getLesTypes();
			include("vues/v_modificationPraticien.php");
		}
		break;
	}
	default: {
			header('location: index.php?uc=connexion&action=connexion');
			break;
		}
}
?>