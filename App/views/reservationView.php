{% extends "templates/template.php" %}

{% block content %}
</br></br>

<h3> Réservations en cours: </h3>

<div class="zone-annonce">
    {% for accommodation in accommodationReservation %}
    {% if accommodation.endDate >= dateToday %}
    <a href="/accommodation/{{ accommodation.accommodationID }}" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/{{accommodation.image}}" id="img-annonce-home" alt="image-{{ accommodation.image }}">
            <div class="zone-prix">{{accommodation.price}} €/nuit</div>
            <div class="description">
                <h4>{{accommodation.title}}</h4>
                Réservation du {{accommodation.startDate|date("d/m/Y")}} au {{accommodation.endDate|date("d/m/Y")}}
                <br> Prix total : {{accommodation.totalPrice}} €
            </div>
        </div>
    </a>
    {% endif%}
    {% endfor %}
</div><br><br>

<h3> Réservations passées: </h3>

<div class="zone-annonce">
    {% for accommodation in accommodationReservation %}
    {% if accommodation.endDate < dateToday %}
    <a href="/accommodation/{{ accommodation.accommodationID }}" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/{{accommodation.image}}" id="img-annonce-home" alt="image-{{ accommodation.image }}">
            <div class="zone-prix">{{accommodation.price}} €/nuit</div>
            <div class="description">
                <h4>{{accommodation.name}}</h4>
                Réservation du {{accommodation.startDate|date("d/m/Y")}} au {{accommodation.endDate|date("d/m/Y")}}
                <br> Prix total : {{accommodation.totalPrice}} €
            </div>
        </div>
    </a>
    {% endif%}
    {% endfor %}
</div>

{% endblock %}