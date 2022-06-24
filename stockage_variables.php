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

// On récupère tout le contenu de la table profil en fonction de la recherche
$sqlQuery = 'SELECT * FROM profil WHERE Nom LIKE "%' . $recherche . '%" OR Prenom LIKE "%' . $recherche . '%" OR email LIKE "%' . $recherche . '%" OR Role LIKE "%' . $recherche . '%" OR Id_Profil LIKE "%' . $recherche . '%" ORDER BY Id_Profil;';
$changelogStatement = $PDO->prepare($sqlQuery);
$changelogStatement->execute();
$users = $changelogStatement->fetchAll();

$query = 'SELECT SUM(Taille) FROM fichier ';
$req = $PDO->query($query);
$Total = $req->fetch();

?>
