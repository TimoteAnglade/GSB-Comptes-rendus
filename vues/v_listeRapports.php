<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center"><?php echo $titre[0];?></h1>
            <p class="text text-center">
                <?php echo $titre[1];?>
            </p>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5">
                <img class="img-fluid size-img-page" src="assets/img/paperasse.jpg">
            </div>
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3">
                <?php if ($_SESSION['erreur']) {
                    echo '<p class="alert alert-danger text-center w-100">Un problème est survenu lors de la selection du médicament</p>';
                    $_SESSION['erreur'] = false;
                } ?>
                <form action="" method="get" class="formulaire-recherche col-12 m-0">
                    <input type="text" name="uc" value="rapportdevisite" hidden>
                    <input type="text" name="action" value="voirRapport" hidden>
                    <label class="titre-formulaire" for="listerapports"><?php echo $titre[2];?></label>
                    <select required name="rapport" class="form-select mt-3">
                        <option value class="text-center">- Choisissez un rapport -</option>
                        <?php
                        foreach ($data as $key) {
                            if(($titre[3]==1 && $key[6]==1) || $key[6]==0){
                                echo '<option value="' . $key[0] . '" class="form-control"';    
                                if($key[6]){echo 'style="font-style: italic; color: purple"';}
                                echo '> Rapport n°' . $key[0] . ' : ' . $key[1] . ' | ' . $key[2] . ' | ' . $key[3] . ' | ' . $key[4] . $key[5] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <input class="btn btn-info text-light valider" type="submit" value="Afficher ce rapport">
                </form>
            </div>
        </div>
    </div>
</section>