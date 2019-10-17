<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/all.css">
    <script src="/js/bootstrap.min.js"></script>
    <link  src="./img/favicon.ico" rel="stylesheet">
    <title>Galaxy Swiss Bourdin</title>
  </head>
  <body>
  <?php

/*
    if (isset($_SESSION['login']) && isset($_SESSION['mdp'])) {
        $login_sesion = $_SESSION['login'];
        $mdp_session = $_SESSION['mdp'];
        $id = $_SESSION['id'];
        $nom = $_SESSION['nom'];
        $prenom = $_SESSION['prenom'];*/

    require("./vue/header.php");
/*

    if (isset($login_sesion) && isset($mdp_session)) {*/
      require('./vue/nav_after.php');
      require('./include/section_fraisForfait.php');
  /*  }
    else {
      require("./vue/nav_before.php");
      require("./include/authentification_KO.php");
    }*/

    require("./vue/footer.php");
//}

  ?>
  </body>
</html>
