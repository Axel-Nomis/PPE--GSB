<?php

function authentification(){

  //session_start();  // démarrage d'une session

  // on vérifie que les données du formulaire sont présentes
  $authOK = "";
  if (isset($_POST['login']) && isset($_POST['mdp'])) {

      $bdd = getBdd();
      // cette requête permet de récupérer l'utilisateur depuis la BD
      $requete = "SELECT * FROM Visiteur WHERE login=:login AND mdp=:mdp";
      $resultat = $bdd->prepare($requete);
      $login = $_POST['login'];
      $mdp = $_POST['mdp'];

      $resultat->execute(array(':login'=> $login, ':mdp' => $mdp));
	  $donnees = $resultat->fetch();
      if ($donnees == true) {
          // Si un visiteur correspond
      //Création des variables de session
      $_SESSION['login'] = $donnees['login'];
      $_SESSION['mdp'] = $donnees['mdp'];
      $_SESSION['id'] = $donnees['id'];
      $_SESSION['nom'] = $donnees['nom'];
      $_SESSION['prenom'] = $donnees['prenom'];
          // cette variable indique que l'authentification a réussi
          $authOK = true;
      }
  }
  return $authOK;


}



function consultation(){

  //session_start();  // démarrage d'une session

  // on vérifie que les variables de session identifiant l'utilisateur existent

  }


  function accueil(){
    //session_start();  // démarrage d'une session


    // on vérifie que les variables de session identifiant l'utilisateur existent

    }


  function fraisForfait($id, $libelleFraisForfait, $quantite){

    $mois = date('F'); //On récupère le mois en cours pour l'insertion dans la base

    if(!empty($quantite) && !empty($libelleFraisForfait)) {
      insertion_fraisForfait($id, $mois, $libelleFraisForfait, $quantite);
    }
    else {
      echo "Veuillez remplir tous les champs !";
    }

}





function horsForfait($id, $libelle, $date, $prix){

  $mois = date('F'); //On récupère le mois en cours

  if(!empty($date) && !empty($libelle) && !empty($prix)) {
    //Insert des frais hors forfait dans la base
    insertion_horsForfait($id, $mois, $libelle, $date, $prix);
    echo 'Vos frais Hors Forfaits ont bien été pris en compte';
  }
  else {
    echo "Veuillez remplir tous les champs !";
  }

}








	function deco(){
		// On détruit les variables de notre session
		session_unset ();

		// On détruit notre session
		session_destroy ();

		// On redirige le visiteur vers la page d'accueil
		header('Location: index.php');
	}

?>
