<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center">Choisissez une période</h1>
            <p class="text text-center">
                Choisissez une période parmi laquelle vous voulez voir vos rapports
            </p>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5">
                <img class="img-fluid size-img-page" src="assets/img/paperasse.jpg">
            </div>
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3">
                <?php 
                if(isset($_REQUEST['erreur'])){
                    switch ($_REQUEST['erreur']) {
                        case '1':
                            echo '<div class="alert alert-warning" role="alert">Veuillez saisir les dates dans le bon ordre </div>';
                            break;

                        case '2':
                            echo '<div class="alert alert-warning" role="alert">Veuillez saisir les dates</div>';
                            break;
                        }
                } ?>
                <form action="" method="get" class="formulaire-recherche col-12 m-0">
                    <input type="text" name="uc" value="rapportdevisite" hidden>
                    <input type="text" name="action" value="voirRapportsFiltres" hidden>
                    <label class="titre-formulaire" for="listepra">Filtrer par praticien</label>
                    <select name="praticien" class="form-select mt-3">
                        <option value class="text-center">Aucun</option>
                        <?php
                        foreach ($result as $key) {
                            echo '<option value="' . $key['PRA_NUM'] . '" class="form-control">' . $key['PRA_PRENOM'] . ' ' . $key['PRA_NOM'] . '</option>';
                        }
                        ?>
                    </select>
                    <label class="titre-formulaire" for="listepra">Filtrer par période :</label>
                    <label class="titre-formulaire" for="listepra">Date de début :</label>
                    <input type="date" name="dateDeb">
                    <label class="titre-formulaire" for="listepra">Date de fin :</label>
                    <input type="date" name="dateFin">
                    <input class="btn btn-info text-light valider" type="submit" value="Afficher ce rapport">
                </form>
            </div>
        </div>
    </div>
</section>