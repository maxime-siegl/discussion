<?php
    session_start();
    if (isset($_POST['deco']))
    {
        session_destroy();
        header('location:connexion.php');
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Team NBA Community</title>
    <link rel="stylesheet" href="discussion.css">
</head>
<body id="index">
    <header>
        <?php include('include/header.php'); ?>
    </header>
    <main>
        <section id="main_index">
            <?php
                if (isset($_SESSION['login']))
                {
            ?>
                    <h2>Bienvenue chez toi, <?php echo $_SESSION['login']; ?> !! <img src="img/iconnba.png" alt="icon NBA" class="icon_nba"></h2>
                    <p class="description">Ce site est fait par un Fan de NBA pour parler Basket, et surtout sur la NBA !!</p>
                    <p class="link">Si tu veux échanger avec notre commu, je te propose de prendre ton sac et de nous rejoindre au <a href="vestiaire.php">Vestiaire</a>!</p>
            <?php
                }
                else
                {
            ?>
                    <h2>Bonjour à toi ! <img src="img/iconnba.png" alt="icon NBA" class="icon_nba"></h2>
                    <p class="description">Bienvenue sur ce site fait par des fans pour des fans, de la NBA</p>
                    <p class="link">Penses à t'<a href="inscirption.php">inscrire</a> si tu veux pouvoir échanger avec la commu, et si tu es déjà inscrit <a href="connexion.php">connectes-toi</a></p>
            <?php
                }
            ?>
        </section>
    </main>
    <footer>
        <?php include('include/footer.php'); ?>
    </footer>
</body>
</html>