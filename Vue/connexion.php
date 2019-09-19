<?php
    session_start();
    require('../Modele/modele.php');
    if(isset($_POST['login']) && isset($_POST['mdp'])){
      connexion();
    }


?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/all.css">
    <script src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/date.js"></script>
    <title>Galaxy Swiss Bourdin</title>
  </head>
  <body>


<?php
  include("../Vue/header.php");
  include("../Vue/nav_after.php");
?>


<!-- DEBUT SECTION -->
<section>
  <div class="container" id="section">
    <h2>Espace de connexion</h2>
    <form action="connexion.php" method="post" id="connexion">
      <div class="form-group">
        <label for="login">Votre identifiant :</label>
        <input type="text" class="form-control" id="login" name="login" placeholder="Entrez votre identifiant" required>
      </div>
      <div class="form-group">
        <label for="mdp">Votre mot de passe :</label>
        <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Entrez votre mot de passe" required>
      </div>
      <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Se connecter</button>
      <button type="reset" class="btn btn-primary">Annuler</button>
    </form>
    <?php
      if (isset($erreur)) {
        echo $erreur;
      }
    ?>
  </div>
</section>



<?php include("../Vue/footer.php") ?>
<!-- FIN FOOTER -->
</body>

</html>
