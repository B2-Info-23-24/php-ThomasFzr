{% extends "templates/template.php" %}

{% block content %}
</br></br>

<h3> Réservations en cours: </h3>

<div class="zone-annonce">
    {% for accomodation in accomodationReservation %}
    {% if accomodation.endDate >= dateToday %}
    <a href="/accomodation/{{ accomodation.accomodationID }}" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/{{accomodation.image}}" id="img-annonce-home" alt="image-{{ accomodation.image }}">
            <div class="zone-prix">{{accomodation.price}} €/nuit</div>
            <div class="description">
                <h4>{{accomodation.title}}</h4>
                Réservation du {{accomodation.startDate|date("d/m/Y")}} au {{accomodation.endDate|date("d/m/Y")}}
                <br> Prix total : {{accomodation.totalPrice}} €
            </div>
        </div>
    </a>
    {% endif%}
    {% endfor %}
</div><br><br>

<h3> Réservations passées: </h3>

<div class="zone-annonce">
    {% for accomodation in accomodationReservation %}
    {% if accomodation.endDate < dateToday %}
    <a href="/detailsLogement/{{ accomodation.accomodationID }}" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/{{accomodation.image}}" id="img-annonce-home" alt="image-{{ accomodation.image }}">
            <div class="zone-prix">{{accomodation.price}} €/nuit</div>
            <div class="description">
                <h4>{{accomodation.name}}</h4>
                Réservation du {{accomodation.startDate|date("d/m/Y")}} au {{accomodation.endDate|date("d/m/Y")}}.
            </div>
        </div>
    </a>
    {% endif%}
    {% endfor %}
</div>

{% endblock %}