<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center"><?php echo 'TITRE 1'; ?></h1>
            <p class="text text-center">
                <?php echo 'TITRE 2'; ?>
            </p>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3">
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

                    <label class="titre-formulaire mt-3" for="praticien">Praticien :</label>
                    <select name='praticien' class="form-select mt-3">
                        <?php if(count($praticiens)){
                            ?>   <option valueclass="text-center" >
                                Choisissez un praticien
                                </option> <?php
                        } else {
                            ?>   <option value class="text-center" disabled>
                                Aucun praticien répertorié dans votre région
                                </option>   <?php
                        }   ?>
                        <?php
                        foreach ($praticiens as $praticien) {
                            echo '<option value="'.$praticien['PRA_NUM'].'"class="text-center" ';
                            if($praticien['PRA_NUM']==$prerempli['pra_num_praticien']){
                                echo 'selected';                                
                            }
                            echo '>';
                            echo $praticien['PRA_NOM'].' '.$praticien['PRA_PRENOM'];
                            echo '</option>';
                        } ?>
                    </select>

                    <label class="titre-formulaire mt-3" for="praticien">Praticien remplaçant :</label>
                    <select name='praticien' class="form-select" required>
                        <?php if(count($praticiens)){
                            ?>   <option valueclass="text-center" >
                                Choisissez un praticien
                                </option> <?php
                        } else {
                            ?>   <option value class="text-center" disabled>
                                Aucun praticien répertorié dans votre région
                                </option>   <?php
                        }   ?>
                        <?php
                        foreach ($praticiens as $praticien) {
                            echo '<option value="'.$praticien['PRA_NUM'].'"class="text-center" ';
                            if($praticien['PRA_NUM']==$prerempli['pra_num_remplacant']){
                                echo 'selected';                                
                            }
                            echo '>';
                            echo $praticien['PRA_NOM'].' '.$praticien['PRA_PRENOM'];
                            echo '</option>';
                        } ?>
                    </select>

                    <label class="titre-formulaire mt-3" for="bilanContent">Bilan du rapport</label>
                    <input type="textarea" name="bilanContent" class="form-control">

                    <label class="titre-formulaire mt-3" for="dateVis">Date de la visite</label>
                    <input type="date" name="dateVis">

                    <select onchange="addMedicament(this.value)">
                        <option value="default">f</option>
                        <option value="dsqfsd">g</option>
                    </select>

                    <button onclick="">AAAAA</button>

                </form>
            </div>
        </div>
    </div>
</section>