{% extends "templates/template.php" %}

{% block content %}







<h3>Services:</h3>
<nav class="navigation">
    <ul>
        {% for service in services %}
        <li>
            <label>
                {{ service.name }}
                <input type="checkbox" name="selectedServices[]" value="{{ service.serviceID }}">
            </label>
        </li>
        {% endfor %}
    </ul>
</nav> <br><br>

<h3> Equipements:</h3>
<nav class="navigation">
    <ul>
        {% for equipement in equipements %}
        <li>
            <label>
                {{ equipement.name }}
                <input type="checkbox" name="selectedEquipements[]" value="{{ equipement.equipementID }}">
            </label>
        </li>
        {% endfor %}
    </ul>
</nav>



{% endblock %}