{% extends "templates/template.php" %}

{% block content %}
</br></br>

<h3> Réservations en cours: </h3>

<div class="zone-annonce">
    {% for annonce in annoncesReservations %}
    {% if annonce.dateFin >= dateToday %}
    <a href="/detailsLogement/{{ annonce.annonceID }}" id="lien-annonce">
        <div class="annonce">
            <img src="{{ annonce.image }}" id="img-annonce-home">
            <div class="zone-prix">{{annonce.price}} €/nuit</div>
            <div class="description">
                <h4>{{annonce.name}}</h4>
                Réservation du {{annonce.dateDebut|date("d/m/Y")}} au {{annonce.dateFin|date("d/m/Y")}}.
            </div>
        </div>
    </a>
    {% endif%}
    {% endfor %}
</div><br><br>

<h3> Réservations passées: </h3>

<div class="zone-annonce">
    {% for annonce in annoncesReservations %}
    {% if annonce.dateFin < dateToday %}
    <a href="/detailsLogement/{{ annonce.annonceID }}" id="lien-annonce">
        <div class="annonce">
            <img src="{{ annonce.image }}" id="img-annonce-home">
            <div class="zone-prix">{{annonce.price}} €/nuit</div>
            <div class="description">
                <h4>{{annonce.name}}</h4>
                Réservation du {{annonce.dateDebut|date("d/m/Y")}} au {{annonce.dateFin|date("d/m/Y")}}.
            </div>
        </div>
    </a>
    {% endif%}
    {% endfor %}
</div>

{% endblock %}