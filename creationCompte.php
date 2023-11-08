<input type=button onClick="parent.location='index.php'" value="Retour">

</br></br>

<form action="action_page.php">
  <div class="container">
    <h1>Créer mon compte</h1>
    <hr>

    <label for="email"><b>Mail</b></label>
    <input type="text" placeholder="Entrer votre mail" name="email" id="email" required>

    <label for="psw"><b>Mot de passe</b></label>
    <input type="password" placeholder="Entrer votre mdp" name="psw" id="psw" required>

    <label for="psw-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
    <hr>

    <button type="submit" class="registerbtn">Créer</button>
  </div>

  <div class="container signin">
    <p>Already have an account? <a href="/connection.php">Sign in</a>.</p>
  </div>
</form>