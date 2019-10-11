<?php

function authentification(){

  //session_start();  // démarrage d'une session

  // on vérifie que les données du formulaire sont présentes
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

  if (isset($authOK)) {
      accueil();
  }
  else {

     require("vue/connexion.php");
      //echo "Vous n'avez pas été reconnu(e)";
      exit();
    }
}



function consultation(){

  //session_start();  // démarrage d'une session

  // on vérifie que les variables de session identifiant l'utilisateur existent
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
  }


  function accueil(){
    //session_start();  // démarrage d'une session
	if (isset($_GET["aller"])=='Accueil'){
		$aller=null;
	}

    // on vérifie que les variables de session identifiant l'utilisateur existent
    if (isset($_SESSION['login']) && isset($_SESSION['mdp'])) {
        $login = $_SESSION['login'];
        $mdp = $_SESSION['mdp'];
        $id = $_SESSION['id'];
        $nom = $_SESSION['nom'];
        $prenom = $_SESSION['prenom'];
        require("./vue/header.php");
        require ("./vue/accueil.php");

        if (isset($login) && isset($mdp)) {
          require('./vue/nav_after.php');
          require("./include/section_accueil.php");
        }
        else {
          require("./vue/nav_before.php");
          require("./include/authentification_KO.php");
        }
        require("./vue/footer.php");
      }
    }


  function fraisForfait(){

    if (isset($_GET["aller"])=='FraisForfait'){
  		$aller=null;
  	}


    // on vérifie que les variables de session identifiant l'utilisateur existent
    if (isset($_SESSION['login']) && isset($_SESSION['mdp'])) {
        $login_sesion = $_SESSION['login'];
        $mdp_session = $_SESSION['mdp'];
        $id = $_SESSION['id'];
        $nom = $_SESSION['nom'];
        $prenom = $_SESSION['prenom'];

    require("./vue/header.php");


    if (isset($login_sesion) && isset($mdp_session)) {
      require('./vue/nav_after.php');
      require('./include/section_fraisForfait.php');
    }
    else {
      require("./vue/nav_before.php");
      require("./include/authentification_KO.php");
    }

    require("./vue/footer.php");
  }
}




function horsForfait(){


  if (isset($_GET["aller"])=='HorsForfait'){
    $aller='Session';
  }

  // on vérifie que les variables de session identifiant l'utilisateur existent
  if (isset($_SESSION['login']) && isset($_SESSION['mdp'])) {
      $login_sesion = $_SESSION['login'];
      $mdp_session = $_SESSION['mdp'];
      $id = $_SESSION['id'];
      $nom = $_SESSION['nom'];
      $prenom = $_SESSION['prenom'];


  require("./vue/header.php");
  require ("./vue/horsForfait.php");

  if (isset($login_sesion) && isset($mdp_session)) {
    require('./vue/nav_after.php');
    require('./include/section_horsForfait.php');
  }
  else {
    require("./vue/nav_before.php");
    require("./include/authentification_KO.php");
  }
  require("./vue/footer.php");
}

}



function hf(){

  if (isset($_GET["aller"])=='HorsForfait'){
    $aller='HorsForfait';
  }

if (isset($_POST['date']) && isset($_POST['libelle']) && isset($_POST['prix'])) {

  $date = escape($_POST['date']);
  $libelle = escape($_POST['libelle']);
  $prix = escape($_POST['prix']);

  if(!empty($date) && !empty($libelle) && !empty($prix)) {

    try {
      $bdd= getBdd();
    }
    catch(Exception $e){
      die('Erreur : '. $e->getMessage());
    }

    $mois = date('F'); //On récupère le mois en cours

    //Insert des frais hors forfait dans la base
    $requete = "INSERT INTO `LigneFraisHorsForfait`(id, idVisiteur, mois, libelle, dateHF, montant) VALUES (NULL, :idVisiteur, :mois, :libelle, :dateHF, :montant)";
    //INSERT INTO `lignefraishorsforfait` (`id`, `idVisiteur`, `mois`, `libelle`, `dateHF`, `montant`) VALUES (NULL, 'a131', 'December', 'Fin du monde', '2019-12-09', '81')
    $query = $bdd -> prepare($requete);
    $query -> execute(array(
      ':idVisiteur' => $id,
      ':mois' => $mois,
      ':libelle' => $libelle,
      ':dateHF' => $date,
      ':montant' => $prix



    ));

    $fraisHorsForfait = 'Vos frais Hors Forfaits ont bien été pris en compte';

  }
  else {
    echo "Veuillez remplir tous les champs !";
  }
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
