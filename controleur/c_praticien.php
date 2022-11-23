<?php
if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
	$action = "medecin";
} else {
	$action = $_REQUEST['action'];
}
switch ($action) {
	case 'formulairepraticien': {

			$result = getAllNomPraticien();
			// include("vues/v_.php");
			break;
		}

	case 'afficherpraticien': {

			if (isset($_REQUEST['medecin']) && getAllInformationMedicamentDepot($_REQUEST['medecin'])) {
				$mede = $_REQUEST['medecin'];
				$carac = getAllInformationMedicamentDepot($mede);
				if (empty($carac[7])) {
					$carac[7] = 'Non défini(e)';
				}
				include("vues/v_afficherMedecin.php");
			} else {
				$_SESSION['erreur'] = true;
				header("Location: index.php?uc=medecin&action=formulairemedec");
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