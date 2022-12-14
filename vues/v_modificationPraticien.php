<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center">Fiche Praticien <span class="carac"><?php echo $nom; ?></span></h1>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3">
                <form action="index.php?uc=praticien&action=" method="post" class="formulaire form-horizontal">
                    <div class="form-group">
                        <label for="nom" class="control-label col-sm-2">Numéro*</label>
                        <input <?php if ($num!='') {echo 'disabled';} ?> id="num" name="num" value="<?php echo $num ; ?>" class="form-control mb-2">
                    </div>
                    <div class="form-group">
                        <label for="nom" class="control-label col-sm-2">Nom*</label>
                        <input id="nom" name="nom" value="<?php echo $nom ; ?>" required class="form-control mb-2">
                    </div>
                    <div class="form-group">
                        <label for="prenom" class="control-label col-sm-2">Prenom*</label>
                        <input id="prenom" name="prenom" value="<?php echo $prenom ; ?>" required class="form-control mb-2">
                    </div>
                    <div class="form-group">
                        <label for="adresse" class="control-label col-sm-2">Adresse*</label>
                        <input id="adresse" name="adresse" value="<?php echo $adresse ; ?>" required class="form-control mb-2" >
                    </div>
                    <div class="form-group">
                        <label for="cp" class="control-label col-sm-2">Code_postal*</label>
                        <div class="input-group">
                            <select id="depcode" name="depcode" class="form-select col-2 mb-2" required>
                            <?php
                                foreach($depcode as $unDepCode){
                                    $dep = $unDepCode['DEP_NUM'];
                                    if($code==$dep)
                                        echo '<option value="'.$dep.'" selected >'.$dep.'</option>';
                                    else
                                        echo '<option value="'.$dep.'" >'.$dep.'</option>';
                                    }
                            ?>
                            </select>
                            <input id="cp" name="cp" pattern="[0-9]{3}" value="<?php echo $cp ; ?>" title="Donner les trois derniers chiffres du code postal (ex: 450)" required class="form-control mb-2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ville" class="control-label col-sm-2">Ville*</label>
                        <input id="ville" name="ville" value="<?php echo $ville ; ?>" required class="form-control mb-2">
                    </div>
                    <div class="form-group">
                        <label for="region" class="control-label col-sm-2">Regions*</label>
                        <input disabled id="region" name="region" value="<?php echo $region ; ?>" class="form-control mb-2" required> 
                    </div>
                    <div class="form-group">
                        <label for="notor" class="control-label col-sm-2">Notoriété*</label>
                        <input id="notor" name="notor" type="number" value="<?php echo $notor ; ?>" required class="form-control mb-2">
                    </div>
                    <div class="form-group">
                        <label for="type" class="control-label col-sm-2">Type*</label>
                        <select id="region" name="region" class="form-select" required>
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
                    <div class="row text-center">
                        <input class="btn btn-primary text-light valider col-6 col-sm-5 col-md-4 col-lg-3" type="submit" value="Enregistrer" name="enregistrer">
                        <input class="btn btn-danger text-light valider col-7 col-sm-5 col-md-4 col-lg-3 mt-auto" type="reset" value="Réinitialiser" name="reinitialiser">
                        <input class="btn btn-info text-light valider col-6 col-sm-5 col-md-4 col-lg-3 mt-auto" type="button" onclick="history.go(-1)" value="Retour" name="retour">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>