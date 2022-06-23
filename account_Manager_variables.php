<?php

include("connect.php");

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
$sqlQuery = 'SELECT * FROM profil WHERE MDP IS NOT NULL AND (Nom LIKE "%' . $recherche . '%" OR Prenom LIKE "%' . $recherche . '%" OR email LIKE "%' . $recherche . '%" OR Role LIKE "%' . $recherche . '%" OR Id_Profil LIKE "%' . $recherche . '%") ORDER BY Nom;';
$recipesStatement = $PDO->prepare($sqlQuery);
$recipesStatement->execute();
$users = $recipesStatement->fetchAll();

?>
