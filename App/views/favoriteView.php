{% extends "templates/template.php" %}

{% block content %}
</br></br>

<h3> Mes logements favoris: </h3>


{% if accomodations is not empty %}
<div class="zone-annonce">
    {% for accomodation in accomodations %}
    <a href="/accomodation/{{ accomodation.accomodationID }}" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/{{accomodation.image}}" id="img-annonce-home" alt="image-{{ accomodation.image }}">
            <div class="zone-prix">{{accomodation.price}} €/nuit</div>
            <div class="description">
                <h4>{{accomodation.title}}</h4>
            </div>
        </div>
    </a>
    {% endfor %}
</div>

{% else %}
<p>Aucun logement ajouté en favoris pour le moment.</p>
{% endif %}

{% endblock %}