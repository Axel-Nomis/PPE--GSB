
<?php

  if (isset($_POST['libelleFraisForfait']) && isset($_POST['quantite'])) {

    $quantite = htmlspecialchars($_POST['quantite']);
    $libelleFraisForfait = htmlspecialchars($_POST['libelleFraisForfait']);

    if(!empty($quantite) && !empty($libelleFraisForfait)) {

      try {
        $bdd= getBdd();
      }
      catch(Exception $e){
        die('Erreur : '. $e->getMessage());
      }

      $mois = date('F'); //On récupère le mois en cours pour l'insertion dans la base

      //Insert des frais forfaitaires dans la base
      $requete = "INSERT INTO `LigneFraisForfait`(idVisiteur, mois, idFraisForfait, quantite) VALUES (:idVisiteur, :mois, :idFraisForfait, :quantite) ON DUPLICATE KEY UPDATE quantite = quantite + :quantite";
      $query = $bdd -> prepare($requete);
      $query -> execute(array(
        ':idVisiteur' => $id,
        ':mois' => $mois,
        ':idFraisForfait' => $libelleFraisForfait,
        ':quantite' => $quantite
      ));

      $fraisForfait = 'Vos frais forfaitaires ont bien été pris en compte';

    }
    else {
      echo "Veuillez remplir tous les champs !";
    }
  }
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

    require_once ('controlleur/fonctions.php');
    require_once ('modele/fonctions.php');
    fraisForfait();

  ?>
  </body>
</html>
