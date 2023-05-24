<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-6 pt-5">
            <h1 class="titre text-center">Fiche Praticien <span class="carac"><?php echo $nom; ?></span></h1>
        </div>

        <?php if ( isset($_SESSION['form']) ) { 
            if ($_SESSION['form'] != "") { ?>
                <div class="alert alert-danger alert-dismissible fade show mx-auto col-5">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button> 
                    Les informations suivantes n'ont pas été complété :
                    <ul>
                        <?php echo $_SESSION['form'];?>
                    </ul>
                </div>
            <?php unset($_SESSION['form']);
            }
        } ?>

        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-12 col-lg-10 col-xl-8 col-xxl-7 py-lg-6 py-4">
                <form name="praticien" action="index.php?uc=praticien&action=<?php echo $action; ?>" method="post" class="formulaire form-horizontal">
                    <P class="text-danger"><strong>*</strong> = Champ obligatoire</P>
                    <div class="form-group mb-2">
                        <label for="nom" class="control-label col-sm-2">Numéro</label>
                        <input id="num" name="num" value="<?php echo $num ; ?>" class="form-control" disabled>
                    </div>

                    <div class="form-group mb-2">
                        <label for="nom" class="control-label col-sm-2">Nom<strong class="text-danger">*</strong></label>
                        <input id="nom" name="nom" value="<?php echo $nom ; ?>" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="prenom" class="control-label col-sm-2">Prenom<strong class="text-danger">*</strong></label>
                        <input id="prenom" name="prenom" value="<?php echo $prenom ; ?>" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="adresse" class="control-label col-sm-2">Adresse<strong class="text-danger">*</strong></label>
                        <input id="adresse" name="adresse" value="<?php echo $adresse ; ?>" class="form-control" >
                    </div>
                    <div class="form-group mb-2">
                        <label for="cp" class="control-label col-sm-2">Code postal<strong class="text-danger">*</strong></label>
                        <div class="input-group">
                            <select id="depcode" name="depcode" class="form-select">
                            <?php
                                foreach($depcode as $unDepCode){
                                    $dep = $unDepCode['DEP_NUM'];
                                    if (strlen($dep)<2) $dep="0".$dep;
                                    if($code==$dep)
                                        echo '<option value="'.$dep.'" selected >'.$dep.'</option>';
                                    else
                                        echo '<option value="'.$dep.'" >'.$dep.'</option>';
                                    }
                            ?>
                            </select>
                            <input class="form-control" id="cp" name="cp" pattern="[0-9]{3}" value="<?php echo $cp ; ?>" title="Donner les trois derniers chiffres du code postal (ex: 450)" maxlenght="3" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="ville" class="control-label col-sm-2">Ville<strong class="text-danger">*</strong></label>
                        <input id="ville" name="ville" value="<?php echo $ville ; ?>" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="region" class="control-label col-sm-2">Regions</label>
                        <input id="region" name="region" value="<?php echo $region ; ?>" class="form-control" disabled> 
                    </div>
                    <div class="form-group mb-2">
                        <label for="notor" class="control-label col-sm-2">Notoriété</label> 
                        <div class="input-group">
                            <input id="notor" name="notor" type="number" value="<?php echo $notor ; ?>" class="form-control" min="0" step="0.0001">  
                            <!--<span class="input-group-text">%</span>-->
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="conf" class="control-label col-sm-2">Confiance</label>
                        <div class="input-group">
                            <input id="conf" name="conf" type="number" value="<?php echo $conf ; ?>" class="form-control" min="0" step="0.01">
                            <!--<span class="input-group-text">%</span>-->
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="type" class="control-label col-sm-2">Type<strong class="text-danger">*</strong></label>
                        <select id="type" name="type" class="form-select">
                            <option value="" class="text-center" selected>- Choisissez un type -</option>
                            <?php 
                                foreach($lesTypes as $unType){
                                    $idType = $unType['TYP_CODE'];
                                    $libType = $unType['TYP_LIBELLE'];
                                    if($type==$libType)
                                        echo '<option value="'.$idType.'" selected >'.$libType.'</option>';
                                    else
                                        echo '<option value="'.$idType.'" >'.$libType.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div id="divspe" class="form-group mb-2">
                        <label for="spe" class="control-label col-sm-4">Spécialitées<strong class="text-danger">*</strong></label>
                        <div class="input-group col-sm-4">
                            <select id="spe" name="spe" class="form-select">
                                <option value="" class="text-center" selected>- Choisissez des spécialitées -</option>
                                <?php 
                                    foreach($lesSpe as $uneSpe){
                                        $idSpe = $uneSpe['SPE_CODE'];
                                        $libSpe = $uneSpe['SPE_LIBELLE'];
                                        echo '<option value="'.$idSpe.'" >'.$libSpe.'</option>';
                                    }
                                ?>
                            </select>
                            <input class="btn btn-secondary text-light" type="button" value="+" onclick="return initSpe()">
                        </div>
                        <?php 
                            if ($lesSpePra != '' && $lesSpePra) {
                                echo "<script> initTabSpe(".json_encode($lesSpePra)."); </script>";
                            }
                        ?>
                    </div>
                    <div class="row form-row">
                        <input class="btn btn-primary text-light valider col-3 mt-auto" type="button" onclick="history.go(-1)" value="Retour" name="retour">
                        <input class="btn btn-danger text-light valider col-4 mt-auto" type="button" value="Réinitialiser" name="reinitialiser" onclick="location.reload();">
                        <input class="btn btn-info text-light valider col-4" type="submit" value="Enregistrer" name="enregistrer" onclick="return validateFormPraticien();" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>