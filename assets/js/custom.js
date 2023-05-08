function addMotifAutre(mot, prerempli="") {
	if ($(mot).val() == "Autre") {
		$("#motif").after(
			'<textarea name="motif-autre" id="motif-autre" placeholder="Veuillez saisir le motif autre" class="form-control m-0 mt-2"></textarea>'
		);
		document = new Document;
		document.getElementById("motif-autre").innerHTML=prerempli;
	} else {
		$("#motif-autre").remove();
	}
}
function addMedicament(med, prerempli="") {
	if ($(med).val() != "default") {
		$("#medoc-autre").remove();
		$("#medicamentproposer2").remove();
		$("#medoc").after(
			$('<select id="medicamentproposer2" name="medicamentproposer2" id="medicamentproposer2" class="form-select m-0">').append(
				'<option value="default">- Choisissez un médicament -</option>'
			)
		);
		$("#medoc").after(
			$('<div class="d-flex flex-column" id="medoc-autre">').append(
				$('<label for="medicamentproposer2" id="labelMedoc" class="titre-formulaire mt-3">2ème médicament présenté :</label>')
			)
		);
		$(".listemedoc").clone().appendTo("#medicamentproposer2");
		var val = $(med).val();
		$("#medicamentproposer2>.listemedoc[value='" + val + "']").remove();
		$("#medicamentproposer2>.listemedoc[value='" + prerempli + "']").attr("selected",true);
	} else {
		$("#medoc-autre").remove();
		$("#medicamentproposer2").remove();
	}
}

