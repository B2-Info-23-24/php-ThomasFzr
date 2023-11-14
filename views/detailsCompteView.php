<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="connectionRegisterStyle.css">
    <link rel="stylesheet" href="style.css">
    <title>Troc mon toit </title>
</head>

<body>
    </br></br>
    <p>
    <h3>Mon profil: </h3>


    Nom: <?php if (isset($_SESSION['nom'])) {
                echo $_SESSION['nom'];
            } else {
                echo "Pas encore définis";
            }
            ?>
    <br>Prénom: <?php if (isset($_SESSION['prenom'])) {
                    echo $_SESSION['prenom'];
                } else {
                    echo "Pas encore définis";
                }
                ?>
    <br>Numéro de téléphone: <?php if (isset($_SESSION['numTel'])) {
                                    echo $_SESSION['numTel'];
                                } else {
                                    echo "Pas encore définis";
                                }
                                ?>
    <br>Mail : <?php echo $_SESSION['mail']; ?>


    <br>mot de passe?? jsp



</body>

</html>