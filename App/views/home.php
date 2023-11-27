{% extends "templates/template.php" %}

{% block content %}
<div id="zone-filtre-container">

    <div id="zone-filtre-container-top">
        <nav class="navigation">
            <ul>
                <li><a href="/">Tout</a></li>
                {% for typeLogement in typeLogements %}
                <li><a href="/?typeLogement={{ typeLogement.name }}">{{ typeLogement.name }}</a></li>
                {% endfor %}
            </ul>
        </nav>
        <div id="zone-filtre-rightcontainer">
            <form method="post" action="">
                <button type="button" id="toggleFiltresButton" class="button--submit">FILTRES</button>
                <input type="hidden" name="isVisible" value="{{ isVisible ? 'true' : 'false' }}">
            </form>
        </div>
    </div>

    <div id="filtre-deroulant" class="hidden">
        <form method="get" action="/">
            <input type="hidden" name="typeLogement" value="{{ typeLogement }}">

            Services:
            <nav class="navigation">
                <ul>
                    {% for service in services %}
                    <li>
                        <label>
                            {{ service.name }}
                            <input type="checkbox" name="selectedServices[]" value="{{ service.serviceID }}">
                        </label>
                    </li>
                    {% endfor %}
                </ul>
            </nav> <br><br>

            Equipements:
            <nav class="navigation">
                <ul>
                    {% for equipement in equipements %}
                    <li>
                        <label>
                            {{ equipement.name }}
                            <input type="checkbox" name="selectedEquipements[]" value="{{ equipement.equipementID }}">
                        </label>
                    </li>
                    {% endfor %}
                </ul>
            </nav> <br><br>

            De <input type="number" name="min-price" min="0" placeholder="EUR">
            à <input type="number" name="max-price" placeholder="EUR"> <br><br>

            <div class="search">
                <input type="text" class="search__input" name="city" placeholder="Rechercher une ville">
            </div><br><br>

            <button type="submit" class="btn-submit-filtre">APPLIQUER FILTRES</button>
        </form>
    </div>

</div>

<br><br>

<div class="zone-annonce">
    {% if annonces is not empty %}
    {% for annonce in annonces %}
    <a href="/detailsLogement/{{ annonce.annonceID }}" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/{{annonce.image}}" id="img-annonce-home" alt="image-{{ info.image }}">
            <div class="zone-prix">{{annonce.price}} €/nuit</div>
            <div class="description">
                <h4>{{annonce.title}}</h4>
            </div>
        </div>
    </a>
    {% endfor %}
    {% else %}
    Aucune annonce ne répondant à vos filtres.
    {% endif%}
</div>

{% if isAdmin %}
<div class="zone-annonce">
    <a href="/addAnnonce" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/iconePlusBlanc.png" id="img-annonce-home">
            <div class="description">
                <h4>AJOUTER UNE ANNONCE</h4>
            </div>
        </div>
    </a>
</div>
{% endif %}

<!-- A SUPPRIMER -->
<form id="gettable-form" action="/test" method="post">
    <p>
        <input type="submit" id="test" value="BTN FOR TESTS.">
    </p>
</form>
<!-- A SUPPRIMER -->
{% endblock %}

{% block footer %}
<script>
    document.getElementById('toggleFiltresButton').addEventListener('click', function() {
        var filtreDeroulant = document.getElementById('filtre-deroulant');
        filtreDeroulant.classList.toggle('visible');
        filtreDeroulant.classList.toggle('hidden');
    });
</script>
{% endblock %}