<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Public/assets/styles/style.css">
    <title>Troc mon toit </title>
</head>

<body>

    <div id="container-allheader">
        <div id="container-header">
            <div id="container-leftheader">
                <a href="/" id="lien-logo-tmt">
                    <h1>TROC MON TOIT</h1>
                </a>
            </div>
            <div id="container-rightheader">

                <div id="container-rightheader-top">
                    <div id="container-rightheader-topleft">
                        <?php
                        if (isset($_SESSION['mail'])) {
                            echo "Bonjour, " . $_SESSION['mail'];
                            echo "!";
                        } else {
                            echo '<a href="?page=connection">
                            Me connecter
                        </a>';
                        }
                        ?>
                    </div>

                    <?php
                    if (isset($_POST['toggleButton'])) {
                        $isVisible = !isset($_POST['isVisible']) || $_POST['isVisible'] == 'false';
                    } else {
                        $isVisible = false;
                    }
                    ?>

                    <div id="container-rightheader-topright">
                        <?php
                        if (isset($_SESSION['mail'])) {
                            echo '<form method="post" action="">
                                        <button type="submit" name="toggleButton" id="btn-profil">
                                        <img src="Public/assets/images/iconeCompte.png" alt="img icone compte" id="imgIconeCompte">
                                        </button>
                                        <input type="hidden" name="isVisible" value="' . ($isVisible ? 'true' : 'false') . '">
                                  </form>';
                        } else {
                            echo '<a href="?page=connection">
                                     <img src="Public/assets/images/iconeCompte.png" alt="img icone compte" id="imgIconeCompte">
                                  </a>';
                        }
                        ?>
                    </div>
                </div>

                <div id="container-rightheader-bottom">
                    <div id="btn-profil-deroulant" class="<?php echo $isVisible ? '' : 'hidden'; ?>">
                        <div class="profil-card">
                            <a href="?page=detailsCompte" id="liens-profil-card">
                                MON COMPTE</a><br>

                                <a href="?page=reservation" id="liens-profil-card">
                                MES RESERVATIONS</a> <br>

                                <a href="?page=avis" id="liens-profil-card">
                                MES AVIS</a> <br>

                            <a href="?page=favoris" id="liens-profil-card">
                                MES FAVORIS</a> <br>

                            <a href="?page=deconnection" id="liens-profil-card">
                                DECONNEXION</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>