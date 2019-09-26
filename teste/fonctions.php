<?php

/**
 * Nettoie une valeur insérée dans une page HTML
 * Doit être utilisée à chaque insertion de données dynamique dans une page HTML
 * Permet d'éviter les problèmes d'exécution de code indésirable (XSS)
 * @param string $valeur Valeur à nettoyer
 * @return string Valeur nettoyée
 */
function escape($valeur){
    // Convertit les caractères spéciaux en entités HTML
    return htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8', false);
}

/**
 * Gère la connexion à la base de données
 * @return PDO Objet de connexion à la BD
 */
function getBdd() {
    return new PDO("mysql:host=localhost;dbname=db_GSB;charset=utf8",
        "root", "",
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}


function authentification(){

  //session_start();  // démarrage d'une session

  // on vérifie que les données du formulaire sont présentes
  if (isset($_POST['login']) && isset($_POST['mdp'])) {

      $bdd = getBdd();
      // cette requête permet de récupérer l'utilisateur depuis la BD
      $requete = "SELECT * FROM Visiteur WHERE login=? AND mdp=?";
      $resultat = $bdd->prepare($requete);
      $login = $_POST['login'];
      $mdp = $_POST['mdp'];
      $resultat->execute(array($login, $mdp));
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
      require("accueil.php");
  }
  else {

     require("connexion.php");
      //echo "Vous n'avez pas été reconnu(e)";
      exit();
    }
}



function verifSession(){
  if(!session_id()){
    session_start();
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
      include("./Vue/header.php");



      if (isset($login) && isset($mdp)) {
        include('./Vue/nav_after.php');
        include('./include/section_consultation.php');
      }
      else {
        include("./Vue/nav_before.php");
        include("./include/authentification_KO.php");
      }
      include("./Vue/footer.php");
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
        include("./Vue/header.php");

        if (isset($login) && isset($mdp)) {
          include('./Vue/nav_after.php');
          include("./include/section_accueil.php");
        }
        else {
          include("./Vue/nav_before.php");
          include("./include/authentification_KO.php");
        }
        include("./Vue/footer.php");
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
