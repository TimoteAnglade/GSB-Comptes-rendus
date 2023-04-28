<script>
    function validateFormPraticien() {
        rep = true ;
        if ( document.forms['praticien']['type'].value == '' ) { 
            if ( confirm("Vous n'avez pas sélectionné de type de praticien\nRestez sur la page ?") == true ) {
                rep = false;
            }
        } else {
            table = document.getElementById('tableSpe') ;
            if (table == null) {
                confirm("Vous n'avez pas sélectionné de spécialitées pour ce praticien") == true 
                rep = false;
            } 
        }
        //console.log(rep);
        return rep ;
    }

    function ajouterSpe() {
        rep = true;
        liste = document.getElementById("spe");
        id = liste.options[liste.selectedIndex].value;
        //console.log(id);
        lib = liste.options[liste.selectedIndex].text;
        //console.log(lib);
        if (document.getElementById("tr"+ id)){
            alert("Ce praticien possède déjà cette spécialitée");
            rep = false;    
        } else {
            if ( id != '') {
                trb = document.createElement("tr");
                trb.setAttribute("id","tr"+ id);

                tdb1 = document.createElement("td");
                tdb1.appendChild(document.createTextNode(lib));
                tdb1.setAttribute("id",id);

                tdb2 = document.createElement("td");
                i1 = document.createElement("input");
                i1.setAttribute("id",id + "dip");
                i1.setAttribute("name",id + "dip");
                i1.setAttribute("class","form-control");
                i1.setAttribute("required",true);
                tdb2.appendChild(i1);

                tdb3 = document.createElement("td");
                i2 = document.createElement("input");
                i2.setAttribute("id",id + "coef");
                i2.setAttribute("name",id + "coef");
                i2.setAttribute("type","number");
                i2.setAttribute("value","0");
                i2.setAttribute("step","0.5");
                i2.setAttribute("min","0");
                i2.setAttribute("class","form-control");
                tdb3.appendChild(i2);

                tdb4 = document.createElement("td");
                b = document.createElement("button");
                b.setAttribute("class","btn-close");
                b.setAttribute("onclick","enleverSpe('"+ id +"')");
                b.setAttribute("data-bs-dismiss","alert");
                tdb4.appendChild(b);

                trb.appendChild(tdb1);
                trb.appendChild(tdb2);
                trb.appendChild(tdb3);
                trb.appendChild(tdb4);

                document.getElementById('tbody').appendChild(trb);
            } else {
                rep = false;
            }
        }
        return rep;
    }

    function initSpe() {
        rep = true;
        liste = document.getElementById("spe");
        if (document.getElementById('tableSpe') == null && liste.options[liste.selectedIndex].value != '') {
            // Création de la table qui va contenir les différentes spécilitées d'un praticien
            table = document.createElement("table");
            table.setAttribute("class","table");
            table.setAttribute("id","tableSpe");
            table.setAttribute("name","tableSpe");
            thead = document.createElement("thead");
            trh = document.createElement("tr");

            tdh1 = document.createElement("th");
            tdh1.setAttribute("scope","col");
            tdh1.appendChild(document.createTextNode("Libellé"));

            tdh2 = document.createElement("th");
            tdh2.setAttribute("scope","col");
            tdh2.appendChild(document.createTextNode("Diplôme"));

            tdh3 = document.createElement("th");
            tdh3.setAttribute("scope","col");
            tdh3.appendChild(document.createTextNode("Coéfficient de prescription"));

            trh.appendChild(tdh1);
            trh.appendChild(tdh2);
            trh.appendChild(tdh3);
            thead.appendChild(trh);

            table.appendChild(thead);

            tbody = document.createElement("tbody");
            tbody.setAttribute("id","tbody");
            tbody.setAttribute("name","tbody");
            table.appendChild(tbody);

            document.getElementById("divspe").appendChild(table);
            rep = ajouterSpe();

        } else {
            rep = ajouterSpe();
        }
        return rep;
    }

    function enleverSpe(id) {
        // Suppression de la ligne de l'élèment grâce à l'id donné si celui si existe
        rep = true;
        elem = document.getElementById("tr"+ id);
        //console.log(elem);
        if (elem != null) {
            elem.remove();
        } else {
            rep = false;
        }
        // Supprission de la table contenant les spécialité si durant la suprresion d'un élément de la table il ne reste qu'un seul élèment ou moins
        table = document.getElementById('tableSpe') ;
        if (table.getElementsByTagName("tr").length <= 1 ){
            table.remove();
        }
        return rep;
    }

    function initTabSpe(spe) 
    {
        if ( typeof(spe) == 'object' ) {
            // Création de la table qui va contenir les différentes spécilitées d'un praticien
            table = document.createElement("table");
            table.setAttribute("class","table");
            table.setAttribute("id","tableSpe");
            table.setAttribute("name","tableSpe");
            thead = document.createElement("thead");
            trh = document.createElement("tr");

            tdh1 = document.createElement("th");
            tdh1.setAttribute("scope","col");
            tdh1.appendChild(document.createTextNode("Libellé"));

            tdh2 = document.createElement("th");
            tdh2.setAttribute("scope","col");
            tdh2.appendChild(document.createTextNode("Diplôme"));

            tdh3 = document.createElement("th");
            tdh3.setAttribute("scope","col");
            tdh3.appendChild(document.createTextNode("Coéfficient de prescription"));

            trh.appendChild(tdh1);
            trh.appendChild(tdh2);
            trh.appendChild(tdh3);
            thead.appendChild(trh);

            table.appendChild(thead);

            tbody = document.createElement("tbody");
            tbody.setAttribute("id","tbody");
            tbody.setAttribute("name","tbody");

            for (var key in spe) {
                trb = document.createElement("tr");
                trb.setAttribute("id","tr"+ key);

                tdb1 = document.createElement("td");
                tdb1.appendChild(document.createTextNode(spe[key]['lib']));
                tdb1.setAttribute("id",key);

                tdb2 = document.createElement("td");
                i1 = document.createElement("input");
                i1.setAttribute("value",spe[key]['dipl']);
                i1.setAttribute("id",key + "dip");
                i1.setAttribute("name",key + "dip");
                i1.setAttribute("class","form-control");
                i1.setAttribute("required",true);
                tdb2.appendChild(i1);

                tdb3 = document.createElement("td");
                i2 = document.createElement("input");
                i2.setAttribute("value",spe[key]['coef']);
                i2.setAttribute("id",key + "coef");
                i2.setAttribute("name",key + "coef");
                i2.setAttribute("type","number");
                i2.setAttribute("step","0.5");
                i2.setAttribute("min","0");
                i2.setAttribute("class","form-control");
                tdb3.appendChild(i2);

                tdb4 = document.createElement("td");
                b = document.createElement("button");
                b.setAttribute("class","btn-close");
                b.setAttribute("onclick","enleverSpe('"+ key +"')");
                b.setAttribute("data-bs-dismiss","alert");
                tdb4.appendChild(b);

                trb.appendChild(tdb1);
                trb.appendChild(tdb2);
                trb.appendChild(tdb3);
                trb.appendChild(tdb4);

                tbody.appendChild(trb);
            }

            table.appendChild(tbody);
            document.getElementById("divspe").appendChild(table);
        }
    }
