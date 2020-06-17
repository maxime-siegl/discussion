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
        ?>
                <p class="msg">
                    Vous êtes déjà connecté <?php echo $_SESSION['login'] ?>
                </p>
                <p class="msg">
                    Passez plutôt sur notre fil de <a href="discussion.php">discussion</a> c'est plus fun !!
                </p>
        <?php
            }
            else
            {
        ?>
                <form action="connexion.php" method="POST">
                    <p>
                        <label for="login">Login</label>
                        <input type="text" name="login" id="login">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password">
                        <input type="submit" value="Se Connecter" name="connexion" id="connexion" class="submit">
                    </p>
                </form>
        <?php
                if(isset($_POST['connexion']))
                {
                    $login = $_POST['login'];
                    $mdp = $_POST['password'];

                    $bdd = mysqli_connect("localhost", "root", "", "discussion");
                    $info_log = "SELECT * FROM utilisateurs WHERE login = '$login'";
                    $query = mysqli_query($bdd, $info_log);
                    $infos = mysqli_fetch_all($query, MYSQLI_ASSOC);

                    $mdp_log = $infos[0]['password']; //mdp qui correspond au login
                    
                    if(!empty($infos))
                    {
                        if(password_verify($mdp, $mdp_log))
                        {
                            session_start();
                            $_SESSION['login'] = $infos[0]['login'];
                            $_SESSION['password'] = $infos[0]['password'];
                            $_SESSION['id'] = $infos[0]['id'];
                            header('location:index.php');
                        }
                        else
                        {
        ?>
                            <p class="msg">
                                Ce login n'a pas pour mot de passe ce que vous avez entré.
                            </p>
        <?php                    
                        }
                    }
                    else
                    {
        ?>
                        <p class="msg">
                            <span id="AB">Air Ball !!</span> Ce login n'existe pas, pensez à passer par la case <a href="inscription.php">inscription</a> de notre site.
                        </p>
        <?php
                    }
                    mysqli_close($bdd);
                }
            }

        ?>
    </main>
    <footer></footer>
</body>
</html>