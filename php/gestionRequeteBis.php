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
	switch ($_GET['requete']) {
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
		$con = mysqli_connect("mysql4.gear.host", "cvdata", "Xq2A9FVz~EU_", "cvdata", 3306);
		if (!$con) {
			echo "Error: Unable to connect to MySQL." . PHP_EOL;
			echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
			echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
			exit;

			/*
			die('Impossible de se connecter à la base de données.' . mysqli_error($con));
			*/
		}
		mysqli_select_db($con, "cvdata");
		$result = mysqli_query($con, $req);

		if ($result->num_rows > 0) {
			retourMessage("Plenty results", "echec");
		} else {
			retourMessage("0 result", "echec");
		}
		mysqli_close($conn);
	} catch (Exception $e) {
		retourMessage("Une erreur est survenue. Veuillez reessayer.", "echec");
	}
?>