<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center"><?php echo $word ;?></h1>
            <p class="text text-center">
                Formulaire permettant <?php echo $quote ;?> toutes les informations
                à propos d'un praticien en particulier.
            </p>
        </div>
        <?php
            if ($_SESSION['rajout']) { 
                echo '<div class="alert alert-success alert-dismissible fade show mx-auto col-4">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button> 
                    '.$_SESSION['rajout'].'                   
                </div>';
                $_SESSION['rajout'] = false;
            }
        ?>
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5">
                <img class="img-fluid size-img-page" src="assets/img/medecin.jpg">
            </div>
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3">
                <?php 
                if ($_SESSION['erreur']) {
                    echo '<p class="alert alert-danger text-center w-100">Un problème est survenu lors de la selection du praticien</p>';
                    $_SESSION['erreur'] = false;
                } 

                if ($action == 'gererpraticien'){
                    $link='index.php?uc=praticien&action=modifierpraticien';
                    echo '<a href="index.php?uc=praticien&action=ajouterpraticien" class="btn btn-info text-light valider mb-5">Ajouter Praticien</a>';
                } else
                    $link='index.php?uc=praticien&action=afficherpraticien';
                ?>
                </br>
                <form action="<?php echo $link ;?>" method="post" class="formulaire-recherche col-12 m-0">
                    <label class="titre-formulaire" for="listepra">Praticien disponible :</label>
                    <select required name="praticien" class="form-select mt-3">
                        <option value class="text-center">- Choisissez un praticien -</option>
                        <?php
                        foreach ($result as $key) {
                            echo '<option value="' . $key['PRA_NUM'] . '" class="form-control">' . $key['PRA_PRENOM'] . ' ' . $key['PRA_NOM'] . '</option>';
                        }
                        ?>
                    </select>
                    <input class="btn btn-info text-light valider" type="submit" value="<?php echo $button ;?> les informations">
                </form>
            </div> 
        </div>
    </div>
</section>