<?php
  $user = 'root';
  $pass='';
  try{
    $PDO = new PDO ('mysql:host=localhost;dbname=lbr', $user,$pass);
  }
  catch (PDOException $e){
    print "Erreur :" . $e->getMessage() . "<br/>";
    die;
  }
 ?>
