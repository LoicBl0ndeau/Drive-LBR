<?php
	// Initialise la session
	session_start();
	// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
	if(!isset($_SESSION["loggedUser"])){
		header("Location: login.php");
		exit();
	}
?>

<?php

$postData = $_POST;

if (
    !isset($_POST['user']) || empty($_POST['user'])
    )
{
	echo('Il y a un problème');
    return;
}

$Id_Profil = $postData['user'];

echo $Id_Profil;

?>

<?php
try
{
	$mysqlClient = new PDO('mysql:host=localhost;dbname=lbr;charset=utf8', 'root');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Ecriture de la requête
$sqlQuery = 'DELETE FROM Profil WHERE Id_Profil=:Id_Profil';

// Préparation
$delete_user = $mysqlClient->prepare($sqlQuery);

// Exécution ! l'utilisateur est maintenant supprimé de la base de données
$delete_user->execute([
    'Id_Profil' => $Id_Profil,
]);
?>
