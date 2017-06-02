<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/stylesheet.css">
		<meta name="description" content="Démonstration d'exécution d'une requête SQL via Ajax.">
		<title>Ludovic Aubut-Lussier - Démonstration SQL</title>
		<script src="js/requete.js"></script>
	</head>
	
	<body>
		<input type="hidden" id="selection" value="">
		<input type="button" value="Emplois" onClick="ecrireRequete('emplois')">
		<input type="button" value="Études" onClick="ecrireRequete('etudes')">
		<input type="button" value="Événements" onClick="ecrireRequete('evenements')">
		<br>
		<textarea rows="1" id="champRequete" class="large" disabled></textarea>
		<br>
		<input type="button" value="Soumettre" onClick="requeteServeur()">
		<div id="loader"></div> 
		<br>
		<br>
		<table id="tableau">
		</table>
	</body>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>ecrireRequete('emplois');</script>
	<script>loader(false);</script>
</html> 
