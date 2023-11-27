<div id="container-allheader">
    <div id="container-header">
        <div id="container-leftheader">
            <a href="/" id="lien-logo-tmt">
                <h1>TROC MON TOIT</h1>
            </a>
        </div>
        <div id="container-rightheader">
            {% if isConnected %}
            <div id="container-rightheader-top">
                <div id="container-rightheader-topleft">

                    {% if isAdmin %}
                    Compte admin
                    {% elseif surname is defined %}
                    Bonjour, {{surname}}!
                    {% else %}
                    Bonjour!
                    {% endif %}

                </div>
                <div id="container-rightheader-topright">
                    <a href="javascript:void(0)" id="btn-profil">
                        <img src="Public/assets/images/iconeCompte.png" alt="img icone compte" id="imgIconeCompte">
                    </a>
                </div>
            </div>
            {% else %}
            <div id="container-rightheader-top">
                <div id="container-rightheader-topleft">
                    <a href="/connection">
                        Me connecter
                    </a>
                </div>
                <div id="container-rightheader-topright">
                    <a href="/connection">
                        <img src="Public/assets/images/iconeCompte.png" alt="img icone compte" id="imgIconeCompte">
                    </a>
                </div>
            </div>
            {% endif %}

            <div id="container-rightheader-bottom">
                <div id="btn-profil-deroulant" class="profil-card" style="display: none;">
                    <div class="profil-card">
                        {% if isAdmin %}
                        <a href="/detailsUtilisateur" id="liens-profil-card">UTILISATEURS</a><br>
                        <a href="/detailsAvis" id="liens-profil-card">AVIS</a><br>
                        <a href="/detailsTypesLogement" id="liens-profil-card">TYPES LOGEMENT</a><br>
                        <a href="/detailsEquipementsServices" id="liens-profil-card">EQUIPEMENTS/SERVICES</a><br>
                        {%else%}
                        <a href="/detailsCompte" id="liens-profil-card">MON COMPTE</a><br>
                        <a href="/reservation" id="liens-profil-card">MES RESERVATIONS</a><br>
                        <a href="/avis" id="liens-profil-card">MES AVIS</a><br>
                        <a href="/favoris" id="liens-profil-card">MES FAVORIS</a><br>
                        {%endif%}
                        <a href="/deconnection" id="liens-profil-card">DECONNEXION</a>
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
            if (btnProfilDeroulant.style.display === 'none' || btnProfilDeroulant.style.display === '') {
                btnProfilDeroulant.style.display = 'block';
            } else {
                btnProfilDeroulant.style.display = 'none';
            }
        });
    });
</script>