{% extends "templates/template.php" %}

{% block content %}

<div class="flex-container-TES">

    <div class="flex-child-TES left">
        <table>
            <thead>
                <tr>
                    <h3>Types logement:</h3>
                </tr>
            </thead>
            <tbody>
                {% for typeLogement in typesLogement %}
                <tr>
                    <td>{{ typeLogement.name }}</td>
                    <td>
                        <a href="/deleteTypeLogement?id={{typeLogement.typeLogementID}}">
                            <img src="Public/assets/images/iconePoubelleRouge.png" alt="iconePoubelleRouge" id="icone-poubelle-rouge">
                        </a>
                    </td>
                </tr>
                {% endfor %}
                <tr>
                    <td>
                        <a href="javascript:void(0)" id="btn-plus1">
                            <img src="Public/assets/images/iconePlusBlanc.png" alt="iconePlusBlanc" id="imgIconePlus">
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="add-user1" class="profil-card" style="display: none;">
            <form action="/addTypeLogement" method="post">
                Type logement: <input type="text" name="typeLogementName" placeholder="Nom" required> <br><br>
                <input type="submit" value="Ajouter">
            </form>
        </div>
    </div>

    <div class="flex-child-TES right">
        <table>
            <thead>
                <tr>
                    <h3>Services:</h3>
                </tr>
            </thead>
            <tbody>
                {% for service in services %}

                <tr>
                    <td>{{ service.name }}</td>
                    <td>
                        <a href="/deleteService?id={{service.serviceID}}">
                            <img src="Public/assets/images/iconePoubelleRouge.png" alt="iconePoubelleRouge" id="icone-poubelle-rouge">
                        </a>
                    </td>
                </tr>
                {% endfor %}
                <tr>
                    <td>
                        <a href="javascript:void(0)" id="btn-plus2">
                            <img src="Public/assets/images/iconePlusBlanc.png" alt="iconePlusBlanc" id="imgIconePlus">
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="add-user2" class="profil-card" style="display: none;">
            <form action="/addService" method="post">
                Service: <input type="text" name="serviceName" placeholder="Nom" required> <br><br>
                <input type="submit" value="Ajouter">
            </form>
        </div>
    </div>

    <div class="flex-child-TES right">
        <table>
            <thead>
                <tr>
                    <h3> Equipements:</h3>
                </tr>
            </thead>
            <tbody>
                {% for equipement in equipements %}
                <tr>
                    <td>{{ equipement.name }}</td>
                    <td>
                        <a href="/deleteEquipement?id={{equipement.equipementID}}">
                            <img src="Public/assets/images/iconePoubelleRouge.png" alt="iconePoubelleRouge" id="icone-poubelle-rouge">
                        </a>
                    </td>
                </tr>
                {% endfor %}
                <tr>
                    <td>
                        <a href="javascript:void(0)" id="btn-plus3">
                            <img src="Public/assets/images/iconePlusBlanc.png" alt="iconePlusBlanc" id="imgIconePlus">
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="add-user3" class="profil-card" style="display: none;">
            <form action="/addEquipement" method="post">
                Equipement : <input type="text" name="equipementName" placeholder="Nom" required> <br><br>
                <input type="submit" value="Ajouter">
            </form>
        </div>
    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var btnPlus1 = document.getElementById('btn-plus1');
        var addUser1 = document.getElementById('add-user1');
        var btnPlus2 = document.getElementById('btn-plus2');
        var addUser2 = document.getElementById('add-user2');
        var btnPlus3 = document.getElementById('btn-plus3');
        var addUser3 = document.getElementById('add-user3');

        btnPlus1.addEventListener('click', function() {
            console.log('Button clicked!');
            console.log('Before toggle:', addUser1.style.display);

            if (addUser1.style.display === 'none' || addUser1.style.display === '') {
                addUser1.style.display = 'block';
            } else {
                addUser1.style.display = 'none';
            }
        });
        btnPlus2.addEventListener('click', function() {
            console.log('Button clicked!');
            console.log('Before toggle:', addUser2.style.display);

            if (addUser2.style.display === 'none' || addUser2.style.display === '') {
                addUser2.style.display = 'block';
            } else {
                addUser2.style.display = 'none';
            }
        });
        btnPlus3.addEventListener('click', function() {
            console.log('Button clicked!');
            console.log('Before toggle:', addUser3.style.display);

            if (addUser3.style.display === 'none' || addUser3.style.display === '') {
                addUser3.style.display = 'block';
            } else {
                addUser3.style.display = 'none';
            }
        });

    });
</script>



{% endblock %}