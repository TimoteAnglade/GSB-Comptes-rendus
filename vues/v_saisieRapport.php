<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center">
        <?php
            if($isNew){
                echo 'Saisie d\'un nouveau rapport';   
            }
            else{
                if(!isset($_REQUEST['rapport'])){
                    $_REQUEST['rapport'] = 1;
                }
                echo 'Edition du rapport n°'.$_REQUEST['rapport'];   
            }



        ?></h1>
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
                    <input type="text" name="uc" value="modifierRapport" hidden>
                    <input type="text" name="matricule" value="<?php echo $prerempli['matricule'];?>" hidden>
                    <input type="text" name="rapport" value="<?php echo $prerempli['rap_num'].'';?>" hidden>

                    <label class="titre-formulaire mt-3" for="praticien">Praticien :</label>
                    <select name='praticien' class="form-select mt-3">
                        <?php if(count($praticiens)){
                            ?>   <option class="text-center" >
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

                    <label class="titre-formulaire mt-3" for="praticienremp">Praticien remplaçant :</label>
                    <select name='praticienremp' class="form-select" required>
                        <?php if(count($praticiens)){
                            ?>   <option class="text-center" value="default">
                                Aucun remplaçant
                                </option> <?php
                        } else {
                            ?>   <option value class="text-center" value="default" disabled>
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
                    <input type="date" name="dateVis" value="<?php echo substr($prerempli['rap_date'], 0, 10);?>">

                    <label for="medicamentproposer" id="labelMedoc" class="titre-formulaire mt-3">1er médicament présenté :</label>
                    <select id="medoc" name="medicamentproposer" id="medicamentproposer" class="form-select m-0" onchange="addMedicament(this)">
                    <option class="" value="default">- Choisissez un médicament -</option>

                    <?php
                    foreach ($medocs as $medoc) {
                        echo '<option class="listemedoc" value="'.$medoc['MED_DEPOTLEGAL'].'"> '.$medoc['MED_DEPOTLEGAL']." - ".$medoc['MED_NOMCOMMERCIAL']." </option>";
                    }
                    ?>
                    </select>

                    <label for="motifautre" class="titre-formulaire mt-3">Motif :</label>
                    <select id="motifautre" name="motifautre" id="medicamentproposer" class="form-select m-0" onchange="addMotifAutre(this)">
                    <option class="" value="default">- Choisissez un motif -</option>

                    <?php
                    foreach ($motifs as $motif) {
                        echo '<option class="listemedoc" value="'.$motif['MOT_CODE'].'"> '.$motif['MOT_CODE'];
                        if(!empty($motif['MOT_LIBELLE'])){
                            echo " - ".$motif['MOT_LIBELLE'];
                        }
                        echo " </option>";
                    }
                    ?>
                    </select>
                    <div id="divmotifautre" class="">
                    </div>

                    <label for="echantillions" class="titre-formulaire mt-3">Echantillions :</label>
                    <input type="checkbox" name="echantillions" id="redigerEtEchantillon" onchange="addEchantillon(this)">
                    <script> addEchantillon({checked:true}); </script>
                    <label for="brouillon" class="titre-formulaire mt-3">Enregistrer ce rapport en tant que :</label>
                    <div>
                    <div class="form-check">
                    <label class="form-check-label" for="br">brouillon</label>
                    <input class="form-check-input" type="radio" name="brouillon" id="br" value="0" required>
                    </div>
                    <div class="form-check">
                    <label class="form-check-label" for="def">publié</label>
                    <input class="form-check-input" class="ml-3" type="radio" name="brouillon" id="def" value="1">
                    </div>
                    </div>
                    
                    

                    <input type="submit" name="Submit">

                </form>
            </div>
        </div>
    </div>
</section>