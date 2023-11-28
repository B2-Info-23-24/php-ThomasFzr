{% extends "templates/template.php" %}

{% block content %}
</br></br>

<h3> Mes avis: </h3>

{% if tabReviewAccomodations is not empty %}
<div class="zone-annonce">
    {% for tabReviewAccomodation in tabReviewAccomodations %}
    <a href="/accomodation/{{ tabReviewAccomodation.accomodationID }}" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/{{tabReviewAccomodation.image}}" id="img-annonce-home" alt="image-{{ tabReviewAccomodation.image }}">
            <div class="zone-prix">{{ tabReviewAccomodation.price }} €/nuit</div>
            <div class="description">
                <h4>{{ tabReviewAccomodation.title }}</h4>
            </div>

            <div class="avis">
                {{ tabReviewAccomodation.grade }}/5 ⭐ <br>
                {{ tabReviewAccomodation.comment }} <br>
                {{ tabReviewAccomodation.date |date("d/m/Y") }}
            </div>
        </div>
    </a>
    {% endfor %}
</div>
{% else %}
<p>Aucun avis laissé pour le moment.</p>
{% endif %}

{% endblock %}