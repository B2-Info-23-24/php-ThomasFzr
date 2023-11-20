{% extends "templates/template.php" %}

{% block content %}
<div id="zone-filtre-container">
    <div id="zone-filtre-container-top">
        <div class="search">
            <input type="text" class="search__input" placeholder="Rechercher une ville">
            <button class="search__button">
                <svg class="search__icon" aria-hidden="true" viewBox="0 0 24 24">
                    <g>
                        <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                    </g>
                </svg>
            </button>
        </div>
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
            <input type="hidden" name="typeLogement" value="{{ _GET['typeLogement'] ?? '' }}">


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
            </nav>

            <button type="submit" class="btn-submit-filtre">APPLIQUER FILTRES</button>
        </form>

        <div class="card">
            <div class="price-content">
                <div>
                    <label>Min</label>
                    <p id="min-value">50</p>
                </div>

                <div>
                    <label>Max</label>
                    <p id="max-value">500</p>
                </div>
            </div>
            <div class="range-slider">
                <div class="range-fill"></div>
                <input class="input-slider" type="range" class="min-price" value="100" min="10" max="500" step="10" />
                <input class="input-slider" type="range" class="max-price" value="250" min="10" max="500" step="10" />
            </div>
        </div>
    </div>
</div>

<br><br>

<div class="zone-annonce">
    {% for annonce in annonces %}
    <a href="/detailsLogement/{{ annonce.annonceID }}" id="lien-annonce">
        <div class="annonce">
            <img src="{{annonce.image}}" id="img-annonce-home">
            <div class="zone-prix">{{annonce.price}} €/nuit</div>
            <div class="description">
                <h4>{{annonce.name}}</h4>
            </div>
        </div>
    </a>
    {% endfor %}
</div>

<!-- A SUPPRIMER -->
<form id="gettable-form" action="/test" method="post">
    <p>
        <input type="submit" id="register" value="BTN FOR TESTS.">
    </p>
</form>
<!-- A SUPPRIMER -->
{% endblock %}

{% block footer %}
<script src="script.js"></script>
<script>
    document.getElementById('toggleFiltresButton').addEventListener('click', function() {
        var filtreDeroulant = document.getElementById('filtre-deroulant');
        filtreDeroulant.classList.toggle('visible');
        filtreDeroulant.classList.toggle('hidden');
    });
</script>
{% endblock %}