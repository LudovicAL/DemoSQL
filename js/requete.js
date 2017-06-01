//Fonction insérant une requête SQL préparée dans le textArea
function ecrireRequete(expression) {
	switch(expression) {
    case "emplois":
        $('#champRequete').val("SELECT idemplois, compagnie, titre, debut, fin, description FROM `cvdata`.`emplois`;");
		$('#selection').val("1");
        break;
    case "etudes":
        $('#champRequete').val("SELECT idetudes, ecole, programme, debut, fin FROM `cvdata`.`etudes`;");
		$('#selection').val("2");
        break;
	case "evenements":
        $('#champRequete').val("Événements");
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
		xmlhttp.open("GET", "php/gestionRequeteBis.php?requete="+donnees, true);
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
			msg = messageXML.getElementsByTagName("message")[0].firstChild.nodeValue;
			alert(msg);
			break;	
		//Si le message est indéfini
		default :
			alert("Il y a eu une erreur.");
			break;
	}
}