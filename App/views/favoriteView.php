{% extends "templates/template.php" %}

{% block content %}
</br></br>

<h3> Mes logements favoris: </h3>

<div class="zone-annonce">
    {% for annonce in annonces %}
    <a href="/detailsLogement?id={{ annonce.annonceID }}" id="lien-annonce">
        <div class="annonce">
            <img src="https://a2.muscache.com/im/pictures/6152848/b04eddeb_original.jpg?aki_policy=x_medium">
            <div class="zone-prix">{{annonce.price}} €/nuit</div>
            <div class="description">
                <h4>{{annonce.name}}</h4>
            </div>
        </div>
    </a>
    {% endfor %}
</div>
{% endblock %}