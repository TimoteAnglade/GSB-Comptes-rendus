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
			include("vues/v_formulairePraticien.php");
			break;
		}

	case 'afficherpraticien': {

			if (isset($_POST['praticien']) && getAllInfoPraticien($_POST['praticien'])) {
				$pra = $_POST['praticien'];
				$carac = getAllInfoPraticien($pra);
				$region = substr($carac[4],0,2); // TODO: FAIRE LA FONCTION POUR TROUVER VIA 
				if (empty($carac[7])) {
					$carac[7] = 'Non défini(e)';
				}
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
			$word = "Gestion des praticien";
			include("vues/v_formulairePraticien.php");
			break;
		}

	default: {
			header('location: index.php?uc=connexion&action=connexion');
			break;
		}
}
?>