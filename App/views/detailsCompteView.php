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
            Nom: <?php if (isset($_SESSION['name'])) {
                        echo $_SESSION['name'];
                    } else {
                        echo "Pas encore définis";
                    }
                    ?>
        </div>
        <div>
            <br>Prénom: <?php if (isset($_SESSION['surname'])) {
                            echo $_SESSION['surname'];
                        } else {
                            echo "Pas encore définis";
                        }
                        ?>
        </div>
        <div>
            <br>Numéro de téléphone: <?php if (isset($_SESSION['phoneNbr'])) {
                                            echo $_SESSION['phoneNbr'];
                                        } else {
                                            echo "Pas encore définis";
                                        }
                                        ?>
        </div>
        <div>
            <br>Mail : <?php echo $_SESSION['mail']; ?>
        </div>
    </div>

    <div id="profil-user-modif">
        <h3>Modif: </h3>


        <form action="?page=editInfoUser" method="post">
            <input type="text" id="name" name="name" placeholder="name">
            <input type="text" id="surname" name="surname" placeholder="surname">
            <input type="number" id="name" name="phoneNbr" placeholder="phoneNbr">
            <input type="submit" value="Modifier">
        </form>

    </div>

</body>

</html>