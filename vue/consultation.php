<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/all.css">
    <link rel="shortcut icon" href="./img/favicon.ico" />
    <script src="/js/bootstrap.min.js"></script>
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
        include("./vue/header.php");

        require_once ('./vue/consultation.php');

        if (isset($login) && isset($mdp)) {
          require_once ('./vue/nav_after.php');
          require_once ('./include/section_consultation.php');
        
        }
        else {
          require_once ("./vue/nav_before.php");
          require_once ("./include/authentification_KO.php");
        }
        require_once ("./vue/footer.php");
      }

      ?>

  </body>
</html>
