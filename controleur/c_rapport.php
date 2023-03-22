<?php
if(isset($_SESSION['matricule'])){
if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
	$action = "choisirDateMesRapports";
} else {
	$action = $_REQUEST['action'];
}
switch ($action) {
	case 'voirMesRapports': {
		$matricule = $_SESSION['matricule'];
		$result = getRapportsCollaborateur($matricule);
		$data = array();
		$i=0;
		foreach($result as $key){
			$data[$i] = array();
			$data[$i][0] = $key['rap_num'];
			$data[$i][1] = getPraticienRapport($key['rap_num'], $matricule);
			$data[$i][2] = getNomPraticien(getPraticienRapport($key['rap_num'], $matricule));
			$data[$i][3] = getMotifRapport($key['rap_num'], $matricule)['MOT_CODE'];
			$data[$i][4] = getDateRapport($key['rap_num'], $matricule);
			$data[$i][5] = '';
			$data[$i][6]=estBrouillon($key['rap_num'], $matricule);
			$presente = getPresentesRapport($key['rap_num'], $matricule);
			$presenteNom = getPresentesNomRapport($key['rap_num'], $matricule);
			if(!is_null($presente['MED_DEPOTLEGAL'])){
				$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL'] . ' : ' . $presenteNom['med_nomcommercial1'] ;
				if(!is_null($presente['MED_DEPOTLEGAL2'])){
					$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL2'] . ' : ' . $presenteNom['med_nomcommercial2'] ;
				}
			$i++;	
			}		
		}
		$titre = array('Formulaire de vos rapports', 'Formulaire permettant d\'accéder aux rapports que vous avez rédigé et vos brouillons', 'Vos rapports :', 1);
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
		$presentes = getPresentesNomRapport($rapport, $matricule);
		$offres=getOffresRapport($rapport, $matricule);
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
				$result = getRapportsCollaborateur($matricule);
				$result = filtrerParPeriode($result, $matricule, $dateDeb, $dateFin);
				if(!empty($_REQUEST['praticien'])){
					$praticien = $_REQUEST['praticien'];
					$result = filtrerParPraticien($result, $matricule, $praticien);	
				}
				if(count($result)==0){
					header("Location: index.php?uc=rapportdevisite&action=choisirDateMesRapports&erreur=3");
				}
				$data = array();
				$i=0;
				foreach($result as $key){
					$data[$i] = array();
					$data[$i][0] = $key['rap_num'];
					$data[$i][1] = getPraticienRapport($key['rap_num'], $matricule);
					$data[$i][2] = getNomPraticien(getPraticienRapport($key['rap_num'], $matricule));
					$data[$i][3] = getMotifRapport($key['rap_num'], $matricule)['MOT_CODE'];
					$data[$i][4] = getDateRapport($key['rap_num'], $matricule);
					$data[$i][5] = '';
					$presente = getPresentesRapport($key['rap_num'], $matricule);
					$presenteNom = getPresentesNomRapport($key['rap_num'], $matricule);
					if(!is_null($presente['MED_DEPOTLEGAL'])){
						$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL'] . ' : ' . $presenteNom['med_nomcommercial1'] ;
						if(!is_null($presente['MED_DEPOTLEGAL2'])){
							$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL2'] . ' : ' . $presenteNom['med_nomcommercial2'] ;
						}
					}	
					$data[$i][6]=estBrouillon($key['rap_num'], $matricule);
					$i++;		
				}
				$titre = array('Formulaire de vos rapports', 'Formulaire permettant d\'accéder aux rapports que vous avez rédigé et vos brouillons', 'Vos rapports :', 1);
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
	case 'nouveauRapportsRegion':{
		$matricule = $_SESSION['matricule'];
		$result = getRapports($matricule);
		$data = array();
		$i=0;
		foreach($result as $key){
			$data[$i] = array();
			$data[$i][0] = $key['rap_num'];
			$data[$i][1] = getPraticienRapport($key['rap_num'], $matricule);
			$data[$i][2] = getNomPraticien(getPraticienRapport($key['rap_num'], $matricule));
			$data[$i][3] = getMotifRapport($key['rap_num'], $matricule)['MOT_CODE'];
			$data[$i][4] = getDateRapport($key['rap_num'], $matricule);
			$data[$i][5] = '';
			$data[$i][6]=estBrouillon($key['rap_num'], $matricule);
			$presente = getPresentesRapport($key['rap_num'], $matricule);
			$presenteNom = getPresentesNomRapport($key['rap_num'], $matricule);
			if(!is_null($presente['MED_DEPOTLEGAL'])){
				$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL'] . ' : ' . $presenteNom['med_nomcommercial1'] ;
				if(!is_null($presente['MED_DEPOTLEGAL2'])){
					$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL2'] . ' : ' . $presenteNom['med_nomcommercial2'] ;
				}
			$i++;	
			}		
		}
		$titre = array('Formulaire de vos rapports', 'Formulaire permettant d\'accéder aux rapports que vous avez rédigé et vos brouillons', 'Vos rapports :', 1);
		include("vues/v_listeRapports.php");
		break;
	}
	default :
	{
		include("vues/v_accueil.php");	
	}
}
}
else{
	include("vues/v_accueil.php");	
}
?>