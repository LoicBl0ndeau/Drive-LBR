<?php
	// Initialise la session
	session_start();
	// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
	if(!isset($_SESSION["loggedUser"])){
		header("Location: login.php");
		exit();
	}

	// Défini le fuseau horaire à utilisateur
	date_default_timezone_set('Europe/Paris');
?>

<?php
$postData = $_POST;

if (
    !isset($_POST['Id_Profil']) || empty($_POST['Id_Profil'])
    )
{
	echo('ça marche pas');
    return;
}

$Id_Profil = $postData['Id_Profil'];

try
{
	$mysqlClient = new PDO('mysql:host=localhost;dbname=lbr;charset=utf8', 'root');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Ecriture de la requête
$sqlQuery = 'SELECT * FROM profil WHERE Id_Profil = :Id_Profil';

// Préparation
$userStatement = $mysqlClient->prepare($sqlQuery);

// Exécution ! l'utilisateur est maintenant en base de données
$userStatement->execute([
    'Id_Profil' => $Id_Profil
]);
$users = $userStatement->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="initial-scale=1.0" />
		<meta name="Auteurs" content="Loïc BLONDEAU;Louis BOUBERT;Martin CAPELLE;Ilies BENSLAMA" />
		<link rel="stylesheet" type="text/css" href="style/style.css" />
		<link rel="icon" href="images/favicon.ico" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<title>Account Manager Drive - Les Briques Rouges</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body class="d-flex flex-column min-vh-100">
    <div class="container alert alert-danger" role="alert">
        Êtes vous sûr de vouloir supprimer le compte de <?php foreach ($users as $user) {
          echo $user['Prenom'] . " " . $user['Nom'] . " dont l'id est : " . $user['Id_Profil'];
        } ?><br>
        La suppression est définitive <br><br><br>
				<form action="account_Manager_submit_delete_user.php" method="post">
        	<button class="btn btn-danger" type="submit" name="user" value="<?php echo $Id_Profil ?>">SUPPRIMER</button>
				</form>
        <button class="btn btn-success" type="button" name="button">RETOUR</button>
    </div>
  </body>
</html>
