<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center">Brouillons de rapport</h1>
            <p class="text text-center">
                Vous trouverez ici tous vos rapports non publiés. Cliquez sur "nouveau rapport" pour en créer un nouveau.
            </p>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5">
                <img class="img-fluid size-img-page" src="assets/img/brouillon.jpg">
            </div>
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3">
                <?php 
                if ($_SESSION['erreur']) {
                    echo '<p class="alert alert-danger text-center w-100">Un problème est survenu lors de la selection du médicament</p>';
                    $_SESSION['erreur'] = false;
                } ?>
                <?php if(count($data)>0){ ?>
                    <form action="" method="get" class="formulaire-recherche col-12 m-0">
                        <input type="text" name="uc" value="rapportdevisite" hidden>
                        <input type="text" name="action" value="saisieRapport" hidden>
                        <label class="titre-formulaire" for="listerapports">Choisissez un rapport à éditer</label>
                        <select required name="rapport" class="form-select mt-3">
                            <option value class="text-center">- Choisissez un rapport -</option>
                            <?php
                            foreach ($data as $key) {
                                    echo '<option value="' . $key[0];
                                    if(isset($key[7])){ echo '§'.$key[7];}
                                    echo '" class="form-control"';    
                                    if(!$key[6]){echo 'style="font-style: italic; color: purple"';}
                                    echo '> Rapport n°' . $key[0] . ' : ' . $key[1] . ' | ' . $key[2] . ' | ' . $key[3] . ' | ' . $key[4] . $key[5] . '</option>';
                            }
                            ?>
                        </select>
                        <input class="btn btn-info text-light valider" type="submit" value="Éditer ce rapport">
                    </form>
                <?php } else { 
                    echo '<p class="alert alert-primary text-center w-100">'.'Vous n\'avez aucun brouillons en cours'.'</p>';
                 } ?>
                 <form method="get">
                    <input type="text" name="uc" value="rapportdevisite" hidden>
                    <input type="text" name="action" value="saisieRapport" hidden>
                    <input type="text" name="new" value="1" hidden>
                    <input type="submit" value="Nouveau rapport" class="btn btn-success text-white">
                 </form>
            </div>
        </div>
    </div>
</section>