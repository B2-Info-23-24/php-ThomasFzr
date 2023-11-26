{% extends "templates/template.php" %}

{% block content %}



{% for user in users %}
<div id="details-users">
    Adresse mail : {{user.mail}} <br><br>
    Mdp : {{user.pwd}} <br><br>
    Nom : {% if user.name != null %} {{user.name}} {%else%} Pas défini {%endif%} <br><br>
    Prénom : {% if user.surname != null %} {{user.surname}} {%else%} Pas défini {%endif%} <br><br>
    Numéro de tél : {% if user.phoneNbr != null %} {{user.phoneNbr}} {%else%} Pas défini {%endif%} <br><br>
    Compte admin : {% if user.isAdmin == 0 %} Non {%else%} Oui {%endif%} <br><br>
    <a href="/deleteUser?id={{user.userID}}">
        <img src="Public/assets/images/iconePoubelleRouge.png" alt="iconePoubelleRouge" id="icone-poubelle-rouge">
    </a>
</div>
{%endfor%}


{% endblock %}