<?php
if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
	$action = "medecin";
} else {
	$action = $_REQUEST['action'];
}
switch ($action) {
	case 'formulairemedec': {

			if (isset($_SESSION['login'])) {
				header('Location: index.php?uc=medecin&action=');
			} else {
				include("vues/v_connexion.php");
			}
			break;
		}


	default: {
			header('location: index.php?uc=connexion&action=connexion');
			break;
		}
}
?>