<?php
//var_dump($_SESSION);
if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
	$action = "formulairepraticien";
} else {
	$action = $_REQUEST['action'];
}
switch ($action) {
	case 'formulairepraticien': {
			$result = getInfoPraticien();
			$word = "Formulaire de praticien";
			$quote = "d'afficher";
			$button = "Afficher";
			include("vues/v_formulairePraticien.php");
			break;
		}

	case 'afficherpraticien': {
		if (isset($_REQUEST['praticien']) && getAllInfoPraticien($_REQUEST['praticien'])) {
			$pra = $_REQUEST['praticien'];
			$carac = getAllInfoPraticien($pra);
			$code = substr($carac[4],0,2);
			$regfonc = getRegionParDep($code);
			$region = $regfonc['REG_NOM'];
			$lesSpePra=getSpePraticien($pra);
			include("vues/v_afficherPraticien.php");
		} else {
			$_SESSION['erreur'] = true;
			ob_clean();
			header("Location: index.php?uc=praticien&action=formulairepraticien");
		}
		break;
	}
	case 'gererpraticien': {
		unset($_SESSION['PraNumModifier']);
		$depcode = getDepartement($_SESSION['codeR']);
		$code = $_SESSION['codeR'];
		$result = getInfoPraticienParRegion($code);
		$word = "Gestion des praticien";
		$quote = "d'afficher et de gérer";
		$button = "Modifier";
		include("vues/v_formulairePraticien.php");
		break;
	}
	case 'ajouterpraticien': {
			$region = $_SESSION['region'];
			$depcode = getDepartement($_SESSION['codeR']);
			// var_dump(getNumInutilisee());
			$num=getNumInutilisee();
			$nom='';$prenom='';$adresse='';$cp='';$ville='';$notor='0';$conf='0';$type='';$lesSpePra='';
			$lesTypes = getLesTypes();
			$lesSpe = getSpecialite();
			$action="insertmodif";
			include("vues/v_modificationPraticien.php");
			break;
		}
	case 'modifierpraticien': {
		if (isset($_SESSION['PraNumModifier'])) {
			$_POST['praticien']=$_SESSION['PraNumModifier'];
		}
		if (isset($_POST['praticien']) && getAllInfoPraticien($_POST['praticien'])) {
			$pra = $_POST['praticien'];
			$carac = getAllInfoPraticien($pra);
			$code = substr($carac[4],0,2);
			$depcode = getDepartement($_SESSION['codeR']);
			$region = $_SESSION['region'];
			$num=$carac[0];$nom=$carac[1];$prenom=$carac[2];$adresse=$carac[3];$cp=substr($carac[4],2,5);$ville=$carac[5];$notor=$carac[6];$conf=$carac[7];$type=$carac[8];
			$_SESSION['PraNumModifier']=$num;
			$spe = getSpePraticien($num);
			//var_dump($spe);
			$lesSpePra = array();
			foreach ($spe as $uneSpe) {
				$lesSpePra[$uneSpe['SPE_CODE']] = array('lib' => $uneSpe['SPE_LIBELLE'],'dipl' => $uneSpe['POS_DIPLOME'],'coef' => $uneSpe['POS_COEFPRESCRIPTION']);
			}
			//var_dump($lesSpePra);
			$lesTypes = getLesTypes();
			$lesSpe = getSpecialite();
			$action="updatemodif";
			include("vues/v_modificationPraticien.php");
		} else {
			$_SESSION['erreur'] = true;
			ob_clean();
			header("Location: index.php?uc=praticien&action=gererpraticien");
		}
		break;
	}
	case 'insertmodif': {
		//var_dump($_POST);
		if(isPostModifPraticienBon()){
			if ($_POST['notor']>=0 && $_POST['conf']>=0) {
				$num = getNumInutilisee();
				$region = $_SESSION['region'];
				$nom=$_POST['nom'];$prenom=$_POST['prenom'];$adresse=$_POST['adresse'];$code=$_POST['depcode'];$cp=$_POST['cp'];$ville=$_POST['ville'];$notor=$_POST['notor'];$conf=$_POST['conf'];$type=$_POST['type'];$depcode=getDepartement($_SESSION['codeR']);
				$cp=$code.$cp;

				$lesSpePra = array();
				foreach ($_POST as $key => $value){
					$pos = strpos($key,"dip");
					if($pos){
						$idSpe = strstr($key,"dip",true);
						$spe[$idSpe] = array('dipl' => $_POST[$idSpe."dip"],'coef' => $_POST[$idSpe."coef"]);
					}
				}
				//var_dump($spe);
				$tmp=insertPraticien($num,$nom,$prenom,$adresse,$cp,$ville,$notor,$conf,$type);
				$tmp= $tmp && addSpecialite($num,$spe);
				if ($tmp) {
					$_SESSION['rajout'] = "<strong>".$nom."</strong> a bien été ajouté";
					ob_clean();
					header("Location: index.php?uc=praticien&action=gererpraticien");
				} else {
					$_SESSION['erreur'] = true;
					$lesTypes = getLesTypes();
					$lesSpe = getSpecialite();
					$spe = getSpePraticien($num);
					//var_dump($spe);
					$lesSpePra = array();
					foreach ($spe as $uneSpe) {
						$lesSpePra[$uneSpe['SPE_CODE']] = array('lib' => $uneSpe['SPE_LIBELLE'],'dipl' => $uneSpe['POS_DIPLOME'],'coef' => $uneSpe['POS_COEFPRESCRIPTION']);
					}
					//var_dump($lesSpePra);
					include("vues/v_modificationPraticien.php");
				}
			} else {
				ob_clean();
				header("Location: index.php?uc=praticien&action=ajouterpraticien");
			}
		} else {
			if ($_POST['type'] == '') {
				$action = "gererpraticien";
			} else {
				$_SESSION['form']= msgErrorFormPraticien();
				$action = "ajouterpraticien";
			}
			ob_clean();
			header("Location: index.php?uc=praticien&action=".$action);
		}
		break;
	}
	case 'updatemodif':{
		//var_dump($_POST);
		if(isPostModifPraticienBon()) {
			if ($_POST['notor']>=0 && $_POST['conf']>=0) {
				$num = $_SESSION['PraNumModifier'] ;
				$region = $_SESSION['region'];
				$nom=$_POST['nom'];$prenom=$_POST['prenom'];$adresse=$_POST['adresse'];$code=$_POST['depcode'];$cp=$_POST['cp'];$ville=$_POST['ville'];$notor=$_POST['notor'];$conf=$_POST['conf'];$type=$_POST['type'];$depcode=getDepartement($_SESSION['codeR']);
				$cp=$code.$cp;

				$spe = array();
				foreach ($_POST as $key => $value){
					$pos = strpos($key,"dip");
					if($pos){
						$idSpe = strstr($key,"dip",true);
						$spe[$idSpe] = array('dipl' => $_POST[$idSpe."dip"],'coef' => $_POST[$idSpe."coef"]);
					}
				}
				//var_dump($spe);
				$tmp=updatePraticien($num,$nom,$prenom,$adresse,$cp,$ville,$notor,$conf,$type) && updateSpe($num,$spe);
				if ($tmp) {
					$_SESSION['rajout'] = "<strong>".$nom."</strong> a bien été modifié";
					unset($_SESSION['PraNumModifier']);
					ob_clean();
					header("Location: index.php?uc=praticien&action=gererpraticien");
				} else {
					$_SESSION['erreur'] = true;
					$lesTypes = getLesTypes();
					$lesSpe = getSpecialite();
					$spe = getSpePraticien($num);
					//var_dump($spe);
					$lesSpePra = array();
					foreach ($spe as $uneSpe) {
						$lesSpePra[$uneSpe['SPE_CODE']] = array('lib' => $uneSpe['SPE_LIBELLE'],'dipl' => $uneSpe['POS_DIPLOME'],'coef' => $uneSpe['POS_COEFPRESCRIPTION']);
					}
					//var_dump($lesSpePra);
					include("vues/v_modificationPraticien.php");
				}
			} else {
				ob_clean();
				header("location: index.php?uc=praticien&action=modifierpraticien");
			}
		} else {
			if ($_POST['type']== '') {
				unset($_SESSION['PraNumModifier']);
				$action = "gererpraticien";
			} else {
				$_SESSION['form']= msgErrorFormPraticien();
				$action = "modifierpraticien";
			}
			ob_clean();
			header("Location: index.php?uc=praticien&action=".$action);
		}
		break;
	}

	default: {
		ob_clean();
		header('location: index.php?uc=connexion&action=connexion');
		break;
	}
}
?>