function checkDateSaisieRapport() {
	$("#errorDate").remove();
	if ($("#datevisite").val() != "" && $("#datesaisit").val() < $("#datevisite").val()) {
		$("#datevisite")
			.parent()
			.after(
				'<div class="text-danger small" id="errorDate">La date de visite doit être inférieure à la date de saisie</div>'
			);
		return false;
	} else {
		return true;
	}
}
// FONCTION D'AJOUT ECHANTILLON
 function addEchantillon(ech, prerempli1="", prerempli2="", listeEch="") {
 	if (ech.checked) {
 		var i = 1;
 		obj = JSON.stringify(listeEch);
 		$("#redigerEtEchantillon").after(
 			'<div class="col-10 d-flex flex-column justify-content-center align-items-center mt-3 mb-5 mx-auto" id="addechantillon"><div id="Echantillon' +
 				i +
 				'" class=" mb-1 d-flex flex-row"><input required min="1" value="1" class="form-control me-1 rounded w-25 text-center" id="nbEchantillon' +
 				i +
 				'" type="number" name="number' + i + '"><button type="button" id="button" value=' +
 				i +
 				' onclick="addOtherEchantillon(\''+prerempli1+'\', \''+prerempli2+'\', '+obj.replace(/\"/g, "&#39;")+');" class="btn btn-outline-secondary"><i class="bi bi-plus-lg"></i></button></div></div>'
 		);
 		$("#Echantillon" + i + "").prepend(
 			$(
 				'<select name="echantillonadd' + i + '" id="echantillonadd' + i + '" class="form-select m-0 me-1" required>'
 			).append('<option value="">- Choisissez un échantillon -</option>')
 		);
 		$("#medoc>.listemedoc")
 			.clone()
 			.appendTo("#echantillonadd" + i + "");	
		$("#echantillonadd"+i+">.listemedoc[value='"+prerempli1+"']").removeAttr("selected");
		$("#echantillonadd"+i+">.listemedoc[value='" + prerempli2 + "']").removeAttr("selected");
		$("#echantillonadd"+i+">.listemedoc[value='" + listeEch[i]["medCode"] + "']").attr("selected",true);
		$("#nbEchantillon"+i).attr("value",listeEch[i]["qte"]);
 	} else {
 		if (confirm("Voulez-vous vraiment décocher Échantillon ?")) {
 			$("#addechantillon").remove();
 		} else {
 			$(ech).prop("checked", true);
 		}
 	}
 }

 function addOtherEchantillon(prerempli1="", prerempli2="", listeEch="") {
 	if (parseInt($("#button").val()) < 9) {
 		var i = parseInt($("#button").val()) + 1;
 		obj = JSON.stringify(listeEch);
 		$("#button").remove();
 		$("#buttonMinus").remove();
 		$("#addechantillon").append(
 			'<div id="Echantillon' +
 				i +
 				'" class=" mb-1 d-flex flex-row"><input required min="1" value="1" class="form-control me-1 rounded w-25 text-center" id="nbEchantillon' +
 				i +
 				'" type="number" name="number' + i + '"><button type="button" id="button" value="' +
 				i +
 				'" onclick="addOtherEchantillon(\''+prerempli1+'\', \''+prerempli2+'\', '+obj.replace(/\"/g, "&#39;")+');" class="btn btn-outline-secondary me-1"><i class="bi bi-plus-lg"></i></button><button type="button" id="buttonMinus" value="' +
 				i +
 				'" onclick="minusEchantillon(this, \''+prerempli1+'\', \''+prerempli2+'\', '+obj.replace(/\"/g, "&#39;")+');" class="btn btn-outline-secondary"><i class="bi bi-dash-lg"></i></button></div></div>'
 		);
 		$("#Echantillon" + i + "").prepend(
 			$(
 				'<select name="echantillonadd' + i + '" id="echantillonadd' + i + '" class="form-select m-0 me-1" required>'
 			).append('<option value="">- Choisissez un échantillon -</option>')
 		);
 		$("#medoc>.listemedoc")
 			.clone()
 			.appendTo("#echantillonadd" + i + "");
		$("#echantillonadd"+i+">.listemedoc[value='" + prerempli1 + "']").removeAttr("selected");
		$("#echantillonadd"+i+">.listemedoc[value='" + prerempli2 + "']").removeAttr("selected");
		$("#echantillonadd"+i+">.listemedoc[value='" + listeEch[i]["medCode"] + "']").attr("selected",true);
		$("#nbEchantillon"+i).attr("value", listeEch[i].qte);
 	} else {
 		var i = parseInt($("#button").val()) + 1;
 		obj = JSON.stringify(listeEch);
 		$("#button").remove();
 		$("#buttonMinus").remove();
 		$("#addechantillon").append(
 			'<div id="Echantillon' +
 				i +
 				'" class=" mb-1 d-flex flex-row"><input required min="1" value="1" class="form-control me-1 rounded w-25 text-center" id="nbEchantillon' +
 				i +
 				'" type="number" name="number' + i + '"><button type="button" id="buttonMinus" value="' +
 				i +
 				'" onclick="minusEchantillon(this, \''+prerempli1+'\', \''+prerempli2+'\', '+obj.replace(/\"/g, "&#39;")+');" class="btn btn-outline-secondary"><i class="bi bi-dash-lg"></i></button></div></div>'
 		);
 		$("#Echantillon" + i + "").prepend(
 			$(
 				'<select name="echantillonadd' + i + '" id="echantillonadd' + i + '" class="form-select m-0 me-1" required>'
 			).append('<option value="">- Choisissez un échantillon -</option>')
 		);
 		$("#medoc>.listemedoc")
 			.clone()
 			.appendTo("#echantillonadd" + i + "");
		$("#echantillonadd"+i+">.listemedoc[value='" + prerempli1 + "']").removeAttr("selected");
		$("#echantillonadd"+i+">.listemedoc[value='" + prerempli2 + "']").removeAttr("selected");
		$("#echantillonadd"+i+">.listemedoc[value='" + listeEch[i]["medCode"] + "']").attr("selected",true);
		$("#nbEchantillon").attr("value", listeEch[i].qte);
 	}
 }

 function minusEchantillon(min, prerempli1="", prerempli2="", listeEch="") {
 	var i = parseInt($("#buttonMinus").val()) - 1;
 	obj = JSON.stringify(listeEch);
 	$(min).parent().remove();
 	if (i > 1) {
 		$("#Echantillon" + i + "").append(
 			'<button type="button" id="button" value="' +
 				i +
 				'" onclick="addOtherEchantillon(\''+prerempli1+'\', \''+prerempli2+'\', '+obj.replace(/\"/g, "&#39;")+');" class="btn btn-outline-secondary me-1"><i class="bi bi-plus-lg"></i></button><button type="button" id="buttonMinus" value="' +
 				i +
 				'" onclick="minusEchantillon(this, \''+prerempli1+'\', \''+prerempli2+'\', '+obj.replace(/\"/g, "&#39;")+');" class="btn btn-outline-secondary"><i class="bi bi-dash-lg"></i></button>'
 				);
 	} else {
 		$("#Echantillon" + i + "").append(
 			'<button type="button" id="button" value="' +
 				i +
 				'" onclick="addOtherEchantillon(\''+prerempli1+'\', \''+prerempli2+'\', '+obj.replace(/\"/g, "&#39;")+');" class="btn btn-outline-secondary me-1"><i class="bi bi-plus-lg"></i></button>'
 		);
 	}
 }



function promptMedoc(select){
 	if(select.val()=="default") {
 		return confirm("Vous enregistrez le rapport de visite sans présentation de médicament. Êtes vous sur ?");
 	}
 	else{
 		return true;
 	}
}


function promptEch(select){
 	if(!(select.checked)) {
 		return confirm("Vous enregistrez le rapport de visite sans echantillons offerts. Êtes vous sur ?");
 	}
 	else{
 		return true;
 	}
}

function checkObl(praticien, bilan, motif, datevis){
	valPra=praticien.value;
	valBilan=bilan.value;
	valMot=motif.value;
	valDate=datevis.value;

	result=true;
	chaine="Le formulaire ne peux pas être envoyé :";
	if(valPra==""|!(/^\d+$/.test(valPra))){
		chaine=chaine+"\nLe praticien n'est pas selectionné";
		result=false;
	}
	if(valBilan==""){
		chaine=chaine+"\nLe bilan n'est pas rempli";
		result=false;
	}
	if(valMot==""|valMot=="default"){
		chaine=chaine+"\nLe motif n'est pas selectionné";
		result=false;
	}
	if(valDate==""){
		chaine=chaine+"\nLa date n'est pas selectionnée";
		result=false;
	}
	if(!result){
		alert(chaine);
	}
	return result;
}

function checkAutre(definitif, motif) {
	valDefinitif=definitif.checked;
	valMot=motif.value;
	result=true;
	if(valMot=="Autre"&&valDefinitif){
		document = new Document();
		valMotAut = document.getElementById('motif-autre').value;
		result=valMotAut!="";
	}
	if(!result){
		alert("Le champ de saisie du motif Autre n'est pas rempli.");
	}
	return result;
}
