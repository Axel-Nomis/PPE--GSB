<?php

require ('C:/xampp/htdocs/PPE--GSB/Modele/modele.php');

$_POST['login'] = "lvillachane";
$_POST['mdp'] = "jux7g";

$querry = recupIDVisiteur ();

if($querry != null) {
  echo 'ça marche';
}

?>
