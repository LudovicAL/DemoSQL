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
	function retourDonnees($q, $stmt, $action){
		header ("Content-Type: text/xml");
		echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
		echo "<xml>\n";
		echo "<action>$action</action>\n";
		echo "<message>$q</message>";
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		while($row = $stmt->fetch()) {
			echo "<item>\n";
			echo "<organisation>" . $row['organisation'] . "</organisation>\n";
			echo "<titre>" . $row['titre'] . "</titre>\n";
			echo "<debut>" . $row['debut'] . "</debut>\n";
			echo "<fin>" . $row['fin'] . "</fin>\n";
			echo "<commentaire>" . $row['commentaire'] . "</commentaire>\n";
			echo "</item>\n";
		}
		echo "</xml>";
	}

	//Identification de la requête à effectuer
	$q=$_GET['requete'];
	switch ($q) {
		case "1":
			$req="SELECT * FROM cvdata.emplois;";
			break;
		case "2":
			$req="SELECT * FROM cvdata.etudes;";
			break;
		case "3":
			$req="SELECT * FROM cvdata.evenements;";
			break;
		default:
			retourMessage("La requête fournie est invalide.", "echec");
			exit;
	}
	try {
		//Connexion à la base de données
		$server="mysql4.gear.host";	//Serveur
		$user="visitor";	//Login
		$passwd="Port-Folio!";	//Mot de passe
		$conn = new PDO("mysql:host=$server", $user, $passwd);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
		//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//Préparation de la reqête SQL
		$stmt = $conn->prepare($req);
		//Exécution de la requête SQL
		$stmt->execute();
		retourDonnees($q, $stmt, "succes");
	} catch(PDOException $e) {
    	retourMessage($e->getMessage(), "echec");
    }
	$conn = null;
?>