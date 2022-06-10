<?php
    include("connect.php");
    $req=$PDO->prepare("select * from fichier where Id_fichier=? limit 1");
    $req->setFetchMode(PDO::FETCH_ASSOC);
    $req->execute(array($_GET["Id_fichier"]));
    $tab=$req->fetchAll();
    echo $tab[0]["bin"];

 ?>
