<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Public/assets/styles/style.css">
    {% block head %}{% endblock %}
    <title>Troc mon toit</title>
    <base href="http://localhost:8080/">
</head>

<body>
    {%include 'headerView.php' %}

     <!-- TODO If message success echo here in php -->
    <?php
    if (isset($_SESSION['successMsg'])) {
        echo $_SESSION['successMsg'];
    }else{
        echo 'no';
    }

    ?>
   
    {% block content %}{% endblock %}

    {% block footer %}{% endblock %}
</body>

</html>