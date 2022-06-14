<?php

try
{
	// On se connecte à MySQL
	$mysqlClient = new PDO('mysql:host=localhost;dbname=lbr;charset=utf8', 'root');
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

// Si tout va bien, on peut continuer

$postData = $_POST;

if (
		!isset($_POST['recherche']) || empty($_POST['recherche'])
		)
{
	//echo('pas de recherche');
	$recherche = "";
}
else {
	$recherche = strip_tags($postData['recherche']);
	//echo('recherche : ' . $recherche);
}




// On récupère tout le contenu de la table recipes
$sqlQuery = 'SELECT * FROM log_ WHERE Id_log_ LIKE "%' . $recherche . '%" OR Nom LIKE "%' . $recherche . '%" OR Date_de_modification LIKE "%' . $recherche . '%" OR Description LIKE "%' . $recherche . '%" ORDER BY Id_log_;';
$changelogStatement = $mysqlClient->prepare($sqlQuery);
$changelogStatement->execute();
$changelogs = $changelogStatement->fetchAll();

?>
