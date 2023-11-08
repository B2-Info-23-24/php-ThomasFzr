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
            Filtrer ma recherche:
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
            Date fin: <input type="date" id="dateFin">

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

        </div>
    </div>

    <div class="annonces-logement">
        <!-- <img src="/src/assets/logement1.jpg" alt="img logement1">
        <img src="/src/assets/logement2.jpg" alt="img logement2">
        <img src="/src/assets/logement3.jpg" alt="img logement3"> -->
    </div>

    <script src="script.js"></script>
</body>

</html>