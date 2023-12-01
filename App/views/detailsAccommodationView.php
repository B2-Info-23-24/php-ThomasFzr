{% extends "templates/template.php" %}

{% block content %}
</br></br>

<div class="flex-container-details-logement">

    <div class="flex-child-details-logement left">
        {% for info in infoAccommodation %}
        <img src="Public/assets/images/{{ info.image }}" id="img-details-annonce" alt="image-{{ info.image }}">
        {% if isAdmin %}
        <form action="/processAccommodation?action=modifyAccommodation&id={{info.accommodationID}}" method="post">
            Modifier l'image: <select name="image" required>
                <option disabled>Actuel : {{ info.image }}</option>
                {% for image in allImages%}
                <option value="{{image.name}}">{{image.name}}</option>
                {% endfor %}
            </select>
            <input type="image" src="Public/assets/images/iconeStyloBleu.png" alt="iconeStyloBleu" id="icone-poubelle-rouge">
        </form>
        {% endif%}

        <br>
        <h3>{{ info.title }} ({{info.price}}€/nuit)</h3>
        {% if isAdmin %}
        <form action="/processAccommodation?action=modifyAccommodation&id={{info.accommodationID}}" method="post">
            Titre: <input type="text" value="{{info.title}}" name="title" required>
            <input type="image" src="Public/assets/images/iconeStyloBleu.png" alt="iconeStyloBleu" id="icone-poubelle-rouge">
        </form><br>
        <form action="/processAccommodation?action=modifyAccommodation&id={{info.accommodationID}}" method="post">
            Prix: <input type="number" value="{{info.price}}" name="price" min="0" required> €/nuit
            <input type="image" src="Public/assets/images/iconeStyloBleu.png" alt="iconeStyloBleu" id="icone-poubelle-rouge">
        </form><br>
        {% endif%}


        <div class="description-annonce">

            {% if isAdmin %}

            <form action="/processAccommodation?action=modifyAccommodation&id={{info.accommodationID}}" method="post">
                Type de logement : <select name="accoType" required>
                    <option disabled>Actuel : {{ info.accommodationType }}</option>
                    {% for accommodationType in allAccommodationTypes%}
                    <option value="{{accommodationType.name}}">{{accommodationType.name}}</option>
                    {% endfor %}
                </select>
                <input type="image" src="Public/assets/images/iconeStyloBleu.png" alt="iconeStyloBleu" id="icone-poubelle-rouge">
            </form><br>
            <form action="/processAccommodation?action=modifyAccommodation&id={{info.accommodationID}}" method="post">
                Ville: <select name="city" required>
                <option disabled>Actuel : {{ info.city }}</option>
                {% for city in allCities%}
                <option value="{{city.name}}">{{city.name}}</option>
                {% endfor %}
            </select>
                <input type="image" src="Public/assets/images/iconeStyloBleu.png" alt="iconeStyloBleu" id="icone-poubelle-rouge">
            </form><br>
            {%else%}
            Type de logement : {{ info.accommodationType }}<br><br>
            Ville: {{ info.city }}<br><br>
            {% endif%}
            {% endfor %}

            Equipements disponibles:
            {% if equipments is not empty %}
            <ul>
                {% for equipment in equipments %}
                <li> {{equipment.name}}
                    {% if isAdmin %}
                    {% for info in infoAccommodation %}
                    <a href="/processAccommodation?action=deleteEquipment&id={{info.accommodationID}}&equipmentID={{equipment.equipmentID}}">
                        <img src="Public/assets/images/iconePoubelleRouge.png" alt="iconePoubelleRouge" id="icone-poubelle-rouge">
                    </a>
                    {% endfor%}
                    {% endif%}
                </li>
                {% endfor%}
            </ul>
            {% else %}
            <br><br>Aucun équipement disponible. <br><br>
            {% endif%}

            {% if isAdmin %}
            {% for info in infoAccommodation %}
            <form action="/processAccommodation?action=addEquipment&id={{info.accommodationID}}" method="post">
                {% endfor %}
                <select name="equipmentID" required>
                    <option disabled> Choisir un équipement</option>
                    {% for equipment in allEquipments%}
                    <option value="{{equipment.equipmentID}}">{{equipment.name}}</option>
                    {%endfor%}
                </select>
                <input type="submit" value="Ajouter">
            </form><br>
            {% endif %}

            Services disponibles:
            {% if services is not empty %}
            <ul>
                {% for service in services %}
                <li> {{service.name}}
                    {% if isAdmin %}
                    {% for info in infoAccommodation %}
                    <a href="/processAccommodation?action=deleteService&id={{info.accommodationID}}&serviceID={{service.serviceID}}">
                        <img src="Public/assets/images/iconePoubelleRouge.png" alt="iconePoubelleRouge" id="icone-poubelle-rouge">
                    </a>
                    {% endfor%}
                    {% endif%}
                </li>
                {% endfor%}
            </ul>
            {% else %}
            <br><br>Aucun service disponible.<br>
            {% endif%}

            {% if isAdmin %}
            {% for info in infoAccommodation %}
            <form action="/processAccommodation?action=addService&id={{ info.accommodationID }}" method="post">
                {% endfor%}
                <select name="serviceID" required>
                    <option disabled> Choisir un service</option>
                    {% for service in allServices %}
                    <option value="{{service.serviceID}}">{{service.name}}</option>
                    {%endfor%}
                </select>
                <input type="submit" value="Ajouter">
            </form><br>
            {% endif %}
        </div>
        <br>

        <div id="nombre-etoile-commentaire-logement">
            {{ tabReview|length == 0 ? 'Pas encore de note' : averageGrade }} ⭐ -
            ({{ tabReview|length }} commentaire{{ tabReview|length <= 1 ? '' : 's' }})
        </div><br>



        {% if userID is not null %}
        {% for info in infoAccommodation %}
        <div id="zone-laisser-avis">
            <form action="/addUniqueReview?id={{info.accommodationID}}" method="post">
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

    {% for info in infoAccommodation %}
    <div class="flex-child-details-logement right">

        {% if userID is not null %}
        {% if isInFavorite %}
        <form action="/processFavorite?action=remove&id={{ info.accommodationID }}" method="post">
            <input type="submit" value="RETIRER DES FAVORIS 💔"><br><br>
        </form>
        {% else %}
        <form action="/processFavorite?action=add&id={{ info.accommodationID }}" method="post">
            <input type="submit" value="AJOUTER EN FAVORIS 🩷"><br><br>
        </form>
        {% endif %}
        {% else %}
        Veuillez vous connecter pour ajouter ce logement en favoris.
        {% endif %}<br><br>

        {% if userID is not null %}
        {{ info.price }} € x <span id="differenceInDays"> 1</span><br><br>

        <form action="/processReservation?id={{info.accommodationID}}" method="post">
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
        {% for info in infoAccommodation %}
        <a href="/processAccommodation?action=deleteAccommodation&id={{ info.accommodationID }}">
            <img src="Public/assets/images/iconePoubelleRouge.png" alt="iconePoubelleRouge" id="icone-poubelle-rouge">
            Supprimer l'annonce
        </a>
        {% endfor %}
        {% endif %}
    </div>
</div>
{% endblock %}

{% block footer %}
<script src="updateDate.js"></script>
{% endblock %}