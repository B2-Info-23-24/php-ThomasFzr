{% extends "templates/template.php" %}

{% block content %}

<h3>Tous les users: </h3>
<div id="zone-users">
    {% for user in users %}
    <div id="details-users">
        Adresse mail : {{user.mail}} <br><br>
        Mdp : {{user.pwd}} <br><br>
        Nom : {% if user.name != null %} {{user.name}} {%else%} Pas défini {%endif%} <br><br>
        Prénom : {% if user.surname != null %} {{user.surname}} {%else%} Pas défini {%endif%} <br><br>
        Numéro de tél : {% if user.phoneNbr != null %} {{user.phoneNbr}} {%else%} Pas défini {%endif%} <br><br>
        Compte admin : {% if user.isAdmin == 0 %} Non {%else%} Oui {%endif%} <br><br>
        <a href="/processUser?action=delete&id={{user.userID}}">
            <img src="Public/assets/images/iconePoubelleRouge.png" alt="iconePoubelleRouge" id="icone-poubelle-rouge">
        </a>
    </div>
    {%endfor%}
</div>


<a href="javascript:void(0)" id="btn-plus">
    <img src="Public/assets/images/iconePlusBlanc.png" alt="iconePlusBlanc" id="imgIconePlus">
</a>

<div id="add-user" class="profil-card" style="display: none;">
    <form action="/processUser?action=add" method="post">
        Adresse mail: <input type="email" name="mail" placeholder="Mail" required> <br><br>
        Mdp: <input type="text" name="pwd" placeholder="Mdp" required> <br><br>
        Compte admin : <select name="isAdmin" required>
            <option value="0">Non</option>
            <option value="1">Oui</option>
        </select><br><br>
        Nom: <input type="text" name="name" placeholder="Nom"> <br><br>
        Prénom: <input type="text" name="surname" placeholder="Prénom"> <br><br>
        Numéro de tél: <input type="number" name="phoneNbr" placeholder="Numéro de tél"><br><br>
        <input type="submit" value="Ajouter">
    </form>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var btnPlus = document.getElementById('btn-plus');
        var addUser = document.getElementById('add-user');

        btnPlus.addEventListener('click', function() {
            console.log('Button clicked!');
            console.log('Before toggle:', addUser.style.display);

            if (addUser.style.display === 'none' || addUser.style.display === '') {
                addUser.style.display = 'block';
            } else {
                addUser.style.display = 'none';
            }

            console.log('After toggle:', addUser.style.display);
        });

    });
</script>

{% endblock %}