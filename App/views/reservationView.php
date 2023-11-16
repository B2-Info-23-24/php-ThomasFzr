{% extends "templates/template.php" %}


{% block head %}
<link rel="stylesheet" href="Public/assets/styles/connectionRegisterStyle.css">
{% endblock %}

{% block content %}
</br></br>

<h3> Réservations en cours: </h3>

------------------------------------- <br>

<h3> Réservations passées: </h3>

<div class="zone-annonce">
    <a href="?page=detailsLogement" id="lien-annonce">
        <div class="annonce">
            <img src="https://a2.muscache.com/im/pictures/6152848/b04eddeb_original.jpg?aki_policy=x_medium">
            <div class="zone-prix">158 €/nuit</div>
            <div class="description">
                <h4>Loft Studio in the Central Area</h4>
            </div>
        </div>
    </a>

    <div class="annonce">
        <img src="https://a2.muscache.com/im/pictures/34792065/bae84a3f_original.jpg?aki_policy=x_medium">
        <div class="zone-prix">
            499 €/nuit
            <!-- <img src="/assets/iconeCoeur.png" alt="img icone coeur" id="imgIconeCoeurAnnonce"> -->
        </div>
        <div class="description">
            <h4>Everview Suite</h4>
        </div>
    </div>
</div>

{% endblock %}