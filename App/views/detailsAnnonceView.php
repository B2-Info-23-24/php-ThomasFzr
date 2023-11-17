{% extends "templates/template.php" %}

{% block content %}
</br></br>

<div class="flex-container-details-logement">

    <div class="flex-child-details-logement left">
        <img src="https://a2.muscache.com/im/pictures/6152848/b04eddeb_original.jpg?aki_policy=x_medium"> <br>
        {% for info in infoAnnonce %}
        {{info.name}}
        {% endfor %}
        <br><br> Description du logement: <br><br>
        - Le prix d’une nuitée: {% for info in infoAnnonce %}
        {{info.price}}
        {% endfor %} <br>
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
        
        <input type="submit" value="AJOUTER EN FAVORIS"><br><br>
        <input type="submit" value="RESERVER"> 
        
    </div>

</div>
{% endblock %}