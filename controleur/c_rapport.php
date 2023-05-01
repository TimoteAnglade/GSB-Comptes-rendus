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
			$data[$i][0] = $key['RAP_NUM'];
			$data[$i][1] = getPraticienRapport($key['RAP_NUM'], $matricule);
			$data[$i][2] = getNomPraticien(getPraticienRapport($key['RAP_NUM'], $matricule));
			$data[$i][3] = getMotifRapport($key['RAP_NUM'], $matricule)['MOT_CODE'];
			$data[$i][4] = getDateRapport($key['RAP_NUM'], $matricule);
			$data[$i][5] = '';
			$data[$i][6]=estBrouillon($key['RAP_NUM'], $matricule);
			$presente = getPresentesRapport($key['RAP_NUM'], $matricule);
			$presenteNom = getPresentesNomRapport($key['RAP_NUM'], $matricule);
			if(!is_null($presente['MED_DEPOTLEGAL'])){
				$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL'] . ' : ' . $presenteNom['med_nomcommercial1'] ;
				if(!is_null($presente['MED_DEPOTLEGAL2'])){
					$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL2'] . ' : ' . $presenteNom['med_nomcommercial2'] ;
				}
			}	
			$i++;	
		}
		$titre = array('Formulaire de vos rapports', 'Formulaire permettant d\'accéder aux rapports que vous avez rédigé et vos brouillons', 'Vos rapports :', 1, 'Vous n\'avez rédigé aucun rapport pour l\'instant');
		include("vues/v_listeRapports.php");
		break;
		}

	case 'choisirDateMesRapports': {
		$matricule = $_SESSION['matricule'];
		$result = getInfoPraticienParCollaborateur($matricule);
		$titre = array(0, 'Choisissez une période','Choisissez une période parmi laquelle vous voulez voir vos rapports');
		include("vues/v_fourchetteDates.php");
		break;
	}

	case 'voirRapport': {
		$matricule = $_SESSION['matricule'];
		if(isset($_REQUEST['rapport'])) {
			$chaine = $_REQUEST['rapport'].'§';
		}
		$rapportMatricule = explode('§', $chaine);
		$rapport = $rapportMatricule[0];
		$mat2 = $rapportMatricule[1];
		if(empty($mat2)){
			$mat=$matricule;
		}
		else{
			$mat=$mat2;
		}
		if(estAutorise($rapport, $mat, $matricule)){
			$content = getContenuRapport($rapport, $mat);
			$presentes = getPresentesNomRapport($rapport, $mat);
			$offres=getOffresRapport($rapport, $mat);	
			lire($rapport, $mat, $matricule);
		}
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
		$result = getRapportsRegion($matricule);
		$result = filtrerParLu($result, $matricule);
		$data = array();
		$i=0;
		foreach($result as $key){
			$data[$i] = array();
			$data[$i][0] = $key['rap_num'];
			$data[$i][1] = getPraticienRapport($key['rap_num'], $key['col_matricule']);
			$data[$i][2] = getNomPraticien(getPraticienRapport($key['rap_num'], $key['col_matricule']));
			$data[$i][3] = getMotifRapport($key['rap_num'], $key['col_matricule'])['MOT_CODE'];
			$data[$i][4] = getDateRapport($key['rap_num'], $key['col_matricule']);
			$data[$i][5] = '';
			$data[$i][6] = estBrouillon($key['rap_num'], $key['col_matricule']);
			$data[$i][7] = $key['col_matricule'];
			$presente = getPresentesRapport($key['rap_num'], $key['col_matricule']);
			$presenteNom = getPresentesNomRapport($key['rap_num'], $key['col_matricule']);
			if(!is_null($presente['MED_DEPOTLEGAL'])){
				$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL'] . ' : ' . $presenteNom['med_nomcommercial1'] ;
				if(!is_null($presente['MED_DEPOTLEGAL2'])){
					$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL2'] . ' : ' . $presenteNom['med_nomcommercial2'] ;
				}
			$i++;	
			}		
		}
		$titre = array('Nouveaux rapports de votre région', 'Formulaire permettant d\'accéder aux rapports non-lus qui ont été publiés dans votre région', 'Les rapports :', 1, 'Il n\'y a aucun rapport non-lu dans votre région');
		include("vues/v_listeRapports.php");
		break;
	}
	case 'historiqueFourchette' :{
		$matricule = $_SESSION['matricule'];
		$result = getInfoCollaborateurParDelegue($matricule);
		$titre = array(1, 'Choisissez une période','Choisissez une période parmi laquelle vous voulez voir les rapports de votre région');
		include("vues/v_fourchetteDates.php");
		break;
	}
	case 'voirHistoriqueFiltre':{
		if(isset($_REQUEST['dateDeb'])&&!empty($_REQUEST['dateDeb'])&&isset($_REQUEST['dateFin'])&&!empty($_REQUEST['dateFin'])){
			$dateDeb=date_create($_REQUEST['dateDeb']);
			$dateFin=date_create($_REQUEST['dateFin']);
			if(date_diff($dateDeb,$dateFin)->invert==0){
				$matricule = $_SESSION['matricule'];
				$result = getRapportsRegion($matricule);
				$result = filtrerParPeriode($result, $matricule, $dateDeb, $dateFin, 1);
				if(isset($_REQUEST['collaborateur'])&&!empty($_REQUEST['collaborateur'])){
					$collaborateur = $_REQUEST['collaborateur'];
					$result = filtrerParCollaborateur($result, $matricule, $collaborateur);	
				}
				if(count($result)==0){
					header("Location: index.php?uc=rapportdevisite&action=historiqueFourchette&erreur=3");
				}
				$data = array();
				$i=0;
				foreach($result as $key){
					$data[$i] = array();
					$data[$i][0] = $key['rap_num'];
					$data[$i][1] = getPraticienRapport($key['rap_num'], $key['col_matricule']);
					$data[$i][2] = getNomPraticien(getPraticienRapport($key['rap_num'], $key['col_matricule']));
					$data[$i][3] = getMotifRapport($key['rap_num'], $key['col_matricule'])['MOT_CODE'];
					$data[$i][4] = getDateRapport($key['rap_num'], $key['col_matricule']);
					$data[$i][5] = '';
					$presente = getPresentesRapport($key['rap_num'], $key['col_matricule']);
					$presenteNom = getPresentesNomRapport($key['rap_num'], $key['col_matricule']);
					if(!is_null($presente['MED_DEPOTLEGAL'])){
						$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL'] . ' : ' . $presenteNom['med_nomcommercial1'] ;
						if(!is_null($presente['MED_DEPOTLEGAL2'])){
							$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL2'] . ' : ' . $presenteNom['med_nomcommercial2'] ;
						}
					}	
					$data[$i][6]=estBrouillon($key['rap_num'], $key['col_matricule']);
					$data[$i][7] = $key['col_matricule'];
					$i++;		
				}
				$titre = array('Formulaire de vos rapports', 'Formulaire permettant d\'accéder aux rapports que vous avez rédigé et vos brouillons', 'Vos rapports :', 1);
				include("vues/v_listeRapports.php");
			}
			else {
				ob_clean();
				header("Location: index.php?uc=rapportdevisite&action=historiqueFourchette&erreur=1");
			}
		}
		else{
			ob_clean();
			header("Location: index.php?uc=rapportdevisite&action=historiqueFourchette&erreur=2");
		}
		break;
	}
	case 'listeBrouillons':
	{
		$matricule = $_SESSION['matricule'];
		$result=getRapportsCollaborateur($matricule);
		$result=filtrerParBrouillon($result, $matricule);
		$data = array();
		$i=0;
		foreach($result as $key){
			$data[$i] = array();
			$data[$i][0] = $key['RAP_NUM'];
			$data[$i][1] = getPraticienRapport($key['RAP_NUM'], $matricule);
			$data[$i][2] = getNomPraticien(getPraticienRapport($key['RAP_NUM'], $matricule));
			$data[$i][3] = getMotifRapport($key['RAP_NUM'], $matricule)['MOT_CODE'];
			$data[$i][4] = getDateRapport($key['RAP_NUM'], $matricule);
			$data[$i][5] = '';
			$data[$i][6]=estBrouillon($key['RAP_NUM'], $matricule);
			$presente = getPresentesRapport($key['RAP_NUM'], $matricule);
			$presenteNom = getPresentesNomRapport($key['RAP_NUM'], $matricule);
			if(!is_null($presente['MED_DEPOTLEGAL'])){
				$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL'] . ' : ' . $presenteNom['med_nomcommercial1'] ;
				if(!is_null($presente['MED_DEPOTLEGAL2'])){
					$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL2'] . ' : ' . $presenteNom['med_nomcommercial2'] ;
				}
			}	
			$i++;	
		}
		include('vues/v_listeRapportsBrouillons.php');
		break;
	}
	case 'saisieRapport':
	{
		$isRapport = isset($_REQUEST['rapport']);
		$isNew = isset($_REQUEST['new']);
		if($isRapport||$isNew){
			$matricule = $_SESSION['matricule'];
			$region = getRegionCollaborateur($matricule);
			$praticiens=getInfoPraticienParRegion($region);
			if($isRapport){
				if(estBrouillon($_REQUEST['rapport'], $matricule)){
					$rapport=$_REQUEST['rapport'];
					$prerempli = getContenuRapport($rapport, $matricule);
					$prerempli['matricule'] = $matricule;
				}
				else{
					$isNew = 1;
				}
			}
			if($isNew){
				$prerempli = array(
					'matricule' => $matricule,
					'rap_num' => NULL, 
					'col_nom' => NULL, 
					'col_prenom' => NULL, 
					'pra_num_praticien' => NULL, 
					'pra_nom' => NULL, 
					'pra_prenom' => NULL, 
					'pra_num_remplacant' => NULL, 
					'pra_rem_nom' => NULL, 
					'pra_rem_prenom' => NULL, 
					'rap_date' => NULL, 
					'rap_bilan' => NULL, 
					'mot_code' => NULL, 
					'rap_motif_autre' => NULL, 
					'rap_definitif' => NULL, 
					'med_depotlegal' => NULL, 
					'med_depotlegal2' => NULL, 
				);
			}
			var_dump($prerempli);
			$motifs = getAllMotifs();
			$medocs = getAllNomMedicament();
			include("vues/v_saisieRapport.php");
		}
		else {
			include("vues/v_accueil.php");
		}
		break;
	}
	case "confirmerRapport" :
	{
		$matricule = $_REQUEST['matricule'];
		$rapport = $_REQUEST['rapport'];
		$praticien = $_REQUEST['praticien'];
		$praticienremp = $_REQUEST['praticienremp'];
		$bilanContent = $_REQUEST['bilanContent'];
		$medicamentproposer = $_REQUEST['medicamentproposer'];
		$medicamentproposer2 = $_REQUEST['medicamentproposer2'];
		$motifautre = $_REQUEST['motif-autre'];
		$echantillions=[];
		if($_REQUEST['echantillions']=='on'){
			for($i=1;$i<=10;) {
				$echantillion[] = $_REQUEST['variable'+$i]
			}
		}
		$matricule = $_REQUEST['matricule'];
		$matricule = $_REQUEST['matricule'];
		$matricule = $_REQUEST['matricule'];
		$matricule = $_REQUEST['matricule'];
		$matricule = $_REQUEST['matricule'];
		//ajoutOuModif();
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