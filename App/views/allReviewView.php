{% extends "templates/template.php" %}

{% block content %}
<h3> Tous les avis: </h3>


<ul>
    {% for review in reviews %}

    <div id="details-commentaires-notes">
        <li>{{ review.grade }}⭐
            ({{ review.date|date("d/m/Y") }})
            <br>
            {{ review.comment }}
        </li>
    </div> <br>
    {% endfor %}
</ul>

{% endblock %}