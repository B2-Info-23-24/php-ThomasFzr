{% extends "templates/template.php" %}

{% block content %}
</br></br>

<div class="flex-container-details-logement">
    <div class="flex-child-details-logement left">

        <form action="/processAccomodation?action=add" method="post">
            <img src="Public/assets/images/iconePlusBlanc.png" id="img-details-annonce">
            <br>
            <div class="description-annonce">
                Image: <input type="file" name="image" accept="image/png, image/jpeg" /><br>
                Titre: <input type="text" name="title" placeholder="Nom" required> <br><br>
                Ville: <input type="text" name="city" placeholder="Titre" required> <br><br>
                Prix: <input type="number" name="price" placeholder="Prix à la nuit" required><br><br>
                Type de logement:
                <select name="typeLogement" required>
                    <option value="">Choisir un type de logement</option>
                    {% for accomodationType in accomodationTypes%}
                    <option value="{{accomodationType.name}}">{{accomodationType.name}}</option>
                    {% endfor %}
                </select><br><br>

                Equipements disponibles:<br><br>
                {% for equipment in equipments%}
                {{equipment.name}} <input type="checkbox" value="{{equipment.equipmentID}}" name="selectedEquipment[]">
                {% endfor %}<br><br>

                Services disponibles:<br><br>
                {% for service in services %}
                {{service.name}} <input type="checkbox" value="{{service.serviceID}}" name="selectedService[]">
                {% endfor %}<br><br>

                <input type="submit">
            </div>

        </form>


    </div>
</div>

{% endblock %}