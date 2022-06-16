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
?>
