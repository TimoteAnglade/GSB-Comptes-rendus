<?php
if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
	$action = "formulairepraticien";
} else {
	$action = $_REQUEST['action'];
}
switch ($action) {
	case 'formulairepraticien': {
			$result = getAllLibellePraticien();
			include("vues/v_formulairePraticien.php");
			break;
		}

	case 'afficherpraticien': {

			if (isset($_POST['praticien']) && getAllInformationPraticien($_POST['praticien'])) {
				$pra = $_POST['praticien'];
				$carac = getAllInformationPraticien($pra);
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
	case 'gerermedecin': {

			// include("vues/v_.php");
			break;
		}

	default: {
			header('location: index.php?uc=connexion&action=connexion');
			break;
		}
}
?>