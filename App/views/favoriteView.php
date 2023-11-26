{% extends "templates/template.php" %}

{% block content %}
</br></br>

<h3> Mes logements favoris: </h3>


{% if annonces is not empty %}
<div class="zone-annonce">
    {% for annonce in annonces %}
    <a href="/detailsLogement/{{ annonce.annonceID }}" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/{{annonce.image}}" id="img-annonce-home" alt="image-{{ annonce.image }}">
            <div class="zone-prix">{{annonce.price}} €/nuit</div>
            <div class="description">
                <h4>{{annonce.name}}</h4>
            </div>
        </div>
    </a>
    {% endfor %}
</div>

{% else %}
<p>Aucun logement ajouté en favoris pour le moment.</p>
{% endif %}

{% endblock %}