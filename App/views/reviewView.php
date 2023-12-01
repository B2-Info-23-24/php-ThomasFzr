{% extends "templates/template.php" %}

{% block content %}
</br></br>

<h3> Mes avis: </h3>

{% if tabReviewAccommodations is not empty %}
<div class="zone-annonce">
    {% for tabReviewAccommodation in tabReviewAccommodations %}
    <a href="/accommodation/{{ tabReviewAccommodation.accommodationID }}" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/{{tabReviewAccommodation.image}}" id="img-annonce-home" alt="image-{{ tabReviewAccommodation.image }}">
            <div class="zone-prix">{{ tabReviewAccommodation.price }} €/nuit</div>
            <div class="description">
                <h4>{{ tabReviewAccommodation.title }}</h4>
            </div>

            <div class="avis">
                {{ tabReviewAccommodation.grade }}/5 ⭐ <br>
                {{ tabReviewAccommodation.comment }} <br>
                {{ tabReviewAccommodation.date |date("d/m/Y") }}
            </div>
        </div>
    </a>
    {% endfor %}
</div>
{% else %}
<p>Aucun avis laissé pour le moment.</p>
{% endif %}

{% endblock %}