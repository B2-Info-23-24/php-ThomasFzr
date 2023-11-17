{% extends "templates/template.php" %}

{% block content %}
<div id="zone-recherche-et-filtre">
    <!-- <div id="zone-recherche">
                <input type="text" id="barre-recherche-logement-home" placeholder="Rechercher un nom de logement">
            </div> -->

    <div id="zone-filtre-container">



        <nav class="navigation">
            <ul>
                {% for typeLogement in typeLogements%}
                <li><a href="">{{typeLogement.name}}</a></li>
                {% endfor %}
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

        <div id="filtre-deroulant" class="hidden">
            <?php // echo $isVisible ? '' : 'hidden'; 
            ?>
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
</div>

<br><br>

<div class="zone-annonce">

    {% for annonce in annonces %}

    <a href="?page=detailsLogement&annonceID={{ annonce.annonceID }}" id="lien-annonce">
        <div class="annonce">
            <img src="https://a2.muscache.com/im/pictures/6152848/b04eddeb_original.jpg?aki_policy=x_medium">
            <div class="zone-prix">{{annonce.price}} €/nuit</div>
            <div class="description">
                <h4>{{annonce.name}}</h4>
            </div>
        </div>
    </a>

    {% endfor %}

</div>

<!-- A SUPPRIMER -->

<form id="gettable-form" action="?page=test" method="post">

    <p>
        <input type="submit" id="register" value="BTN FOR TESTS.">
    </p>
</form>
<!-- A SUPPRIMER -->

{% endblock %}