{% extends "templates/template.php" %}

{% block content %}
<h3>Mon profil: </h3>
<div id="profil-user">
    <form action="/editInfoUser" method="post">
        Adresse mail :
        <input type="email" value="{{infoUser.mail}}" name="mail" required>
        <input type="image" src="Public/assets/images/iconeStyloBleu.png" alt="iconeStyloBleu" id="icone-poubelle-rouge">
    </form><br>
    <form action="/editInfoUser" method="post">
        Mdp :
        <input type="text" value="{{infoUser.pwd}}" name="pwd" required>
        <input type="image" src="Public/assets/images/iconeStyloBleu.png" alt="iconeStyloBleu" id="icone-poubelle-rouge">
    </form><br>
    <form action="/editInfoUser" method="post">
        Nom :
        <input type="text" value="{% if infoUser.name %}{{infoUser.name}}{% else %}Pas encore définis{% endif %}" name="name" required>
        <input type="image" src="Public/assets/images/iconeStyloBleu.png" alt="iconeStyloBleu" id="icone-poubelle-rouge">
    </form><br>
    <form action="/editInfoUser" method="post">
        Prénom :
        <input type="text" value="{% if infoUser.surname %}{{infoUser.surname}}{% else %}Pas encore définis{% endif %}" name="surname" required>
        <input type="image" src="Public/assets/images/iconeStyloBleu.png" alt="iconeStyloBleu" id="icone-poubelle-rouge">
    </form><br>
    <form action="/editInfoUser" method="post">
        Numéro de tél :
        <input type="text" value="{% if infoUser.phoneNbr %}{{infoUser.phoneNbr}}{% else %}Pas encore définis{% endif %}" name="phoneNbr" required>
        <input type="image" src="Public/assets/images/iconeStyloBleu.png" alt="iconeStyloBleu" id="icone-poubelle-rouge">
    </form><br>
</div>

{% endblock %}