</script>
<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-6 pt-5">
            <h1 class="titre text-center">Fiche Praticien <span class="carac"><?php echo $nom; ?></span></h1>
        </div>

        <?php if ( isset($_SESSION['form']) ) { 
            if ($_SESSION['form'] != "") { ?>
                <div class="alert alert-danger alert-dismissible fade show mx-auto col-5">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button> 
                    Les informations suivantes n'ont pas été complété :
                    <ul>
                        <?php echo $_SESSION['form'];?>
                    </ul>
                </div>
            <?php unset($_SESSION['form']);
            }
        } ?>

        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-12 col-lg-10 col-xl-8 col-xxl-7 py-lg-6 py-4">
                <form name="praticien" action="index.php?uc=praticien&action=<?php echo $action; ?>" method="post" class="formulaire form-horizontal">
                    <P class="text-danger"><strong>*</strong> = Champ obligatoire</P>
                    <div class="form-group mb-2">
                        <label for="nom" class="control-label col-sm-2">Numéro</label>
                        <input id="num" name="num" value="<?php echo $num ; ?>" class="form-control" disabled>
                    </div>

                    <div class="form-group mb-2">
                        <label for="nom" class="control-label col-sm-2">Nom<strong class="text-danger">*</strong></label>
                        <input id="nom" name="nom" value="<?php echo $nom ; ?>" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="prenom" class="control-label col-sm-2">Prenom<strong class="text-danger">*</strong></label>
                        <input id="prenom" name="prenom" value="<?php echo $prenom ; ?>" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="adresse" class="control-label col-sm-2">Adresse<strong class="text-danger">*</strong></label>
                        <input id="adresse" name="adresse" value="<?php echo $adresse ; ?>" class="form-control" >
                    </div>
                    <div class="form-group mb-2">
                        <label for="cp" class="control-label col-sm-2">Code postal<strong class="text-danger">*</strong></label>
                        <div class="input-group">
                            <select id="depcode" name="depcode" class="form-select">
                            <?php
                                foreach($depcode as $unDepCode){
                                    $dep = $unDepCode['DEP_NUM'];
                                    if (strlen($dep)<2) $dep="0".$dep;
                                    if($code==$dep)
                                        echo '<option value="'.$dep.'" selected >'.$dep.'</option>';
                                    else
                                        echo '<option value="'.$dep.'" >'.$dep.'</option>';
                                    }
                            ?>
                            </select>
                            <input class="form-control" id="cp" name="cp" pattern="[0-9]{3}" value="<?php echo $cp ; ?>" title="Donner les trois derniers chiffres du code postal (ex: 450)" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="ville" class="control-label col-sm-2">Ville<strong class="text-danger">*</strong></label>
                        <input id="ville" name="ville" value="<?php echo $ville ; ?>" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="region" class="control-label col-sm-2">Regions</label>
                        <input id="region" name="region" value="<?php echo $region ; ?>" class="form-control" disabled> 
                    </div>
                    <div class="form-group mb-2">
                        <label for="notor" class="control-label col-sm-2">Notoriété</label> 
                        <div class="input-group">
                            <input id="notor" name="notor" type="number" value="<?php echo $notor ; ?>" class="form-control" step="0.5" min="0">  
                            <!--<span class="input-group-text">%</span>-->
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="conf" class="control-label col-sm-2">Confiance</label>
                        <div class="input-group">
                            <input id="conf" name="conf" type="number" value="<?php echo $conf ; ?>" class="form-control" step="0.5" min="0">
                            <!--<span class="input-group-text">%</span>-->
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="type" class="control-label col-sm-2">Type<strong class="text-danger">*</strong></label>
                        <select id="type" name="type" class="form-select">
                            <option value="" class="text-center" selected>- Choisissez un type -</option>
                            <?php 
                                foreach($lesTypes as $unType){
                                    $idType = $unType['TYP_CODE'];
                                    $libType = $unType['TYP_LIBELLE'];
                                    if($type==$libType)
                                        echo '<option value="'.$idType.'" selected >'.$libType.'</option>';
                                    else
                                        echo '<option value="'.$idType.'" >'.$libType.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div id="divspe" class="form-group mb-2">
                        <label for="spe" class="control-label col-sm-4">Spécialitées<strong class="text-danger">*</strong></label>
                        <div class="input-group col-sm-4">
                            <select id="spe" name="spe" class="form-select">
                                <option value="" class="text-center" selected>- Choisissez des spécialitées -</option>
                                <?php 
                                    foreach($lesSpe as $uneSpe){
                                        $idSpe = $uneSpe['SPE_CODE'];
                                        $libSpe = $uneSpe['SPE_LIBELLE'];
                                        echo '<option value="'.$idSpe.'" >'.$libSpe.'</option>';
                                    }
                                ?>
                            </select>
                            <input class="btn btn-secondary text-light" type="button" value="+" onclick="return initSpe()">
                        </div>
                        <?php 
                            if ($lesSpePra != '' && $lesSpePra) {
                                echo "<script> initTabSpe(".json_encode($lesSpePra)."); </script>";
                            }
                        ?>
                    </div>
                    <div class="row form-row">
                        <input class="btn btn-primary text-light valider col-3 mt-auto" type="button" onclick="history.go(-1)" value="Retour" name="retour">
                        <input class="btn btn-danger text-light valider col-4 mt-auto" type="button" value="Réinitialiser" name="reinitialiser" onclick="location.reload();">
                        <input class="btn btn-info text-light valider col-4" type="submit" value="Enregistrer" name="enregistrer" onclick="return validateFormPraticien();" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>