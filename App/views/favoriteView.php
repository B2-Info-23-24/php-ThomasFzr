{% extends "templates/template.php" %}

{% block content %}
</br></br>

<h3> Mes logements favoris: </h3>


{% if accommodations is not empty %}
<div class="zone-annonce">
    {% for accommodation in accommodations %}
    <a href="/accommodation/{{ accommodation.accommodationID }}" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/{{accommodation.image}}" id="img-annonce-home" alt="image-{{ accommodation.image }}">
            <div class="zone-prix">{{accommodation.price}} €/nuit</div>
            <div class="description">
                <h4>{{accommodation.title}}</h4>
            </div>
        </div>
    </a>
    {% endfor %}
</div>

{% else %}
<p>Aucun logement ajouté en favoris pour le moment.</p>
{% endif %}

{% endblock %}