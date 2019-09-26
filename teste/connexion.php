<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/all.css">
    <title>Galaxy Swiss Bourdin</title>
  </head>
  <body id="t">

<!-- DEBUT SECTION -->
<section id="connexion">
  <div>
    <h2>Connexion</h2>
    <form action="index.php" method="post">
      <div class="form-group">
        <label for="login">Identifiant :</label>
        <input type="text" class="form-control" id="login" name="login" placeholder="Saisir votre identifiant" required>
      </div>
      <div class="form-group">
        <label for="mdp">Mot de passe :</label>
        <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Saisir votre mot de passe" required>
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

</div>

</body>

<!-- FIN FOOTER -->
<?php
include("Vue/footer.php")
?>

</html>
