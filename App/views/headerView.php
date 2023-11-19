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
                    <a href="/connection">
                        Me connecter
                    </a>
                </div>

                <div id="container-rightheader-topright">
                    <button type="submit" name="toggleButton" id="btn-profil">
                        <img src="Public/assets/images/iconeCompte.png" alt="img icone compte" id="imgIconeCompte">
                    </button>
                </div>
            </div>

            <div id="container-rightheader-bottom">
                <div id="btn-profil-deroulant" class="profil-card" style="display: none;">
                    <div class="profil-card">
                        <a href="/detailsCompte" id="liens-profil-card">
                            MON COMPTE
                        </a><br>

                        <a href="/reservation" id="liens-profil-card">
                            MES RESERVATIONS
                        </a> <br>

                        <a href="/avis" id="liens-profil-card">
                            MES AVIS
                        </a> <br>

                        <a href="/favoris" id="liens-profil-card">
                            MES FAVORIS
                        </a> <br>

                        <a href="/deconnection" id="liens-profil-card">
                            DECONNEXION
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var btnProfil = document.getElementById('btn-profil');
        var btnProfilDeroulant = document.getElementById('btn-profil-deroulant');

        btnProfil.addEventListener('click', function() {
            btnProfilDeroulant.style.display = (btnProfilDeroulant.style.display === 'none') ? 'block' : 'none';
        });
    });
</script>