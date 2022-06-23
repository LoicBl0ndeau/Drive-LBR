<?php

	// Vérification du rôle

function autorisation_admin()
{
  if($_SESSION["loggedUser"]["Role"]!="Admin")
  {
    header("Location: accueil.php");
    exit();
  }
}

function check_mdp_format($mdp)
{
	$majuscule = preg_match('@[A-Z]@', $mdp);
	$minuscule = preg_match('@[a-z]@', $mdp);
	$chiffre = preg_match('@[0-9]@', $mdp);
  $pattern = '/[\'\/~`\!@#$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
  $caractères = preg_match('/[\'\/~`\!@#$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $mdp);

	if(!$majuscule || !$minuscule || !$chiffre || !$caractères || strlen($mdp) < 8)
	{
		return false;
	}
	else
		return true;
}

?>
