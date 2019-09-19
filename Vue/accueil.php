<?php
verifExistUtilisateur();
?>

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
    <script type="text/javascript" src="./js/date.js"></script>
    <title>Galaxy Swiss Bourdin</title>
  </head>
  <body>


<?php
    include("./Vue/header.php")

    if (isset($login_sesion) && isset($mdp_session)) {
      include('./Vue/nav_before.php');
    }
    else {
      include("./Vue/nav_after.php");
    }


    if (isset($login_sesion) && isset($mdp_session)) {
        include("./Vue/section_accueil.php");
    }
    else {
      include("./Vue/authentification_KO.php"); //Si pas de connexion on interdit l'accès à la page
    }

    include("./Vue/footer.php")
?>
