{% extends "templates/template.php" %}

{% block content %}
</br></br>

<div class="flex-container-details-logement">

    <div class="flex-child-details-logement left">
        {% for info in infoAccomodation %}
        <img src="Public/assets/images/{{ info.image }}" id="img-details-annonce" alt="image-{{ info.image }}">
        <br>
        <h3>{{ info.title }} ({{info.price}}€/nuit)</h3>
        <div class="description-annonce">
            Type de logement : {{ info.accomodationType }}<br><br>
            Ville: {{ info.city }}<br><br>
            {% endfor %}

            Equipements disponibles:
            {% if equipments is not empty %}
            <ul>
                {% for equipment in equipments %}
                <li> {{equipment.name}}</li>
                {% endfor%}
            </ul>
            {% else %}
            <br><br>Aucun équipement disponible. <br><br>
            {% endif%}


            Services disponibles:
            {% if services is not empty %}
            <ul>
                {% for service in services %}
                <li> {{service.name}}</li>
                {% endfor%}
            </ul>
            {% else %}
            <br><br>Aucun service disponible.<br>
            {% endif%}
        </div>
        <br>

        <div id="nombre-etoile-commentaire-logement">
            {{ tabReview|length == 0 ? 'Pas encore de note' : averageGrade }} ⭐ -
            ({{ tabReview|length }} commentaire{{ tabReview|length <= 1 ? '' : 's' }})
        </div><br>



        {% if userID is not null %}
        {% for info in infoAccomodation %}
        <div id="zone-laisser-avis">
            <form action="/addUniqueReview?id={{info.accomodationID}}" method="post">
                <input type="number" name="grade" placeholder="Note" required min="0" max="5">
                <input type="text" name="comment" placeholder="Laisser un commentaire" required>
                <input type="submit" value="ENVOYER L'AVIS">
            </form>
        </div>
        {%endfor%}
        {%else%}
        Veuillez vous connecter pour laisser un avis sur ce logement.
        {%endif%}


        <br>
        <ul>
            {% for avis in tabReview %}

            <div id="details-commentaires-notes">
                <li>{{ avis.grade }}⭐ -

                    {% if avis.surname !='' %}
                    {{ avis.surname }} {{ avis.name }}
                    {%else%}
                    Anonyme
                    {%endif%}

                    ({{ avis.date|date("d/m/Y") }})
                    <br>
                    {{ avis.comment }}
                </li>
            </div> <br>
            {% endfor %}
        </ul>
    </div>

    {% for info in infoAccomodation %}
    <div class="flex-child-details-logement right">

        {% if userID is not null %}
        {% if isInFavorite %}
        <form action="/processFavorite?action=remove&id={{ info.accomodationID }}" method="post">
            <input type="submit" value="RETIRER DES FAVORIS 💔"><br><br>
        </form>
        {% else %}
        <form action="/processFavorite?action=add&id={{ info.accomodationID }}" method="post">
            <input type="submit" value="AJOUTER EN FAVORIS 🩷"><br><br>
        </form>
        {% endif %}
        {% else %}
        Veuillez vous connecter pour ajouter ce logement en favoris.
        {% endif %}<br><br>

        {% if userID is not null %}
        {{ info.price }} € x <span id="differenceInDays"> 1</span><br><br>

        <form action="/processReservation?id={{info.accomodationID}}" method="post">
            Date de début: <input type="date" name="startDate" id="startDate" required> <br>
            Date de fin: <input type="date" name="endDate" id="endDate" required> <br><br>
            <input type="hidden" name="price" value="{{ info.price }}">
            <input type="submit" value="RESERVER">
        </form>
        {% else %}
        Veuillez vous connecter pour réserver ce logement.

        {% endif %}
        {% endfor %}

        {% if isAdmin %}
        <br><br>
        {% for info in infoAccomodation %}
        <a href="/processAccomodation?action=delete&id={{ info.accomodationID }}">
            <img src="Public/assets/images/iconePoubelleRouge.png" alt="iconePoubelleRouge" id="icone-poubelle-rouge">
        </a>
        {% endfor %}
        {% endif %}
    </div>
</div>
{% endblock %}

{% block footer %}
<script src="updateDate.js"></script>
{% endblock %}