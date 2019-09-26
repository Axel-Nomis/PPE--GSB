<?php
require_once("fonctions.php");
?>

<nav class="navbar navbar-expand navbar-dark bg-*">
  <div class="container">
    <a class="navbar-brand" href="#">Visiteur</a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="nav-link" href="index.php?aller=Accueil"><i class="fas fa-home"></i> Accueil</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?aller=Consultation"><i class="fas fa-eye"></i> Consultation frais</a></li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus"></i> Ajout frais</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="fraisForfait.php">Frais forfaitaire</a>
          <a class="dropdown-item" href="horsForfait.php">Hors forfait</a>
        </div>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-user"></i> <?php echo $prenom . " " . $nom ?></a></li>
      <li class="nav-item"> <a class="nav-link" href="index.php?click=1"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a></li>
  </ul>
  </div>
</nav>