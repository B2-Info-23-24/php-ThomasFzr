{% extends "templates/template.php" %}

{% block content %}
</br></br>

<div class="flex-container-details-logement">

    <div class="flex-child-details-logement left">
        {% for info in infoAnnonce %}
        <img src="{{ info.image }}" id="img-details-annonce">
        <br>
        <h3>{{ info.name }}</h3>
        Ville: {{ info.ville }}<br><br>
        <div id="nombre-etoile-commentaire-logement">
            {{ tabAvis|length == 0 ? 'Pas encore de note' : averageGrade }} ⭐ -
            ({{ tabAvis|length }} commentaire{{ tabAvis|length <= 1 ? '' : 's' }})
        </div>

        <div id="zone-laisser-avis">
            <form action="/process_avis?id={{info.annonceID}}" method="post">
                <input type="number" name="grade" placeholder="Note" required min="0" max="5">
                <input type="text" name="comment" placeholder="Laisser un commentaire" required>
                <input type="submit" value="ENVOYER L'AVIS">
            </form>
        </div>
        {% endfor %}

        <br>
        <ul>
            {% for avis in tabAvis %}

            <div id="details-commentaires-notes">
                <li>{{ avis.grade }}⭐
                    ({{ avis.date }}) <br>
                    {{ avis.comment }}
                </li>
            </div> <br>
            {% endfor %}
        </ul>
    </div>

    {% for info in infoAnnonce %}
    <div class="flex-child-details-logement right">
        {% if isInFavorite %}
        <form action="/process_favorite?action=remove&id={{ info.annonceID }}" method="post">
            <input type="submit" value="RETIRER DES FAVORIS 💔"><br><br>
        </form>
        {% else %}
        <form action="/process_favorite?action=add&id={{ info.annonceID }}" method="post">
            <input type="submit" value="AJOUTER EN FAVORIS 🩷"><br><br>
        </form>
        {% endif %}


        Disponibilités de réservation: <br>
        Du: <input type="date"> <br>
        au: <input type="date"><br>
        {{ info.dateDispo }}<br><br>

        {{ info.price }} € x ? nuit<br><br>

        <form action="/process_reservation?id={{info.annonceID}}" method="post">
            Date de début: <input type="date" name="dateDebut" required> <br>
            Date de fin: <input type="date" name="dateFin" required> <br><br>
            <input type="submit" value="RESERVER">
        </form>
        {% endfor %}
    </div>
</div>
{% endblock %}