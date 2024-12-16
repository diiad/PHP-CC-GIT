<?php
session_start();

// Enregistrement du pseudo dans un cookie si fourni
if (isset($_POST['pseudo']) && !empty($_POST['pseudo'])) {
    setcookie('pseudo', $_POST['pseudo'], time() + 24 * 3600);
}

// Vérifications du pseudo
if (!isset($_POST['pseudo']) || empty($_POST['pseudo'])) {
    header('location: index.php?message=Votre pseudo est vide!');
    exit;
}

if ($_POST['pseudo'] != 'test') {
    header('location: index.php?message=Pseudo incorrect');
    exit;
}

if (isset($_POST['nom']) && !empty($_POST['nom'])) {
    setcookie('nom', $_POST['nom'], time() + 24 * 3600);
}

if (!isset($_POST['nom']) || empty($_POST['nom'] || $_POST['id']) || empty($_POST['id'] )) {
    header('location: index.php?message=Rentre le nom d un pokemon ');
    
}



$_SESSION['pseudo'] = $_POST['pseudo'];
header('location: index.php');




?>
