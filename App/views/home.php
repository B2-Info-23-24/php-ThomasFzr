{% extends "templates/template.php" %}

{% block content %}
<div id="zone-filtre-container">

    <div id="zone-filtre-container-top">
        {% if isAdmin%}
        <form action="/" method="GET" class="search-form">
            <div class="search">
                <input type="text" class="search__input" name="accommodationTitle" placeholder="Nom de logement">
                <button type="submit" class="search__button">
                    <svg class="search__icon" aria-hidden="true" viewBox="0 0 24 24">
                        <g>
                            <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                        </g>
                    </svg>
                </button>
            </div>
        </form>
        {%endif%}
        <nav class="navigation">
            <ul>
                <li><a href="/">Tout</a></li>
                {% for accommodationType in accommodationTypes %}
                <li><a href="/?accommodationType={{ accommodationType.name }}">{{ accommodationType.name }}</a></li>
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
            <input type="hidden" name="accommodationType" value="{{ accommodationType }}">

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
                    {% for equipment in equipments %}
                    <li>
                        <label>
                            {{ equipment.name }}
                            <input type="checkbox" name="selectedEquipments[]" value="{{ equipment.equipmentID }}">
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
    {% if isAdmin %}
    <a href="/addAccommodation" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/iconePlusBlanc.png" id="img-btn-add-accommodation">
            <div class="zone-prix"> </div><br>
            <div class="description">
                <h4>AJOUTER UNE ANNONCE</h4>
            </div>
        </div>
    </a>
    {% endif %}
    {% if accommodations is not empty %}
    {% for accommodation in accommodations %}
    <a href="/accommodation/{{ accommodation.accommodationID }}" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/{{accommodation.image}}" id="img-annonce-home" alt="image-{{ info.image }}">
            <div class="zone-prix">{{accommodation.price}} €/nuit</div>
            <div class="description">
                <h4>{{accommodation.title}}</h4>
            </div>
        </div>
    </a>
    {% endfor %}
    {% else %}
    Aucune annonce ne répondant à vos filtres.
    {% endif%}
</div>



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