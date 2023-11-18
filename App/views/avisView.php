{% extends "templates/template.php" %}

{% block content %}
</br></br>

<h3> Mes avis: </h3>

{% if tabAnnonce is not empty %}
{% for annonceDetails in tabAnnonce %}
<a href="/detailsLogement?id={{ annonceDetails.annonceID }}" id="lien-annonce">
    <div class="annonce">
        <img src="{{ annonceDetails.image }}" id="img-annonce-home">
        <div class="zone-prix">{{ annonceDetails.price }} €/nuit</div>
        <div class="description">
            <h4>{{ annonceDetails.name }}</h4>
        </div>

        {% if tabAvis is not empty %}
        {% for avis in tabAvis %}
        {% if avis is defined and avis.annonceID is defined and avis.annonceID == annonceDetails.annonceID %}
        <div class="avis">
            {{ avis.grade }}/5 ⭐ <br>
            {{ avis.comment }}
        </div>
        {% endif %}
        {% endfor %}
        {% endif %}
    </div>
</a>
{% endfor %}
{% else %}
<p>Aucun avis laissé pour le moment.</p>
{% endif %}

{% endblock %}