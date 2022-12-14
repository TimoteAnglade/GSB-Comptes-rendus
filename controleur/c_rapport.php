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
		var_dump($result);
		$titre = array('Formulaire de vos rapports', 'Formulaire permettant d\'accéder aux rapports que vous avez rédigé et vos brouillons', 'Vos rapports :');
		include("vues/v_listeRapports.php");
		break;
		}

	case 'choisirDateMesRapports': {
		$matricule = $_SESSION['matricule'];
		$result = getInfoPraticienParCollaborateur($matricule);
		include("vues/v_fourchetteDates.php");
		break;
	}

	case 'voirRapport': {
		$matricule = $_SESSION['matricule'];
		if(isset($_REQUEST['rapport'])) {
			$rapport = $_REQUEST['rapport'];
		}
		$content = getContenuRapport($rapport, $matricule);
		$presentes = getPresentesRapport($rapport, $matricule);
		var_dump($presentes);
		$offres=getOffresRapport($rapport, $matricule);
		var_dump($offres);
		if(empty($content)){
			include("vues/v_accueil.php");	
		}
		else{
			include("vues/v_rapport.php");	
		}
		break;
	}
	case 'voirRapportsFiltres':{
		if(isset($_REQUEST['dateDeb'])&&!empty($_REQUEST['dateDeb'])&&isset($_REQUEST['dateFin'])&&!empty($_REQUEST['dateFin'])){
			$dateDeb=date_create($_REQUEST['dateDeb']);
			$dateFin=date_create($_REQUEST['dateFin']);
			if(date_diff($dateDeb,$dateFin)->invert==0){
				$matricule = $_SESSION['matricule'];
				$result = getRapportsCollaborateur();
				$result = filtrerParPeriode($result, $matricule, $dateDeb, $dateFin);
				$titre = array('Formulaire de vos rapports', 'Formulaire permettant d\'accéder aux rapports que vous avez rédigé et vos brouillons', 'Vos rapports :');
				include("vues/v_listeRapports.php");
			}
			else {
				header("Location: index.php?uc=rapportdevisite&action=choisirDateMesRapports&erreur=1");
			}
		}
		else{
			header("Location: index.php?uc=rapportdevisite&action=choisirDateMesRapports&erreur=2");
		}
		break;
	}
	default :
	{
		include("vues/v_accueil.php");	
	}
}
?>