{% extends "templates/template.php" %}

{% block content %}
<h3> Tous les avis: </h3>


<div class="zone-annonce">
    {% for review in reviews %}
    <a href="/detailsLogement/{{ review.annonceID }}" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/{{review.image}}" id="img-annonce-home" alt="image-{{ review.image }}">
            <div class="zone-prix">{{ review.price }} €/nuit</div>
            <div class="description">
                <h4>{{ review.title }}</h4>
            </div>

            <div id="details-commentaires-notes">
                <li>{{ review.grade }}⭐ -

                    {% if review.surname !='' %}
                    {{ review.surname }} {{ review.name }}
                    {%else%}
                    Anonyme
                    {%endif%}

                    ({{ review.date|date("d/m/Y") }})
                    <br>
                    {{ review.comment }}
                </li>
            </div> 
        </div>
    </a>
    {% endfor %}
</div>

{% endblock %}