<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center">Rapport n°<?php echo $content[0].' ' ?>de l'auteur</span> :  <span class="carac"><?php echo $content[1].' '.$content[2] ?></span></h1>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5">
                <img class="img-fluid" src="assets/img/paperasse.jpg">
            </div>
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3">
                <div class="formulaire">
                    <p><span class="carac">Rapport n°<?php echo $content[0].' ' ?>de l'auteur</span> : <?php echo $content[1].' '.$content[2] ?></p>

                    <?php
                    if($content[6])
                    {
                    ?>
                        <p><span class="carac">Praticien absent</span> : <?php echo $content[4].' '.$content[5] ?></p>
                        <p><span class="carac">Praticien remplaçant</span> : <?php echo $content[7].' '.$content[8] ?></p>
                    <?php
                    }
                    else
                    {
                        ?>
                    <p><span class="carac">Praticien rencontré</span> : <?php echo $content[4].' '.$content[5] ?></p>
                        <?php
                    }
                    ?>

                    <p><span class="carac">Date</span> : <?php echo $content[9] ?></p>
                    <p><span class="carac">Bilan</span> : <?php echo $content[10] ?></p>

                    <?php
                    if($content[11]="Autres")
                    {
                    ?>
                        <p><span class="carac">Motif</span> : <?php echo $content[12] ?></p>
                    <?php
                    }
                    else
                    {
                        ?>
                    <p><span class="carac">Motif</span> : <?php echo $content[11] ?></p>
                        <?php
                    }
                    ?>

                    <p><span class="carac">Contre indication</span> : <?php echo $content[4] ?></p>
                    <p><span class="carac">Prix de l'échantillon</span> : <?php echo $content[5] ?></p>
                    <p><span class="carac">Famille</span> : <?php echo $content[6] ?></p>
                    <input class="btn btn-info text-light valider col-6 col-sm-5 col-md-4 col-lg-3" type="button" onclick="history.go(-1)" value="Retour">
                </div>
            </div>
        </div>
    </div>
</section>