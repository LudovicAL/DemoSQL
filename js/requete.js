//Fonction insérant une requête SQL préparée dans le textArea
function ecrireRequete(expression) {
	switch(expression) {
    case "emplois":
        $('#champRequete').val("SELECT * FROM cvdata.emplois;");
		$('#selection').val("1");
        break;
    case "etudes":
        $('#champRequete').val("SELECT * FROM cvdata.etudes;");
		$('#selection').val("2");
        break;
	case "evenements":
        $('#champRequete').val("SELECT * FROM cvdata.evenements;");
		$('#selection').val("3");
        break;
    default:
        //Ne rien faire
	}
}

//Envoit la requête au serveur
function requeteServeur() {
	var	donnees= $('#selection').val();
	if (!donnees || 0 === donnees.length) {
		alert("Veuillez d'abord sélectionner l'une des requêtes SQL proposées.");
		return;
	}
	try {
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.open("GET", "php/gestionRequete.php?requete="+donnees, true);
		//Méthode que écoute les changements d'état
		xmlhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				reponseServeur(this);
			}
		};
		xmlhttp.send();
	} catch(z) {
		return;
	}
}

//Recoit de la réponse du serveur
function reponseServeur(reponse){
	var msg = "";
	var messageXML = reponse.responseXML; 
	var action = messageXML.getElementsByTagName("action")[0].firstChild.nodeValue;

	//Contrôleur
	switch(escape(action)){
		//Si le message reçu indique un échec
		case "echec":
			msg = messageXML.getElementsByTagName("message")[0].firstChild.nodeValue;
			alert(msg);
			break;
		//Si le message reçu indique un succès
		case "succes":
			construireTableau(messageXML);
			break;
		//Si le message est indéfini
		default :
			alert("Il y a eu une erreur.");
			break;
	}
}

//Construit le tableau contenant les informations envoyées par le serveur
function construireTableau(messageXML) {
	var tableau = document.getElementById(tableau);
	//Nettoyage de l'ancien tableau
	$(tableau).empty();
	//Insertion des titres
	var header = tableau.createTHead();
	var hRow = header.insertRow(0);
	var hCell5 = hRow.insertCell(0);
	var hCell4 = hRow.insertCell(0);
	var hCell3 = hRow.insertCell(0);
	var hCell2 = hRow.insertCell(0);
	var hCell1 = hRow.insertCell(0);
	hCell3.innerHTML = "Debut";
	hCell4.innerHTML = "Fin";
	msg = messageXML.getElementsByTagName("message")[0].firstChild.nodeValue;
	switch (msg) {
		case 1:
			hCell1.innerHTML = "Compagnie";
			hCell2.innerHTML = "Titre";
			hCell5.innerHTML = "Description";
			break;
		case 2:
			hCell1.innerHTML = "Institution";
			hCell2.innerHTML = "Programme";
			hCell5.innerHTML = "Commentaire";
			break;
		case 3:
			hCell1.innerHTML = "Organisation";
			hCell2.innerHTML = "Titre";
			hCell5.innerHTML = "Produit";
			break;
		default:
			//Ne rien faire
	}
	//Insertion du contenu
	
}