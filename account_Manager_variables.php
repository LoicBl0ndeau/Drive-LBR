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
	//echo('recherche : ' . $_POST['recherche']);
	$recherche = $postData['recherche'];
}




// On récupère tout le contenu de la table recipes
$sqlQuery = 'SELECT * FROM profil WHERE Nom LIKE "%' . $recherche . '%" OR Prenom LIKE "%' . $recherche . '%" OR email LIKE "%' . $recherche . '%" OR Role LIKE "%' . $recherche . '%" OR Id_Profil LIKE "%' . $recherche . '%" ORDER BY Nom;';
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute();
$users = $recipesStatement->fetchAll();

?>
