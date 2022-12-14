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
			$regcode = substr($carac[4],0,2);
			$regfonc = getNomRegion($regcode); 
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
			$regcode = '';
			$num='';$nom='';$prenom='';$adresse='';$cp='';$ville='';$notor='';$type='';
			include("vues/v_modificationPraticien.php");
			break;
		}
	case 'gererpraticien': {
			$regcode = $_SESSION['codeR'];
			$result = getInfoPraticienParRegion($regcode);
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
			$regcode = substr($carac[4],0,2);
			$regfonc = getNomRegion($regcode);
			$region = $regfonc['REG_NOM'];
			$num=$carac[0];$nom=$carac[1];$prenom=$carac[2];$adresse=$carac[3];$cp=substr($carac[4],2,5);$ville=$carac[5];$notor=$carac[6];$type=$carac[7];
			include("vues/v_modificationPraticien.php");
		} else {
			$_SESSION['erreur'] = true;
			header("Location: index.php?uc=praticien&action=gererpraticien");
		}
		break;
	}
	case 'enregistrermodif':{
		$num=$_POST['num'];$nom=$_POST['nom'];$prenom=$_POST['prenom'];$adresse=$_POST['adresse'];$cp=$_POST['regcode']."".$_POST['cp'];$ville=$_POST['ville'];$region=$_POST['region'];$notor=$_POST['notor'];$type=$_POST['type'];
		if ( enregistrementPraticien($num,$nom,$prenom,$adresse,$cp,$ville,$notor,$type,$region) ){
			header("Location: index.php?uc=praticien&action=gererpraticien");
		} else {
			$_SESSION['erreur'] = true;
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