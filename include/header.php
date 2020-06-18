<h1 id="titre">Team &#160; <span id="N">N</span> <span id="B">B</span> <span id="A">A</span> &#160; Community <img src="https://img.icons8.com/emoji/48/000000/basketball-emoji.png"/></h1>
<section id="menu">
    <nav>
        <ul id="header_left">
            <li><a href="index.php" id="salle">Salle</a></li>
            <li><a href="discussion.php" id="parquet">Parquet</a></li>
            <li><a href="profil.php" id="vestiaire">Vestiaire</a></li>
        </ul>
        <ul id="header_right">
            <?php
                if (isset($_SESSION['login']))
                {
            ?>
                <li>
                    <form action="" method="POST">
                        <button type="submit" name="deco" class="bouton">Déconnexion</button>
                    </form>
                </li>
            <?php        
                }
                else
                {
            ?>
                <li><a href="connexion.php"><button>Connexion</button></a></li>
                <li><a href="inscription.php"><button>Inscription</button></a></li>
            <?php
                }
            ?>
        </ul>
    </nav>
</section>