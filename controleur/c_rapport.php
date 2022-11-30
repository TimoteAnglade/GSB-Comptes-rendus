<?php
if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
	$action = "voirMesRapports";
} else {
	$action = $_REQUEST['action'];
}
switch ($action) {
	case 'voirMesRapports': {

		$result = getRapportsCollaborateur();
		include("vues/v_listeRapports.php");
		break;
		}

	case 'voirRapport': {

		if(isset($_REQUEST['rapport'])) {
			$rapport = $_REQUEST['rapport'];
		}
		$content = getContenuRapport($rapport);
		include("vues/v_rapport.php");
	}
}
?>