<?php

	//Retour d'un message simple
	function retourMessage($message, $action){
		header ("Content-Type: text/xml");
		echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
		echo "<xml>\n";
		echo "<action>$action</action>\n";
		echo "<message>$message</message>\n";
		echo "</xml>";
	}

	//Retour d'un message complexe
	function retourDonnees($infos, $action){
		header ("Content-Type: text/xml");
		echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
		echo "<xml>\n";
		echo "<action>$action</action>\n";
		while ($row = mysql_fetch_object($infos)) {
			echo "<membre>\n";
			echo "<username>$row->username</username>\n";
			echo "<password>$row->password</password>\n";
			echo "</membre>\n";
		}
		echo "</xml>";
	}	

	//Identification de la requête à effectuer
	switch ($_POST['requete']) {
		case "1":
			$req="SELECT idemplois, compagnie, titre, debut, fin, description FROM `cvdata`.`emplois`;";
			break;
		case "2":
			$req="SELECT idetudes, ecole, programme, debut, fin FROM `cvdata`.`etudes`;";
			break;
		case "3":
			$req="";
			break;
		default:
			retourMessage("La requête fournie est invalide. " + $_POST['requete'], "echec");
			exit;
	}

	try {
		//Connexion à la base de données
		$sql_serveur="mysql4.gear.host";	//Serveur SQL
		$sql_user="cvdata";	//Login SQL
		$sql_passwd="Xq2A9FVz~EU_";	//Mot de passe SQL
		$db_link = @mysql_connect($sql_serveur, $sql_user, $sql_passwd);	
		if(!$db_link) {	//Si la connexion échoue
			retourMessage("Connexion impossible à la base de données.", "echec");
			exit;
		}
		//Exécution de la requête
		$requete=mysql_query($req, $db_link) or die(mysql_error());		
		if (mysql_num_rows($requete) <> 0) {	//S'il y a au moins une entrée
			//retourDonnees($requete, "succes");
			retourMessage("Réussite!", "echec");
		} else {	//S'il n'y a aucune entrée
			retourMessage("La requête n'a retourné aucune donnée.", "echec");
		}
	} catch (Exception $e) {
		retourMessage("Une erreur est survenue. Veuillez reessayer.", "echec");
	}
?>