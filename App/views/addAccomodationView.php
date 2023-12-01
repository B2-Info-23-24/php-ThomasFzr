{% extends "templates/template.php" %}

{% block content %}
</br></br>

<div class="flex-container-details-logement">
    <div class="flex-child-details-logement left">

        <form action="/processAccomodation?action=addAccomodation" method="post">
            <img src="Public/assets/images/Appartement1.png" id="img-details-annonce">
            <br>
            <div class="description-annonce">
                Image: <select name="image" onchange="updateImage()" id="imageSelector" required>
                    <option disabled>Choisir une image</option>
                    {% for image in allImages%}
                    <option value="{{image.name}}">{{image.name}}</option>
                    {% endfor %}
                </select><br>
                Titre: <input type="text" name="title" placeholder="Nom" required> <br><br>
                Ville: <select name="city" required>
                    <option disabled>Choisir une ville</option>
                    {% for city in allCities%}
                    <option value="{{city.name}}">{{city.name}}</option>
                    {% endfor %}
                </select> <br><br>
                Prix: <input type="number" name="price" placeholder="Prix à la nuit" required> €/nuit<br><br>
                Type de logement:
                <select name="accoType" required>
                    <option disabled>Choisir un type de logement</option>
                    {% for accomodationType in accomodationTypes%}
                    <option value="{{accomodationType.name}}">{{accomodationType.name}}</option>
                    {% endfor %}
                </select><br><br>

                Equipements disponibles:<br><br>
                {% for equipment in equipments%}
                {{equipment.name}} <input type="checkbox" value="{{equipment.equipmentID}}" name="selectedEquipments[]">
                {% endfor %}<br><br>

                Services disponibles:<br><br>
                {% for service in services %}
                {{service.name}} <input type="checkbox" value="{{service.serviceID}}" name="selectedServices[]">
                {% endfor %}<br><br>

                <input type="submit" value="AJOUTER L'ANNONCE">
            </div>

        </form>


    </div>
</div>

<script>
    function updateImage() {
        var selectedImage = document.getElementById("imageSelector").value;

        document.getElementById("img-details-annonce").src = "Public/assets/images/" + selectedImage;
    }
</script>

{% endblock %}