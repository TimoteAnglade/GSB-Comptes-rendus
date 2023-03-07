<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-6 pt-5">
            <h1 class="titre text-center">Fiche Praticien <span class="carac"><?php echo $nom; ?></span></h1>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-9 col-lg-7 col-xl-6 col-xxl-5 py-lg-6 py-4">
                <form action="index.php?uc=praticien&action=enregistrermodif" method="post" class="formulaire form-horizontal">
                    <div class="form-group mb-2">
                        <label for="nom" class="control-label col-sm-2">Numéro*</label>
                        <input id="num" name="num" value="<?php echo $num ; ?>" class="form-control" disabled>
                        <input id="num" name="num" value="<?php echo $num ; ?>" hidden>
                    </div>

                    <div class="form-group mb-2">
                        <label for="nom" class="control-label col-sm-2">Nom*</label>
                        <input id="nom" name="nom" value="<?php echo $nom ; ?>" required class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="prenom" class="control-label col-sm-2">Prenom*</label>
                        <input id="prenom" name="prenom" value="<?php echo $prenom ; ?>" required class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="adresse" class="control-label col-sm-2">Adresse*</label>
                        <input id="adresse" name="adresse" value="<?php echo $adresse ; ?>" required class="form-control" >
                    </div>
                    <div class="form-group mb-2">
                        <label for="cp" class="control-label col-sm-2">Code_postal*</label>
                        <div class="input-group">
                            <select id="depcode" name="depcode" class="form-select" required>
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
                            <input class="form-control" id="cp" name="cp" pattern="[0-9]{3}" value="<?php echo $cp ; ?>" title="Donner les trois derniers chiffres du code postal (ex: 450)" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="ville" class="control-label col-sm-2">Ville*</label>
                        <input id="ville" name="ville" value="<?php echo $ville ; ?>" required class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="region" class="control-label col-sm-2">Regions*</label>
                        <input id="region" name="region" value="<?php echo $region ; ?>" class="form-control" disabled> 
                        <input id="region" name="region" value="<?php echo $region ; ?>" hidden> 
                    </div>
                    <div class="form-group mb-2">
                        <label for="notor" class="control-label col-sm-2">Notoriété*</label> 
                        <div class="input-group">
                            <input id="notor" name="notor" type="number" value="<?php echo $notor ; ?>" required class="form-control" step="0.5">  
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="conf" class="control-label col-sm-2">Confiance</label>
                        <div class="input-group">
                            <input id="conf" name="conf" type="number" value="<?php echo $conf ; ?>" class="form-control" step="0.5">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="type" class="control-label col-sm-2">Type*</label>
                        <select id="type" name="type" class="form-select" required>
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
                    <div class="row form-row">
                        <input class="btn btn-primary text-light valider col-4" type="submit" value="Enregistrer" name="enregistrer">
                        <input class="btn btn-danger text-light valider col-4 mt-auto" type="reset" value="Réinitialiser" name="reinitialiser">
                        <input class="btn btn-info text-light valider col-3 mt-auto" type="button" onclick="history.go(-1)" value="Retour" name="retour">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>