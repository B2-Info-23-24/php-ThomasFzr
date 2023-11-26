{% extends "templates/template.php" %}

{% block content %}
</br></br>

<h3> Mes avis: </h3>

{% if tabAvisAnnonces is not empty %}
<div class="zone-annonce">
    {% for tabAvisAnnonce in tabAvisAnnonces %}
    <a href="/detailsLogement/{{ tabAvisAnnonce.annonceID }}" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/{{tabAvisAnnonce.image}}" id="img-annonce-home" alt="image-{{ tabAvisAnnonce.image }}">
            <div class="zone-prix">{{ tabAvisAnnonce.price }} €/nuit</div>
            <div class="description">
                <h4>{{ tabAvisAnnonce.title }}</h4>
            </div>

            <div class="avis">
                {{ tabAvisAnnonce.grade }}/5 ⭐ <br>
                {{ tabAvisAnnonce.comment }} <br>
                {{ tabAvisAnnonce.date |date("d/m/Y") }}
            </div>
        </div>
    </a>
    {% endfor %}
</div>
{% else %}
<p>Aucun avis laissé pour le moment.</p>
{% endif %}

{% endblock %}