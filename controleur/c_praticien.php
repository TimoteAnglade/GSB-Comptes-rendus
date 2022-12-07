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
			include("vues/v_formulairePraticien.php");
			break;
		}

	case 'afficherpraticien': {

			if (isset($_POST['praticien']) && getAllInfoPraticien($_POST['praticien'])) {
				$pra = $_POST['praticien'];
				$carac = getAllInfoPraticien($pra);
				$region = substr($carac[4],0,2); // TODO: FAIRE LA FONCTION POUR TROUVER VIA 
				include("vues/v_afficherPraticien.php");
			} else {
				$_SESSION['erreur'] = true;
				header("Location: index.php?uc=praticien&action=formulairepraticien");
			}
			break;
		}
	case 'gererpraticien': {
			$region = $_SESSION['codeR']; //TODO 
			$result = getInfoPraticienParRegion($region);
			//$result = getInfoPraticien();
			$word = "Gestion des praticien";
			$quote = "d'afficher et de gérer";
			include("vues/v_formulairePraticien.php");
			break;
		}
	case 'modifierpraticien': {
		if (isset($_POST['praticien']) && getAllInfoPraticien($_POST['praticien'])) {
			$pra = $_POST['praticien'];
			$carac = getAllInfoPraticien($pra);
			$region = substr($carac[4],0,2); // TODO: FAIRE LA FONCTION POUR TROUVER VIA 
			include("vues/v_modificationPraticien.php");
		} else {
			$_SESSION['erreur'] = true;
			header("Location: index.php?uc=praticien&action=gererpraticien");
		}
		break;
	}
	default: {
			header('location: index.php?uc=connexion&action=connexion');
			break;
		}
}
?>