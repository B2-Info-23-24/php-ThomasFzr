{% extends "templates/template.php" %}

{% block content %}
</br></br>

<div class="flex-container-details-logement">
    <div class="flex-child-details-logement left">

        <form action="/processAddAnnonce" method="post">
            <img src="Public/assets/images/iconePlusBlanc.png" id="img-details-annonce">
            <br>





            <div class="description-annonce">
                Image: <input type="file" name="image" accept="image/png, image/jpeg" /><br>
                Nom: <input type="text" name="nom" placeholder="Nom" required> <br><br>
                Ville: <input type="text" name="ville" placeholder="Ville" required> <br><br>
                Prix: <input type="number" name="prix" placeholder="Prix à la nuit" required><br><br>
                Type de logement:
                <select name="typeLogement" required>
                    <option value="">Choisir un type de logement</option>
                    {% for typeLogement in typesLogement%}
                    <option value="{{typeLogement.name}}">{{typeLogement.name}}</option>
                    {% endfor %}
                </select><br><br>

                Equipements disponibles:<br><br>
                {% for equipement in equipements%}
                {{equipement.name}} <input type="checkbox" value="{{equipement.equipementID}}">
                {% endfor %}<br><br>

                Services disponibles:<br><br>
                {% for service in services %}
                {{service.name}} <input type="checkbox" value="{{service.serviceID}}">
                {% endfor %}<br><br>

                <input type="submit">
            </div>

        </form>


    </div>
</div>

{% endblock %}