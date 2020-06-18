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
    <title>Team NBA Community/chat</title>
    <link rel="stylesheet" href="discussion.css">
</head>
<body id="discussion">
    <header>
        <?php include('include/header.php'); ?>
    </header>
    <main id="main_discussion">
        <p id="titre_discussion">Parler Basket avec une commu qui est la pour ça c'est mieux, n'est ce pas <?php echo $_SESSION['login']; ?>?</p>
        <section id="table">
            <table>
                <thead>
                    <tr>
                        <th>Posteurs</th>
                        <th>Messages</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if(isset($_SESSION['login']))
                    {
                        $bdd = mysqli_connect("localhost", "root", "", "discussion");

                        // requete pour les msg
                        $com = "SELECT messages.id, message, id_utilisateur, date, utilisateurs.login FROM messages INNER JOIN utilisateurs ON messages.id_utilisateur = utilisateurs.id ORDER BY date"; // requete pour selectionner les messages, la date et le log de celui qui le poste par ordre de poste...
                        $com_query = mysqli_query($bdd, $com);
                        $info_com = mysqli_fetch_all($com_query, MYSQLI_ASSOC);
                        //var_dump($info_com);

                        //requete pour recup le mdp dans la bdd
                        $info_admin = "SELECT * FROM utilisateurs WHERE login = 'admin'";
                        $admin_query = mysqli_query($bdd, $info_admin);
                        $admin = mysqli_fetch_all($admin_query, MYSQLI_ASSOC);
                        //var_dump($admin);
                        foreach ($admin as $clé => $info_admin)
                        {}

                        foreach ($info_com as $com => $infos)
                        {
                            echo '<tr>';
                            echo '<td>';
                            echo '<p id="login">'.$infos['login'].'</p>';
                            echo '<br>';
                            echo '<p id="date">'.$infos['date'].'</p>';
                            echo '</td>';
                            echo '<td>';
                            echo '<p id="message">'.$infos['message'].'</p>';
                            echo '</td>';
                            echo '<td>';
                            $id_posteur = $infos['id_utilisateur']; // recup l'id de l'utitilisateur a la ligne x
                            //var_dump($infos['id']);

                            if ($_SESSION['id'] == $id_posteur)
                            {
                ?>
                                <a href="discussion.php?id=<?php echo $infos['id']; ?>"><img src="https://img.icons8.com/wired/64/000000/delete-sign.png"/></a>          
                <?php
                                if(isset($_GET['id']) && !empty($_GET['id']))  // clic img supp 
                                {
                                    if ($_GET['id'] == $infos['id']) // get = a l'id du msg
                                    {
                                        $id_msg = $_GET['id'];
                                        $delete = "DELETE FROM messages WHERE id = '$id_msg' ";
                                        $delete_query = mysqli_query($bdd, $delete);
                                    }
                                    header('location:discussion.php');
                                }
                            }
                            else if ($_SESSION['login'] == 'admin' && $_SESSION['password'] == $info_admin['password']) // ajouter condition password == admin
                            {
                ?>
                                <a href="discussion.php?id=<?php echo $infos['id']; ?>"><img src="https://img.icons8.com/wired/64/000000/delete-sign.png"/></a>          
                <?php
                                if(isset($_GET['id']) && !empty($_GET['id']))  // clic img supp 
                                {
                                    if ($_GET['id'] == $infos['id']) // get = a l'id du msg
                                    {
                                        $id_msg = $_GET['id'];
                                        $delete = "DELETE FROM messages WHERE id = '$id_msg' ";
                                        $delete_query = mysqli_query($bdd, $delete);
                                    }
                                    header('location:discussion.php');
                                }
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                ?>
                    </tbody>
            </table>
        </section>
            <form action="discussion.php" method="POST" id="formulaire_discussion">
                <p id="infos_form_discussion">
                    <label for="msg">Discutez</label>
                    <textarea name="msg" id="msg" cols="50" rows="3" placeholder="Ecrivez ici..."></textarea>
                    <button type="submit" name="envoyer" class="submit">Shoot</button>
                </p>
            </form>
            <?php
                    if (isset($_POST['envoyer']) && !empty($_POST['msg']))
                    {
                        $msg = $_POST['msg'];
                        $id = $_SESSION['id'];

                        $ajout = "INSERT INTO messages (message, id_utilisateur, date) VALUES ('$msg', $id, NOW())";
                        $ajout_query = mysqli_query($bdd, $ajout);
                        header('location:discussion.php'); 
                    }
                    mysqli_close($bdd);
                }
                else
                {
                    header('location:connexion.php');
                }
            ?>
    </main>
    <footer>
        <?php include('include/footer.php'); ?>
    </footer>
</body>
</html>