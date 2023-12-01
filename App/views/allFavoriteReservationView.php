{% extends "templates/template.php" %}

{% block content %}

<div class="flex-container-favoReser">

    <div class="flex-child-favoReser left">
        <h3> Tous les favoris: </h3>
        {% if favorites is not empty %}
        <div class="zone-annonce">
            {% for favorite in favorites %}
            <a href="/accomodation/{{ favorite.accomodationID }}" id="lien-annonce">
                <div class="annonce">
                    <img src="Public/assets/images/{{favorite.image}}" id="img-annonce-home" alt="image-{{ favorite.image }}">
                    <div class="zone-prix">{{favorite.price}} €/nuit</div>
                    <div class="description">
                        <h4>{{favorite.title}}</h4>
                        Mis en favoris par: {{favorite.surname }}, Id: {{favorite.userID}}
                    </div>
                </div>
            </a>
            <!-- <div id="details-commentaires-notes">
                <a href="/processReview?action=delete&id={{review.reviewID}}">
                    <img src="Public/assets/images/iconePoubelleRouge.png" alt="iconePoubelleRouge" id="icone-poubelle-rouge">
                </a>
            </div> -->
            {% endfor %}
        </div>

        {% else %}
        <p>Aucun logement ajouté en favoris pour le moment.</p>
        {% endif %}

    </div>

    <div class="flex-child-favoReser right">
        <h3> Toutes les réservations: </h3>
        {% for reservation in reservations %}
        {% if accomodation.endDate >= dateToday %}
        <a href="/accomodation/{{ reservation.accomodationID }}" id="lien-annonce">
            <div class="annonce">
                <img src="Public/assets/images/{{reservation.image}}" id="img-annonce-home" alt="image-{{ reservation.image }}">
                <div class="zone-prix">{{reservation.price}} €/nuit</div>
                <div class="description">
                    <h4>{{reservation.title}}</h4>
                    Réservé par: {{reservation.surname }}, Id: {{reservation.userID}}
                    <br> Réservation du {{reservation.startDate|date("d/m/Y")}} au {{reservation.endDate|date("d/m/Y")}}
                    <br> Prix total : {{reservation.totalPrice}} €
                </div>
            </div>
        </a>
        {% endif%}
        {% endfor %}
    </div>
</div>







{% endblock %}