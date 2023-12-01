{% extends "templates/template.php" %}

{% block content %}
<h3> Tous les avis: </h3>

<a href="javascript:void(0)" id="btn-plus">
    <img src="Public/assets/images/iconePlusBlanc.png" alt="iconePlusBlanc" id="imgIconePlus">
</a>



<div class="zone-annonce">

    <div id="add-user" class="profil-card" style="display: none;">
        <form action="/processReview?action=add" method="post">
            Utilisateur : <select name="userID" required>
                <option disabled> Choisir un utilisateur</option>
                {% for user in users%}
                <option value="{{user.userID}}">{{user.surname}}, Id: {{user.userID}}</option>
                {%endfor%}
            </select><br><br>
            Annonce: <select name="accommodationID" required>
                <option disabled> Choisir une annonce</option>
                {% for accommodation in accommodations%}
                <option value="{{accommodation.accommodationID}}">{{accommodation.title}}, Id: {{accommodation.accommodationID}}</option>
                {%endfor%}
            </select><br><br>
            Note: <input type="number" name="grade" placeholder="/5" min="0" max="5" required> <br><br>
            Commentaire: <input type="text" name="comment" placeholder="Ajouter un commentaire" required> <br><br>
            Date: <input type="date" name="date" required><br><br>
            <input type="submit" value="Ajouter">
        </form>
    </div>
    {% for review in reviews %}

    <a href="/accommodation/{{ review.accommodationID }}" id="lien-annonce">
        <div class="annonce">
            <img src="Public/assets/images/{{review.image}}" id="img-annonce-home" alt="image-{{ review.image }}">
            <div class="zone-prix">{{ review.price }} €/nuit</div>
            <div class="description">
                <h4>{{ review.title }}</h4>
            </div>
    </a>

    <div id="details-all-reviews">
        <form action="/processReview?action=modify&id={{review.reviewID}}" method="post">
            Note : <input type="number" value="{{review.grade}}" name="grade" min="0" max="5" required>/5⭐
            <input type="image" src="Public/assets/images/iconeStyloBleu.png" alt="iconeStyloBleu" id="icone-poubelle-rouge">
        </form>
        <form action="/processReview?action=modify&id={{review.reviewID}}" method="post">
            Utilisateur : <select name="userID" required>
                <option disabled> Actuel : {{review.surname}}, Id: {{review.userID}}</option>
                {% for user in users%}
                <option value="{{user.userID}}">{{user.surname}}, Id: {{user.userID}}</option>
                {%endfor%}
            </select>
            <input type="image" src="Public/assets/images/iconeStyloBleu.png" alt="iconeStyloBleu" id="icone-poubelle-rouge">
        </form>
        <form action="/processReview?action=modify&id={{review.reviewID}}" method="post">
            Date : <input type="date" value="{{review.date}}" name="date" required>
            <input type="image" src="Public/assets/images/iconeStyloBleu.png" alt="iconeStyloBleu" id="icone-poubelle-rouge">
        </form>
        <form action="/processReview?action=modify&id={{review.reviewID}}" method="post">
            Commentaire : <input type="text" value="{{ review.comment }}" name="comment" required>
            <input type="image" src="Public/assets/images/iconeStyloBleu.png" alt="iconeStyloBleu" id="icone-poubelle-rouge">
        </form>
        <br>

        <a href="/processReview?action=delete&id={{review.reviewID}}">
            <img src="Public/assets/images/iconePoubelleRouge.png" alt="iconePoubelleRouge" id="icone-poubelle-rouge">
        </a>
    </div>
</div>
{% endfor %}




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