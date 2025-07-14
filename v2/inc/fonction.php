<?php 
    require 'connexion.php';

    /* Inscription et connexion */
function inscription($email, $nom, $date_de_naissance, $mdp)
{
    $connexion = connection();

    $requete = "INSERT INTO UTILISATEUR (Email, Nom, Date_naissance, Mot_de_passe) VALUES ('%s', '%s', '%s', '%s')";
    $final = sprintf($requete, $email, $nom, $date_de_naissance, $mdp);
    $insertion = mysqli_query($connexion, $final);
    header('Location: ../index.php');
}

function login($email, $mdp)
{
    $connexion = connection();

    $requete = "SELECT * FROM Membre WHERE email = '%s' AND mot_de_passe = '%s'";
    $final = sprintf($requete, $email, $mdp);
    $result = mysqli_query($connexion, $final);
    $data = mysqli_fetch_assoc($result);
    if ($data) {
        unset($data['Mot_de_passe']);
        $_SESSION['user'] = $data;
        header('Location: ./pages/accueil.php');
        exit();
    } else {
        $_SESSION['error'] = "Email ou mot de passe incorrect !";
    }
}

function list_object()
{
    $connexion = connection();

    $sql = "SELECT * FROM Objet";

    $trait = mysqli_query($connexion, $sql);

    $liste = array();

    while( $result = mysqli_fetch_assoc($trait))
    {
        $liste[] = $result;
    }

    mysqli_free_result($trait);
    deconnection($connexion);
    return $liste;
} 


function objet_emprunter() {
    $connexion = connection();

    $sql = "SELECT id_objet, date_retour FROM emprunt WHERE date_retour IS NOT NULL";
    $resultat = mysqli_query($connexion, $sql);

    $liste = array();
    while ($row = mysqli_fetch_assoc($resultat)) {
        $liste[$row['id_objet']] = $row['date_retour'];
    }

    mysqli_free_result($resultat);
    deconnection($connexion);

    return $liste;
}

function list_categorie()
{
    $connexion = connection();

    $sql = "SELECT * FROM categorie_objet";

    $trait = mysqli_query($connexion, $sql);

    $liste = array();

    while( $result = mysqli_fetch_assoc($trait))
    {
        $liste[] = $result;
    }

    mysqli_free_result($trait);
    deconnection($connexion);
    return $liste;
}

function filtre_objets_par_categorie($id_categorie)
{
    $connexion = connection();

    $sql = "SELECT * FROM Objet WHERE id_categorie = %d";
    $sql = sprintf($sql, $id_categorie);

    $trait = mysqli_query($connexion, $sql);

    $liste = array();
    while ($result = mysqli_fetch_assoc($trait)) {
        $liste[] = $result;
    }

    mysqli_free_result($trait);
    deconnection($connexion);
    return $liste;
}


?>