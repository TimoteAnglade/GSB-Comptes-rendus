<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center">Fiche du Praticien <span class="carac"><?php echo $carac[1]; ?></span></h1>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3">
                <form action="index.php?uc=praticien&action=" method="post" class="formulaire form-horizontal">
                    <h2 class="titre text-center">Fiche Praticien </h2>
                    <div class="form-group">
                        <label for="nom" class="control-label col-sm-2">Numéro*</label>
                        <input disabled id="num" name="num" value="<?php echo $carac[0]; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nom" class="control-label col-sm-2">Nom*</label>
                        <input id="nom" name="nom" value="<?php echo $carac[1]; ?>" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="prenom" class="control-label col-sm-2">Prenom*</label>
                        <input id="prenom" name="prenom" value="<?php echo $carac[2]; ?>" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="adresse" class="control-label col-sm-2">Adresse*</label>
                        <input id="adresse" name="adresse" value="<?php echo $carac[3]; ?>" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="cp" class="control-label col-sm-2">Code_postal*</label>
                        <input id="cp" name="cp" pattern="[0-9]{5}" value="<?php echo $carac[4]; ?>" title="5 chiffres (ex: 45000)" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="ville" class="control-label col-sm-2">Ville*</label>
                        <input id="ville" name="ville" value="<?php echo $carac[5]; ?>" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="region" class="control-label col-sm-2">Regions* ( <?php echo $region; ?> )</label>
                        <select id="region" name="region" class="form-select mt-3" required> 
                            <?php $lesRegions = getLesRegions();
                                foreach($lesRegions as $laRegion){
                                    $idRegion = $laRegion['REG_CODE'];
                                    $libRegion = $laRegion['REG_NOM'];
                                    if($region==$libRegion)
                                        echo '<option value="'.$idRegion.'" selected >'.$libRegion.'</option>';
                                    else
                                        echo '<option value="'.$idRegion.'" >'.$libRegion.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="notor" class="control-label col-sm-2">Notoriété* ( en % )</label>
                        <input id="notor" name="notor" type="number" value="<?php echo $carac[6]; ?>" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="type" class="control-label col-sm-2">Type*</label>
                        <select id="region" name="region" class="form-select mt-3" required>
                            <?php $lesTypes = getLesTypes();
                                foreach($lesTypes as $unType){
                                    $idType = $unType['TYP_CODE'];
                                    $libType = $unType['TYP_LIBELLE'];
                                    if($carac[7]==$libType)
                                        echo '<option value="'.$idType.'" selected >'.$libType.'</option>';
                                    else
                                        echo '<option value="'.$idType.'" >'.$libType.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="row align-items-center justify-content-center">
                        <input class="btn btn-primary text-light valider col-6 col-sm-5 col-md-4 col-lg-3" type="submit" value="Modifier" name="modifier">
                        <input class="btn btn-danger text-light valider col-7 col-sm-5 col-md-4 col-lg-3" type="reset" value="Réinitialiser" name="reinitialiser">
                        <input class="btn btn-info text-light valider col-6 col-sm-5 col-md-4 col-lg-3" type="button" onclick="history.go(-1)" value="Retour">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>