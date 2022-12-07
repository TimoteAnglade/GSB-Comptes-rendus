<?php
if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
	$action = "voirMesRapports";
} else {
	$action = $_REQUEST['action'];
}
switch ($action) {
	case 'voirMesRapports': {
		$matricule = $_SESSION['matricule'];
		$result = getRapportsCollaborateur();
		$titre = array('Formulaire de vos rapports', 'Formulaire permettant d\'accéder aux rapports que vous avez rédigé et vos brouillons', 'Vos rapports :');
		include("vues/v_listeRapports.php");
		break;
		}

	case 'voirRapport': {

		$matricule = $_SESSION['matricule'];
		if(isset($_REQUEST['rapport'])) {
			$rapport = $_REQUEST['rapport'];
		}
		$content = getContenuRapport($rapport, $matricule);
		if(empty($content)){
			include("vues/v_accueil.php");	
		}
		else{
			include("vues/v_rapport.php");	
		}
		break;
	}
	default :
	{
		include("vues/v_accueil.php");	
	}
}
?>