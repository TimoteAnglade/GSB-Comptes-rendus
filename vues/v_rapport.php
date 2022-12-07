<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center">Rapport n°<?php echo $content['rap_num'].' ' ?>de l'auteur</span> :  <span class="carac"><?php echo $content['col_nom'].' '.$content['col_prenom'] ?></span></h1>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5">
                <img class="img-fluid" src="assets/img/paperasse.jpg">
            </div>
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3">
                <div class="formulaire">
                    <p><span class="carac">Rapport n°<?php echo $content['rap_num'].' ' ?>de l'auteur</span> : <?php echo $content['col_nom'].' '.$content['col_prenom'] ?></p>

                    <?php
                    if($content['pra_num_remplacant'])
                    {
                    ?>
                        <p><span class="carac">Praticien absent</span> : <?php echo $content['pra_nom'].' '.$content['pra_prenom'] ?></p>
                        <p><span class="carac">Praticien remplaçant</span> : <?php echo $content['pra_rem_nom'].' '.$content['pra_rem_prenom'] ?></p>
                    <?php
                    }
                    else
                    {
                        ?>
                    <p><span class="carac">Praticien rencontré</span> : <?php echo $content['pra_nom'].' '.$content['pra_prenom'] ?></p>
                        <?php
                    }
                    ?>

                    <p><span class="carac">Date</span> : <?php echo $content['rap_date'] ?></p>
                    <p><span class="carac">Bilan</span> : <?php echo $content['rap_bilan'] ?></p>

                    <?php
                    if($content['mot_code']="Autres")
                    {
                    ?>
                        <p><span class="carac">Motif</span> : <?php echo $content['rap_motif_autre'] ?></p>
                    <?php
                    }
                    else
                    {
                        ?>
                    <p><span class="carac">Motif</span> : <?php echo $content['mot_code'] ?></p>
                        <?php
                    }
                    ?>

                    <?php
                    if($presentes) {
                        ?><p><span class="carac">Medicament présenté n°1</span> : <?php echo $presentes['med_nomcommercial1'] ?></p>
                        <?php
                        if(isset($presentes['med_nomcommercial2'])){                                                    ?><p><span class="carac">Medicament présenté n°1</span> : <?php echo $presentes['med_nomcommercial2'] ?></p><?php
                        }
                    }
                    ?>

                    <?php $i=0; 
                    foreach($offres as $med){
                        $i++;
                        ?>
                    <p><span class="carac">Echantillon offert n°<?php echo $i;?></span> : <?php echo $med['med_nomcommercial'].' x'.$med['off_qte']; ?></p>
                    <?php } ?>
                    <input class="btn btn-info text-light valider col-6 col-sm-5 col-md-4 col-lg-3" type="button" onclick="history.go(-1)" value="Retour">
                </div>
            </div>
        </div>
    </div>
</section>