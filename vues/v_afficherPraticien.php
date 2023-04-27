<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center">Informations du Praticien <span class="carac"><?php echo $carac[1]; ?></span></h1>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5">
                <img class="img-fluid" src="assets/img/praticien.jpg">
            </div>
            <div class="test col-12 col-sm-12 col-lg-10 col-xl-9 col-xxl-6 py-lg-5 py-3">
                <div class="formulaire">
                    <p><span class="carac">Numéro</span> : <?php echo $carac[0]; ?></p>
                    <p><span class="carac">Nom </span> : <?php echo $carac[1]; ?></p>
                    <p><span class="carac">Prénom</span> : <?php echo $carac[2]; ?></p>
                    <p><span class="carac">Adresse</span> : <?php echo $carac[3]; ?></p>
                    <p><span class="carac">Code postal</span> : <?php echo $carac[4]; ?></p>
                    <p><span class="carac">Ville</span> : <?php echo $carac[5]; ?></p>
                    <p><span class="carac">Région</span> : <?php echo $region; ?></p>
                    <p><span class="carac">Notoriété</span> : <?php echo $carac[6] . '%' ; ?></p>
                    <p><span class="carac">Confiance</span> : <?php echo $carac[7] . '%' ; ?></p>
                    <p><span class="carac">Type</span> : <?php echo $carac[8]; ?></p>
                    <table class="table">
                        <thead class="thead-primary">
                            <tr>
                                <th scope="col">Libellé Spécialitées</th>
                                <th scope="col">Diplôme</th>
                                <th scope="col">Coéf prescription</th>
                            </tr>
                        </thead>
                            <tbody>
                                <?php foreach ( $lesSpePra as $uneSpePra) {
                                echo "<tr>
                                    <td>".$uneSpePra['SPE_LIBELLE']."</td>
                                    <td>".$uneSpePra['POS_DIPLOME']."</td>
                                    <td>".$uneSpePra['POS_COEFPRESCRIPTION']."</td>
                                </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    <input class="btn btn-info text-light valider col-6 col-sm-5 col-md-4 col-lg-3" type="button" onclick="history.go(-1)" value="Retour">
                </div>
            </div>
        </div>
    </div>
</section>