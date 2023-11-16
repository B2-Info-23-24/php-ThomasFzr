{% extends "templates/template.php" %}


{% block head %}
<link rel="stylesheet" href="Public/assets/styles/connectionRegisterStyle.css">
{% endblock %}

{% block content %}
<div id="zone-recherche-et-filtre">
    <!-- <div id="zone-recherche">
                <input type="text" id="barre-recherche-logement-home" placeholder="Rechercher un nom de logement">
            </div> -->

    <div id="zone-filtre-container">

        <nav class="navigation">
            <ul>
                <li><a href="">Maisons</a></li>
                <li><a href="">Appartements</a></li>
                <li><a href="">Chalets</a></li>
                <li><a href="">Villas</a></li>
                <li><a href="">Péniches</a></li>
                <li><a href="">Yourtes</a></li>
                <li><a href="">Cabanes</a></li>
                <li><a href="">Igloos</a></li>
                <li><a href="">Tentes</a></li>
                <li><a href="">Cars</a></li>
            </ul>
        </nav>


        {% set isVisible = app.request.method == 'POST' and (app.request.request.get('toggleButton') is defined ? not app.request.request.get('isVisible') or app.request.request.get('isVisible') == 'false' : false) %}


        <div id="zone-filtre-rightcontainer">

            <!-- <div id="zone-filtre-rightcontainer-top"> -->
            <form method="post" action="">
                <button type="submit" name="toggleButton">FILTRES</button>
                <input type="hidden" name="isVisible" value="<?php echo $isVisible ? 'true' : 'false'; ?>">
            </form>
        </div>
        <!-- <div id="zone-filtre-rightcontainer-bottom"> -->

        <div id="filtre-deroulant" class="<?php echo $isVisible ? '' : 'hidden'; ?>">
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

            Date début: <input type="date" id="dateDebut" min="2023-11-01" onchange="updateDateFinMin()">
            <br>
            Date fin: <input type="date" id="dateFin">
            <br>
        </div>
    </div>
    <!-- </div> -->

</div>
</div>

<br><br>

<div class="zone-annonce">
    <a href="?page=detailsLogement" id="lien-annonce">
        <div class="annonce">
            <img src="https://a2.muscache.com/im/pictures/6152848/b04eddeb_original.jpg?aki_policy=x_medium">
            <div class="zone-prix">158 €/nuit</div>
            <div class="description">
                <h4>Loft Studio in the Central Area</h4>
            </div>
        </div>
    </a>

    <div class="annonce">
        <img src="https://a2.muscache.com/im/pictures/34792065/bae84a3f_original.jpg?aki_policy=x_medium">
        <div class="zone-prix">
            499 €/nuit
            <!-- <img src="/assets/iconeCoeur.png" alt="img icone coeur" id="imgIconeCoeurAnnonce"> -->
        </div>
        <div class="description">
            <h4>Everview Suite</h4>
        </div>
    </div>

    <div class="annonce">
        <img src="https://a2.muscache.com/im/pictures/1faf9a4c-f839-44da-bd37-65ddc928379e.jpg?aki_policy=x_medium">
        <div class="zone-prix">476 €/nuit</div>
        <div class="description">
            <h4>180° View, private pool villa</h4>
        </div>
    </div>

    <div class="annonce">
        <img src="https://a2.muscache.com/im/pictures/34792065/bae84a3f_original.jpg?aki_policy=x_medium">
        <div class="zone-prix">499 €/nuit</div>
        <div class="description">
            <h4>Everview Suite</h4>
        </div>
    </div>

    <div class="annonce">
        <img src="https://a2.muscache.com/im/pictures/34792065/bae84a3f_original.jpg?aki_policy=x_medium">
        <div class="zone-prix">499 €/nuit</div>
        <div class="description">
            <h4>Everview Suite</h4>
        </div>
    </div>

    <div class="annonce">
        <img src="https://a2.muscache.com/im/pictures/1faf9a4c-f839-44da-bd37-65ddc928379e.jpg?aki_policy=x_medium">
        <div class="zone-prix">476 €/nuit</div>
        <div class="description">
            <h4>180° View, private pool villa</h4>
        </div>
    </div>

    <div class="annonce">
        <img src="https://a2.muscache.com/im/pictures/34792065/bae84a3f_original.jpg?aki_policy=x_medium">
        <div class="zone-prix">499 €/nuit</div>
        <div class="description">
            <h4>Everview Suite</h4>
        </div>
    </div>

    <div class="annonce">
        <img src="https://a2.muscache.com/im/pictures/1faf9a4c-f839-44da-bd37-65ddc928379e.jpg?aki_policy=x_medium">
        <div class="zone-prix">476 €/nuit</div>
        <div class="description">
            <h4>180° View, private pool villa</h4>
        </div>
    </div>

</div>

<!-- A SUPPRIMER -->

<form id="gettable-form" action="?page=test" method="post">

    <p>
        <input type="submit" id="register" value="BTN FOR TESTS.">
    </p>
</form>
<!-- A SUPPRIMER -->

{% endblock %}