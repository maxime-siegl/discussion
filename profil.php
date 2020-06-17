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
            if(isset($_SESSION['login']))
            {
                $bdd = mysqli_connect("localhost", "root", "", "discussion");
                $info_login = "SELECT * FROM utilisateurs WHERE login = '$_SESSION['login']'";
                $recup_info = mysqli_query($bdd, $info_log);
                $info_utilisateur = mysqli_fetch_all($recup_info, MYSQLI_ASSOC);
        ?>
                <form action="connexion.php" method="POST">
                    <p>
                        <label for="login">Login</label>
                        <input type="text" name="login" id="login" value="<?php echo $info_utilisateur[0]['login'] ?>" >
                        <label for="mdpactuel">Mot de Passe actuel</label>
                        <input type="password" name="mdpactuel" id="mdpactuel">
                        <label for="newmdp">Nouveau Mot de Passe</label>
                        <input type="password" name="newmdp" id="newmdp">
                        <label for="confnewmdp">Confirmation du Nouveau Mot de Passe</label>
                        <input type="password" name="confnewmdp" id="confnewmdp">
                        <input type="submit" value="Modifier" name="modifier" class="submit">
                    </p>
                </form>
        <?php
                if(isset($_POST['modifier']) && !empty($_POST['login']) && !empty($_POST['mdpactuel']))
                {
                    if(password_verify($_POST['mdpactuel'], $_SESSION['password']))
                    {
                        $login = $_POST['login'];
                        $id = $_SESSION['id'];

                        $verif_log = "SELECT COUNT(*) AS all FROM utilisateurs WHERE login = '$login'";
                        $verif = mysqli_query($bdd, $verif_log);
                        $info_log = mysqli_fetch_all($verif, MYSQLI_ASSOC);

                        if($info_log[0]['all'] == 0 || $login == $_SESSION['login'])
                        {
                            $update = "UPDATE utilisateurs SET login = '$login' WHERE id = '$id'";
                            $up = mysqli_query($bdd, $update);
                            $_SESSION['login'] = $_POST['login'];
                        }
                        else
                        {
        ?>
                            <p class="msg">
                                Login Pas disponible.
                            </p>
        <?php
                        }

                        if(isset($_POST['newmdp']) && !empty($_POST['newmdp']))
                        {
                            if ($_POST['newmdp'] == $_POST['confnewmdp'])
                            {
                                $mdpupdate = password_hash($_POST['newmdp'], PASSWORD_BCRYPT);
                                $mdpup = "UPDATE utilisateurs SET password = '$mdpupdate' WHERE id = '$id'";
                                $querymdpup = mysqli_query($bdd, $mdpup);
                            }
                            else
                            {
        ?>
                                <p class="msg">
                                    Ls mots de passe ne correspondent pas, réessayez.
                                </p>
        <?php
                            }
                        }
                    }
                    else
                    {
        ?>
                        <p class="msg">
                            Mot de passe incorect.
                        </p>
        <?php
                    }
                }
            }
            else
            {
        ?>
                <p class="msg">
                    Pensez à vous <a href="connexion.php">connecter</a> ou à vous <a href="inscription.php">inscrire</a>!
                </p>
        <?php
            }
        ?>

    </main>
    <footer></footer>
</body>
</html>