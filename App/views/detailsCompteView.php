<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Public/assets/styles/connectionRegisterStyle.css">
    <link rel="stylesheet" href="Public/assets/styles/style.css">
    <title>Troc mon toit </title>
</head>

<body>
    <div id="profil-user">
        <h3>Mon profil: </h3>

        <div>
            Nom: <?php if (isset($_SESSION['nom'])) {
                        echo $_SESSION['nom'];
                    } else {
                        echo "Pas encore définis";
                    }
                    ?>
        </div>
        <div>
            <br>Prénom: <?php if (isset($_SESSION['prenom'])) {
                            echo $_SESSION['prenom'];
                        } else {
                            echo "Pas encore définis";
                        }
                        ?>
        </div>
        <div>
            <br>Numéro de téléphone: <?php if (isset($_SESSION['numTel'])) {
                                            echo $_SESSION['numTel'];
                                        } else {
                                            echo "Pas encore définis";
                                        }
                                        ?>
        </div>
        <div>
            <br>Mail : <?php echo $_SESSION['mail']; ?>
        </div>

    </div>

</body>

</html>