<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Troc mon toit </title>
</head>

<body>

    <div id="container-allheader">
        <div id="container-header">
            <div id="container-leftheader">
                <h1>TROC MON TOIT</h1>
            </div>
            <div id="container-rightheader">
                <a href="?page=connection">
                    <button type="button" class="btn-connection-home">ME CONNECTER</button>
                </a>
            </div>
        </div>
    </div>


    <div id="zone-recherche-et-filtre">
        <!-- <div id="zone-recherche">
            <input type="text" id="barre-recherche-logement-home" placeholder="Rechercher un nom de logement">
        </div> -->
        <div id="zone-filtre">
            Filtrer ma recherche: <br>

            Maison : <input type="checkbox">
            Appartement : <input type="checkbox">
            Chalet : <input type="checkbox">
            Villa : <input type="checkbox">
            Péniche : <input type="checkbox">
            Yourte : <input type="checkbox">
            Cabane : <input type="checkbox">
            Igloo : <input type="checkbox">
            Tente : <input type="checkbox">
            Car : <input type="checkbox">


            <?php
            // Check if the button is clicked
            if (isset($_POST['toggleButton'])) {
                // Toggle the visibility status
                $isVisible = !isset($_POST['isVisible']) || $_POST['isVisible'] == 'false';
            } else {
                // Default to visible
                $isVisible = true;
            }
            ?>

            <form method="post" action="">
                <button type="submit" name="toggleButton">FILTRES</button>
                <input type="hidden" name="isVisible" value="<?php echo $isVisible ? 'true' : 'false'; ?>">
            </form>

            <div id="myDiv" class="<?php echo $isVisible ? '' : 'hidden'; ?>">
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
    <section class="gallery">

        <div class="prices">
            <a href="?page=detailsLogement">
                <div class="img"><img src="https://a2.muscache.com/im/pictures/6152848/b04eddeb_original.jpg?aki_policy=x_medium">
                    <div class="price-stamp">158 €/nuit</div>
                    <div class="description">
                        <h4>Loft Studio in the Central Area</h4>
                    </div>
                </div>
            </a>

            <div class="img"><img src="https://a2.muscache.com/im/pictures/34792065/bae84a3f_original.jpg?aki_policy=x_medium">
                <div class="price-stamp">499 €/nuit</div>
                <div class="description">
                    <h4>Everview Suite</h4>
                </div>
            </div>

            <div class="img"><img src="https://a2.muscache.com/im/pictures/1faf9a4c-f839-44da-bd37-65ddc928379e.jpg?aki_policy=x_medium">
                <div class="price-stamp">476 €/nuit</div>
                <div class="description">
                    <h4>180° View, private pool villa</h4>
                </div>
            </div>
        </div>
    </section>


    <script src="script.js"></script>
</body>

</html>