<?php
require_once("modele/fonctions.php");
require_once("controlleur/fonctions.php");
?>

<nav class="navbar navbar-expand navbar-dark bg-*">
  <div class="container">
    <a class="navbar-brand" href="#">Visiteur</a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="nav-link" href="index.php?aller=Accueil"><i class="material-icons">home</i> Accueil</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?aller=Consultation"><i class="material-icons">receipt</i> Consultation frais</a></li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons">archive</i> Ajout frais</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="index.php?aller=FraisForfait">Frais forfaitaire</a>
          <a class="dropdown-item" href="index.php?aller=HorsForfait">Hors forfait</a>
        </div>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="nav-item"><a class="nav-link" href="#"><i class="material-icons">person</i> <?php echo $prenom . " " . $nom ?></a></li>
      <li class="nav-item"> <a class="nav-link" href="index.php?click=1"><i class="material-icons">arrow_right_alt</i> Se déconnecter</a></li>
  </ul>
  </div>
</nav>
