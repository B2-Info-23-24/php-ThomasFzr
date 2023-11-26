{% extends "templates/template.php" %}

{% block content %}
<h3>Types logement:</h3>


<nav class="navigation">
    <ul>
        {% for typeLogement in typesLogement %}
        <li>{{ typeLogement.name }}</li>
        {% endfor %}
    </ul>
</nav>



{% endblock %}