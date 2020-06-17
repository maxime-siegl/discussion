<?php
    session_start();
    if (isset($_POST['deco']))
    {
        session_destroy();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>NBA 2K</title>
    <link rel="stylesheet" href="discussion.css">
</head>
<body>
    <header></header>
    <main>
        <?php
            $bdd = mysqli_connect("localhost", "root", "", "discussion");

            if(isset($_SESSION['login']) == false)
            {
        ?>
                <form action="inscription.php" method="POST">
                    <p>
                        <label for="login">Login</label>
                        <input type="text" name="login" id="login" required>
                        <label for="password">Mot de Passe</label>
                        <input type="password" name="password" id="password" required>
                        <label for="confpw">Confirmation du Mot de Passe</label>
                        <input type="password" name="confpw" id="confpw" required>
                        <input type="submit" name="inscription" value="S'inscrire" class="submit">
                    </p>
                </form>
        <?php
                if(isset($_POST['inscription']))
                {
                    $login = $_POST['login'];
                    $mdp = $_POST['password'];

                    $checklogin = "SELECT login FROM utilisateurs WHERE login = '$login'";
                    $query = mysqli_query($bdd, $checklogin);
                    $veriflogin = mysqli_fetch_all($query);

                    if(empty($veriflogin))
                    {
                        if($_POST['password'] == $_POST['confpw'])
                        {
                            $cryptmdp = password_hash($mdp, PASSWORD_BCRYPT);
                            $ajoutbdd = "INSERT INTO utilisateurs VALUES (null, '$login', '$cryptmdp')";
                            $ajout = mysqli_query($bdd, $ajoutbdd);
                            header('location:connexion.php');
                        }
                        else
                        {
        ?>
                            <p class="msg">
                                Les mots de passes ne sont pas identiques à la virgule près.
                            </p>
        <?php
                        }
                    }
                    else
                    {
        ?>
                        <p class="msg">
                            Login déjà pris, Try Again !!
                        </p>                
        <?php
                    }
                }
            }
            else
            {
        ?>
                <p id="inscrit">
                    Mon petit doigt me dit que tu es déjà inscrit, au lieu de perdre du temps en t'inscrivant deux fois, viens <a href="discussion.php">discuter</a> avec nous !!
                </p>
        <?php
            }
            mysqli_close($bdd);
        ?>
    </main>
    <footer></footer>
</body>
</html>