<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>Troc mon toit </title>
</head>

<body>
    <input type=button onClick="parent.location='/'" value="Retour">

    </br></br>

    <div id="register-form-wrap">
        <h2>Inscription</h2>
        <form id="register-form">
            <p>
                <input type="email" id="email" name="email" placeholder="Adresse mail" required><i class="validation"><span></span><span></span></i>
            </p>
            <p>
                <input type="text" id="password" name="password" placeholder="Mot de passe" required><i class="validation"><span></span><span></span></i>
            </p>
            <p>
                <input type="submit" id="register" value="S'inscrire">
            </p>
        </form>
        <div id="create-account-wrap">
            <p>Déjà inscris? <a href="?page=connection">Me connecter</a>
            <p>
        </div>
    </div>

</body>

</html>