<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/all.css">
    <link rel="shortcut icon" href="./img/favicon.ico" />


    <title>Galaxy Swiss Bourdin</title>
  </head>



  <body>
<?php

    if (isset($_SESSION['login']) && isset($_SESSION['mdp'])) {
        $login = $_SESSION['login'];
        $mdp = $_SESSION['mdp'];
        $id = $_SESSION['id'];
        $nom = $_SESSION['nom'];
        $prenom = $_SESSION['prenom'];
        require("./vue/header.php");


        if (isset($login) && isset($mdp)) {
          require('./vue/nav_after.php');
          require("./include/section_accueil.php");
        }
        else {
          require("./vue/nav_before.php");
          require("./include/authentification_KO.php");
        }
        require("./vue/footer.php");
      }

    ?>
  </body>
  </html>
