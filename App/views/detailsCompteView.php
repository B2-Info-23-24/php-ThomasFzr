{% extends "templates/template.php" %}

{% block content %}
<div id="profil-user">
    <h3>Mon profil: </h3>

    <div>
        Nom: {% if infoUser.name %}
        {{infoUser.name}}
        {% else %}
        Pas encore définis
        {% endif %}

    </div>
    <div>
        <br>Prénom: {% if infoUser.surname %}
        {{infoUser.surname}}
        {% else %}
        Pas encore définis
        {% endif %}
    </div>
    <div>
        <br>Numéro de téléphone: {% if infoUser.phoneNbr %}
        {{infoUser.phoneNbr}}
        {% else %}
        Pas encore définis
        {% endif %}
    </div>
    <div>
        <br>Mail : {% if infoUser.mail %}
        {{infoUser.mail}}
        {% else %}
        Pas encore définis
        {% endif %}

    </div>
</div>

<div id="profil-user-modif">
    <h3>Modif: </h3>
    <form action="/editInfoUser" method="post">
        <input type="text" id="name" name="name" placeholder="name"> <br>
        <input type="text" id="surname" name="surname" placeholder="surname"><br>
        <input type="number" id="name" name="phoneNbr" placeholder="phoneNbr"><br>
        <input type="submit" value="Modifier">
    </form>

</div>

{% endblock %}