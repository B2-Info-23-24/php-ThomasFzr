{% extends "templates/template.php" %}

{% block content %}
</br></br>

<div class="flex-container-details-logement">

    <div class="flex-child-details-logement left">
        {% for info in infoAnnonce %}
        <img src="{{info.image}}" id="img-details-annonce">
        <br>
        {{info.name}}

        <br><br> Description du logement: <br><br>
        - Le prix d’une nuitée:
        {{info.price}} € <br>

        Adresse: {{info.adresse}}



        <br>
        - Les commentaires laissés par les locataires <br>
        - Les notes laissées par les locataires <br>
        - Les disponibilités de réservation
    </div>

    <div class="flex-child-details-logement right">
        <div id="nombre-etoile-commentaire-logement">
            <a href="#"> ⭐⭐⭐⭐⭐ 5,0 </a> <br>
            <a href="#"> 33 commentaires</a>
        </div> <br>
        Date de début: <input type="date"> <br>
        Date de fin: <input type="date"> <br><br>

        

        {% if isInFavorite %}
        <form action="/process_favorite?action=remove&id={{ info.annonceID }}" method="post">
            <input type="submit" value="RETIRER DES FAVORIS"><br><br>
        </form>
        {% else %}
        <form action="/process_favorite?action=add&id={{ info.annonceID }}" method="post">
            <input type="submit" value="AJOUTER EN FAVORIS"><br><br>
        </form>
        {% endif %}
        <input type="submit" value="RESERVER">
    </div>
</div>
{% endfor %}
{% endblock %}