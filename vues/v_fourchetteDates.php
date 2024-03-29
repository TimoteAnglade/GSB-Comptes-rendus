<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center"><?php echo $titre[1]; ?></h1>
            <p class="text text-center">
                <?php echo $titre[2]; ?>
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
                        case '3':
                            echo '<div class="alert alert-warning" role="alert">Il n\'existe aucun rapports de visite correrspondant à ces critères </div>';
                        }
                } ?>
                <form action="" method="get" class="formulaire-recherche col-12 m-0">
                    <input type="text" name="uc" value="rapportdevisite" hidden>
                    <?php
                        if($titre[0]){
                            ?>
                                <input type="text" name="action" value="voirHistoriqueFiltre" hidden>
                            <?php
                        } else {
                            ?>
                                <input type="text" name="action" value="voirRapportsFiltres" hidden>
                            <?php
                        }
                        ?>
                    <label class="titre-formulaire" for="listepra">Filtrer par <?php if($titre[0]){ echo 'collaborateur'; } else { echo 'praticien'; }?></label>
                    <select name=<?php if($titre[0]){ echo '"collaborateur"'; } else { echo '"praticien"'; }?>
                    class="form-select mt-3"
                    <?php if(count($result)<=0){ echo 'disabled'; } ?>>
                        <option value class="text-center"><?php if(count($result)<=0){ echo 'Aucun praticien disponible'; } else { echo 'Aucun';} ?></option>
                        <?php
                        foreach ($result as $key) {
                            if($titre[0]){
                                $num = $key['COL_MATRICULE'];
                                $nom = $key['COL_NOM']." ".$key['COL_PRENOM'];
                            } else {
                                $num = $key['PRA_NUM'];
                                $nom = $key['PRA_PRENOM']." ".$key['PRA_NOM'];
                            }
                            echo '<option value="' . $num . '" class="form-control">' . $nom . '</option>';
                        }
                        ?>
                    </select>
                    <label class="titre-formulaire" for="listepra">Filtrer par période :</label>
                    <label class="titre-formulaire" for="listepra">Date de début :</label>
                    <input type="date" name="dateDeb">
                    <label class="titre-formulaire" for="listepra">Date de fin :</label>
                    <input type="date" name="dateFin">
                    <input class="btn btn-info text-light valider" type="submit" value="Valider">
                </form>
            </div>
        </div>
    </div>
</section>