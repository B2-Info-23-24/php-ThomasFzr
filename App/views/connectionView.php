<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Public/assets/styles/connectionRegisterStyle.css">
    <link rel="stylesheet" href="Public/assets/styles/style.css">
    <title>Troc mon toit </title>
</head>

<body>

    </br></br> 
    <div id="login-form-wrap">
        <h2>Connexion</h2>
        <form id="login-form" action="?page=process_login" method="post">
            <p>
                <input type="email" id="email" name="email" placeholder="Adresse mail" required><i class="validation"><span></span><span></span></i>
            </p>
            <p>
                <input type="text" id="password" name="password" placeholder="Mot de passe" required><i class="validation"><span></span><span></span></i>
            </p>
            <p>
                <input type="submit" id="login" value="SE CONNECTER">
            </p>
        </form>
        <div id="create-account-wrap">
            <p>Pas encore inscris? <a href="?page=inscription">M'inscrire</a>
            <p>
        </div>
    </div>

</body>

</html>