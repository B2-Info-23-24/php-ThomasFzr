{% extends "templates/template.php" %}


{% block head %}
<link rel="stylesheet" href="Public/assets/styles/connectionRegisterStyle.css">
{% endblock %}

{% block content %}
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
                    {% if app.session.surname is defined %}
                    Bonjour, {{ app.session.surname }}!
                    {% elseif app.session.mail is defined %}
                    Bonjour, {{ app.session.mail }}!
                    {% else %}
                    <a href="?page=connection">
                        Me connecter
                    </a>
                    {% endif %}

                </div>

                {% set isVisible = app.request.method == 'POST' and (app.request.request.get('toggleButton') is defined ? not app.request.request.get('isVisible') or app.request.request.get('isVisible') == 'false' : false) %}


                <div id="container-rightheader-topright">
                    {% if app.session.mail is defined %}
                    <form method="post" action="">
                        <button type="submit" name="toggleButton" id="btn-profil">
                            <img src="Public/assets/images/iconeCompte.png" alt="img icone compte" id="imgIconeCompte">
                        </button>
                        <input type="hidden" name="isVisible" value="{{ isVisible ? 'true' : 'false' }}">
                    </form>
                    {% else %}
                    <a href="?page=connection">
                        <img src="Public/assets/images/iconeCompte.png" alt="img icone compte" id="imgIconeCompte">
                    </a>
                    {% endif %}

                </div>
            </div>

            <div id="container-rightheader-bottom">
                <div id="btn-profil-deroulant">
                <!-- class="{{ isVisible ? '' : 'hidden' }}" -->
                    <div class="profil-card">
                        <a href="?page=detailsCompte" id="liens-profil-card">
                            MON COMPTE
                        </a><br>

                        <a href="?page=reservation" id="liens-profil-card">
                            MES RESERVATIONS
                        </a> <br>

                        <a href="?page=avis" id="liens-profil-card">
                            MES AVIS
                        </a> <br>

                        <a href="?page=favoris" id="liens-profil-card">
                            MES FAVORIS
                        </a> <br>

                        <a href="?page=deconnection" id="liens-profil-card">
                            DECONNEXION
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
{% endblock %}