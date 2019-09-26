<?php

require ('fonctions.php');
session_start();  // démarrage d'une session

// on vérifie que les variables de session identifiant l'utilisateur existent
if (isset($_SESSION['login']) && isset($_SESSION['mdp'])) {
    $login = $_SESSION['login'];
    $mdp = $_SESSION['mdp'];




}
authentification();
?>
