<input type=button onClick="parent.location='index.php'" value="Retour">

</br></br>
<div id="login-form-wrap">
  <h2>Connexion</h2>
  <form id="login-form">
    <p>
    <input type="email" id="email" name="email" placeholder="Adresse mail" required><i class="validation"><span></span><span></span></i>
    </p>
    <p>
    <input type="text" id="password" name="password" placeholder="Mot de passe" required><i class="validation"><span></span><span></span></i>
    </p>
    <p>
    <input type="submit" id="login" value="Login">
    </p>
  </form>
  <div id="create-account-wrap">
    <p>Not a member? <a href="/creationCompte.php">Create Account</a><p>
  </div><!--create-account-wrap-->
</div><!--login-form-wrap-->