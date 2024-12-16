<?php session_start()?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

</head>
<body>

<?php include ("includes/header.php") ?>
<?php if(!isset($_SESSION['pseudo']) || empty($_SESSION)){ ?>
<section class="container">
        <h1>Bienvenue sur le pokedex</h1>
        <?php
        if (isset($_GET['message']) && !empty($_GET['message'])) {
            echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
        }
        ?>
    <div class="main">
        <h2>Ouvrir une session utilisateur</h2>
            <form method="POST" action="traitement.php">

                <input class="input2" type="text" name="pseudo" id="pseudo" value="<?= isset($_COOKIE['pseudo']) ? $_COOKIE['pseudo'] : '' ?>" placeholder="Veuillez entrer votre pseudo" required>
                <input class="input2" type="submit" value="Envoyer">
            </form>

    </div>
</section>
<?php }else { ?>
<section class="container">
    <h1>Bienvenue sur le pokedex</h1>

    <?php
    if (isset($_GET['message'])) {
        echo "<p class='erreur' >" . htmlspecialchars($_GET['message']) . "</p>";
    }
    ?>

    <div class="main">
        <h2>Rechercher un pokémon</h2>
        <form method="POST" action="pokemon.php">

            <div class="form-group">
                <label>Nom :</label>
                <br>
                <br>
                <input class="input3" type="text" name="Nom">
            </div>

            <div class="form-group">
                <label>Identifiant :</label>
                <br>
                <br>
                <input class="input3" type="text" name="Identifiant" >
            </div>

            <div class="form-group">
                <label> </label>
                <br>
                <br>
                <input class="input3" type="submit" value="Envoyer">
            </div>

        </form>

        <article>
            <?php
            $_SESSION['historique'] = [];

            if (isset($_GET['id'])) {
                echo "<p>" . htmlspecialchars($_GET['id']) . "</p>";
            }
            if (isset($_GET['gen'])) {
                echo "<p>" . htmlspecialchars($_GET['gen']) . "</p>";
            }
            if (isset($_GET['cat'])) {
                echo "<p>" . htmlspecialchars($_GET['cat']) . "</p>";
            }
            if (isset($_GET['name'])) {
                echo "<p>" . htmlspecialchars($_GET['name']) . "</p>";
                $_SESSION['historique'][] = $_GET['name'];
            }
            if (isset($_GET['type'])) {
                echo "<p>" . htmlspecialchars($_GET['type']) . "</p>";
            }
            if (isset($_GET['img'])) {
                // Récupérer l'URL de l'image depuis l'URL
                $imgUrl = $_GET['img'];

                // Afficher l'image
                echo "<img src='" . $imgUrl . "' alt='Image'>";
            }


            ?>

        </article>

        <h3>Historique</h3>
        <?php
        $historique = 0;
        echo "<ul>";
        foreach($_SESSION['historique'] as $historique){
            $url = "pokemon.php?name=" . urlencode($_SERVER['QUERY_STRING']);
            echo "<li><a href='" . $url . "'>" . htmlspecialchars($historique) . "</a></li>";
        }
        echo "</ul>";

        ?>



    </div>
</section>

<?php } ?>
</body>
</html>
