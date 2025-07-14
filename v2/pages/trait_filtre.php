<?php 
include('../inc/fonction.php');
session_start();

$cat = $_POST['cat'];

if ($cat == 0) {
    unset($_SESSION['filt']);
} else {
    $_SESSION['filt'] = filtre_objets_par_categorie($cat);
}

header('Location: accueil.php');
exit();
