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
					$data[$i][0] = $key['RAP_NUM'];
					$data[$i][1] = getPraticienRapport($key['RAP_NUM'], $matricule);
					$data[$i][2] = getNomPraticien(getPraticienRapport($key['RAP_NUM'], $matricule));
					$data[$i][3] = getMotifRapport($key['RAP_NUM'], $matricule)['MOT_CODE'];
					$data[$i][4] = getDateRapport($key['RAP_NUM'], $matricule);
					$data[$i][5] = '';
					$presente = getPresentesRapport($key['RAP_NUM'], $matricule);
					$presenteNom = getPresentesNomRapport($key['RAP_NUM'], $matricule);
					if(!is_null($presente['MED_DEPOTLEGAL'])){
						$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL'] . ' : ' . $presenteNom['med_nomcommercial1'] ;
						if(!is_null($presente['MED_DEPOTLEGAL2'])){
							$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL2'] . ' : ' . $presenteNom['med_nomcommercial2'] ;
						}
					}	
					$data[$i][6]=estBrouillon($key['RAP_NUM'], $matricule);
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
			$data[$i][0] = $key['RAP_NUM'];
			$data[$i][1] = getPraticienRapport($key['RAP_NUM'], $key['col_matricule']);
			$data[$i][2] = getNomPraticien(getPraticienRapport($key['RAP_NUM'], $key['col_matricule']));
			$data[$i][3] = getMotifRapport($key['RAP_NUM'], $key['col_matricule'])['MOT_CODE'];
			$data[$i][4] = getDateRapport($key['RAP_NUM'], $key['col_matricule']);
			$data[$i][5] = '';
			$data[$i][6] = estBrouillon($key['RAP_NUM'], $key['col_matricule']);
			$data[$i][7] = $key['col_matricule'];
			$presente = getPresentesRapport($key['RAP_NUM'], $key['col_matricule']);
			$presenteNom = getPresentesNomRapport($key['RAP_NUM'], $key['col_matricule']);
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
					$data[$i][0] = $key['RAP_NUM'];
					$data[$i][1] = getPraticienRapport($key['RAP_NUM'], $key['col_matricule']);
					$data[$i][2] = getNomPraticien(getPraticienRapport($key['RAP_NUM'], $key['col_matricule']));
					$data[$i][3] = getMotifRapport($key['RAP_NUM'], $key['col_matricule'])['MOT_CODE'];
					$data[$i][4] = getDateRapport($key['RAP_NUM'], $key['col_matricule']);
					$data[$i][5] = '';
					$presente = getPresentesRapport($key['RAP_NUM'], $key['col_matricule']);
					$presenteNom = getPresentesNomRapport($key['RAP_NUM'], $key['col_matricule']);
					if(!is_null($presente['MED_DEPOTLEGAL'])){
						$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL'] . ' : ' . $presenteNom['med_nomcommercial1'] ;
						if(!is_null($presente['MED_DEPOTLEGAL2'])){
							$data[$i][5] = $data[$i][5] . ' | ' . $presente['MED_DEPOTLEGAL2'] . ' : ' . $presenteNom['med_nomcommercial2'] ;
						}
					}	
					$data[$i][6]=estBrouillon($key['RAP_NUM'], $key['col_matricule']);
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
		if($isRapport){
			$isRapport=!empty($_REQUEST['rapport']);
		}
		$isNew = !$isRapport||isset($_REQUEST['new']);
		if($isRapport||$isNew){
			$matricule = $_SESSION['matricule'];
			$region = getRegionCollaborateur($matricule);
			$praticiens=getInfoPraticienParRegion($region);
			if($isRapport){
				if((estBrouillon($_REQUEST['rapport'], $matricule))){
					$rapport=$_REQUEST['rapport'];
					$prerempli = getContenuRapport($rapport, $matricule);
					$prerempli['matricule'] = $matricule;
					$echantillions = getEchantillions($rapport, $matricule);
					$listeEch = "[{},";
					$i=1;
                    foreach($echantillions as $ech){
                        $listeEch=$listeEch.'{'.'medCode:"'.$ech['MED_DEPOTLEGAL'].'", medNom:"'.$ech['MED_NOMCOMMERCIAL'].'", qte:"'.$ech['OFF_QTE'].'"},';
                        $i++;
                    }
                    for($i; $i<=10; $i++){
                    	$listeEch=$listeEch.'{medCode:"", medNom:"", qte:"1"},';
                    }
                        $listeEch=$listeEch."]";
				}
				else{
					$isNew = 1;
				}
			}
			if($isNew){
				$prerempli = array(
					'matricule' => $matricule,
					'RAP_NUM' => "", 
					'col_nom' => "", 
					'col_prenom' => "", 
					'pra_num_praticien' => "", 
					'pra_nom' => "", 
					'pra_prenom' => "", 
					'pra_num_remplacant' => "", 
					'pra_rem_nom' => "", 
					'pra_rem_prenom' => "", 
					'rap_date' => "", 
					'rap_bilan' => "", 
					'mot_code' => "", 
					'rap_motif_autre' => "", 
					'rap_definitif' => "", 
					'med_depotlegal' => "", 
					'med_depotlegal2' => "", 
				);
				$echantillions= [];
				$listeEch='[{},{medCode:"", medNom:"", qte:"1"},{medCode:"", medNom:"", qte:"1"},{medCode:"", medNom:"", qte:"1"},{medCode:"", medNom:"", qte:"1"},{medCode:"", medNom:"", qte:"1"},{medCode:"", medNom:"", qte:"1"},{medCode:"", medNom:"", qte:"1"},{medCode:"", medNom:"", qte:"1"},{medCode:"", medNom:"", qte:"1"},{medCode:"", medNom:"", qte:"1"},{medCode:"", medNom:"", qte:"1"},]';
			}
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
		if(isset($_REQUEST['matricule'])){
			if($_REQUEST['matricule']!="default"){
				$matricule = $_REQUEST['matricule'];	
			}
			else{
				$matricule = "";
			}
		}
		else{
			$matricule = "";
		}

		$isNew=false;
		if(isset($_REQUEST['rapport'])){
			if(empty($_REQUEST['rapport'])){
				$rapport = getNouveauRapNum();
				$isNew=true;
			}
			else{
				$rapport = $_REQUEST['rapport'];
			}
		}
		else{
			$rapport = getNouveauRapNum();
			$isNew=false;
		}
		
		if(isset($_REQUEST['praticien'])){
			if($_REQUEST['praticien']!="default"){
				$praticien = $_REQUEST['praticien'];	
			}
			else{
				$praticien = "";
			}
		}
		else{
			$praticien = "";
		}
		
		if(isset($_REQUEST['praticienremp'])){
			$praticienremp = $_REQUEST['praticienremp'];
			if($praticienremp!="default"&&$praticienremp!=$praticien){
				$praticienremp = $_REQUEST['praticienremp'];	
			}
			else{
				$praticienremp = "";
			}
		}
		else{
			$praticienremp = "";
		}
		
		if(isset($_REQUEST['bilanContent'])){
			$bilanContent = $_REQUEST['bilanContent'];
		}
		else{
			$bilanContent = "";
		}
		
		if(isset($_REQUEST['medicamentproposer'])){
			if($_REQUEST['medicamentproposer']!="default"){
				$medicamentproposer = $_REQUEST['medicamentproposer'];	
			}
			else{
				$medicamentproposer = "";
			}
		}
		else{
			$medicamentproposer = "";
		}
		
		if(isset($_REQUEST['medicamentproposer2'])){
			if($_REQUEST['medicamentproposer2']!="default"){
				$medicamentproposer2 = $_REQUEST['medicamentproposer2'];	
			}
			else{
				$medicamentproposer2 = "";
			}
		}
		else{
			$medicamentproposer2 = "";
		}
		
		if(isset($_REQUEST['motif'])){
			if($_REQUEST['matricule']!="default"){
				$motif = $_REQUEST['motif'];	
			}
			else{
				$motif = "";
			}
		}
		else{
			$motif = "";
		}
		
		if(isset($_REQUEST['motif-autre'])){
			$motifautre = $_REQUEST['motif-autre'];
		}
		else{
			$motifautre = "";
		}
		
		if(isset($_REQUEST['dateVis'])){
			$dateVis = $_REQUEST['dateVis'];
		}
		else{
			$dateVis = "";
		}
		
		if(isset($_REQUEST['brouillon'])){
			$brouillon = $_REQUEST['brouillon'];
		}
		else{
			$brouillon = 1;
		}

		
		if(isset($_REQUEST['echantillions'])){
			$boolEchantillion = $_REQUEST['echantillions'];
		}
		else{
			$boolEchantillion = 'off';
		}

		$echantillions=[];
		if($boolEchantillion=='on'){
			for($i=1;$i<=10;$i++) {
				if(isset($_REQUEST['echantillonadd'.$i])){
					$echantillions[] = [$_REQUEST['echantillonadd'.$i], $_REQUEST['number'.$i]];
				}
			}
		}
		$donnees=[
			'matricule' => $matricule,
			'rapport' => $rapport,
			'praticien' => $praticien,
			'praticienremp' => $praticienremp,
			'bilanContent' => $bilanContent,
			'medicamentproposer' => $medicamentproposer,
			'medicamentproposer2' => $medicamentproposer2,
			'motif' => $motif,
			'motifautre' => $motifautre,
			'dateVis' => $dateVis,
			'brouillon' => $brouillon,
			'echantillions' => $echantillions,
			'isNew' => $isNew,
		];
		if(ajoutOuModif($donnees)){			
			header('Location: ?uc=rapportdevisite&action=voirRapport&rapport='.$donnees['rapport']);
		}
		else{
			echo '<script>history.go("-1");</script>';
		}
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