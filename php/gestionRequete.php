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
	function retourDonnees($q, $infos, $action){
		header ("Content-Type: text/xml");
		echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
		echo "<xml>\n";
		echo "<action>$action</action>\n";
		echo "<message>$q</message>";
		$row = mysql_fetch_object($infos)
		/*
		while ($row = mysql_fetch_object($infos)) {
			echo "<item>\n";
			echo "<organisation>$row->organisation</organisation>\n";
			echo "<titre>$row->titre</titre>\n";
			echo "<debut>$row->debut</debut>\n";
			echo "<fin>$row->fin</fin>\n";
			echo "<commentaire>$row->commentaire</commentaire>\n";
			echo "</item>\n";
		}
		*/
		echo "</xml>";
	}
	retourMessage("Hmmm...", "echec");
	exit;
	//Identification de la requête à effectuer
	$q=$_GET['requete'];
	switch ($q) {
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
			retourMessage("La requête fournie est invalide.", "echec");
			exit;
	}
	try {
		//Connexion à la base de données
		$server="mysql4.gear.host";	//Serveur
		$user="visitor";	//Login
		$passwd="Port-Folio!";	//Mot de passe
		//Les codes d'accès fournis permettent un accès à la base de données en mode lecture seulement.
		$con = mysqli_connect($server, $user, $passwd);
		//Vérification du succès de la connexion
		if (!$con) {
			/*
			echo "Error: Unable to connect to MySQL." . PHP_EOL;
			echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
			echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
			exit;
			*/
			die('Impossible de se connecter à la base de données.' . mysqli_error($con));
		}
		//Exécution de la requête SQL
		mysqli_select_db($con, "cvdata");
		$result = mysqli_query($con, $req);
		if ($result->num_rows > 0) {
			retourDonnees($q, $result, "succes");
		} else {
			retourMessage("La requête n'a pas retourné de résultats.", "echec");
		}
		//Fermeture de la base de données
		mysqli_close($conn);
	} catch (Exception $e) {
		retourMessage("Une erreur est survenue. Veuillez réessayer.", "echec");
	}
?>