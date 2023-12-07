# Troc Mon Toit, Thomas FOLTZER B2A #

# Présentation du projet

Dans le cadre du module PHP, nous avons dû réalisé un site web pour
une agence de location (Troc mon Toit) qui souhaite numériser ses services
et mettre à disposition différents logements qu’elle possède afin d’en tirer des revenus.
Cette application doit permettre un affichage de l’ensemble des logements disponibles. Ces
logements, imagés par une photo, doivent pouvoir être recherchables par ville.
Par ailleurs cet affichage doit permettre de filtrer les logements par prix à la nuit, 
type de logement, équipements disponibles et services disponibles.

# Guide d'installation


# Installation de docker desktop

[Download Docker Desktop | Docker](https://www.docker.com/products/docker-desktop/)

# Mise en place du projet

- Créer un dossier qui contiendra votre code.
- Dans ce dossier, creer un fichier : `docker-compose.yml`
- Coller dedans (attention aux espaces et aux tabulations):



version: '3'

services:
  web:
    build: .
    ports:
      - "8080:80" # Expose port 8080 on WSL to port 80 in the container
    volumes:
      - ./src:/var/www/html

  mysql:
    image: mysql:5.7
    environment:
      MYSQL_ROOT_PASSWORD: my-secret-pw
      MYSQL_DATABASE: my_database
      MYSQL_USER: my_user
      MYSQL_PASSWORD: my_password
    volumes:
      - db_data:/var/lib/mysql
    ports:
      - "3306:3306" # Expose port 3306 on the host to port 3306 in the container

volumes:
  db_data:




- Creer un fichier : `Dockerfile`
- Coller dedans:



  
FROM php:8.2-apache
RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
RUN service apache2 restart




- Lancer le serveur apache : `docker-compose up -d`
- Donner les autorisations nécessaires au dossier src : `sudo chmod 777 -R src`


# Accès à la base de données

Pour accéder à la base de données, vous pouvez utiliser l’outil que vous voulez, cependant nous préconisons l’utilisation de beekeeper studio, un puissant éditeur de base de données 

[https://github.com/beekeeper-studio/beekeeper-studio](https://github.com/beekeeper-studio/beekeeper-studio)

Une fois sur l’application, is faut configurer une nouvelle connexion 

![Untitled](https://i.imgur.com/RZ693Z2.png)

Ici nous choisissons MySQL. 

Vous pouvez ensuite remplir les informations de connexion avec celles fournies dans le fichier docker-compose.yml

![Untitled](https://i.imgur.com/uxmEInv.png)

Vous pouvez avez désormais accès à la base de données 


- Installer Composer : `sudo apt install composer`
- Installer Twig : `composer require twig/twig`
- Installer Faker : `sudo docker run --rm --interactive --tty --volume %PWD:/app composer require fakerphp/faker`

- Arreter le serveur apache : `docker-compose down`
- Relancer le serveur apache : `docker-compose up --build`

- Cloner le repo github: `git clone https://github.com/B2-Info-23-24/php-ThomasFzr.git src`

- Chercher son numéro de container: `docker ps`
- Copier coller le numéro en dessous de CONTAINER ID, qui correspond à l'image php-web (ex: b21268552815)

- Creer la BDD avec cette commande, en remplaçant b21268552815 
  avec votre CONTAINER ID: `docker exec b21268552815 php createDb.php`

- Aller sur internet et écrire l'url: `http://localhost:8080/`
- Bienvenue sur mon site!

  
# Guide d'utilisation

Une fois sur le site, nous pouvons soit nous connecté si nous avons déjà 
un compte, soit nous inscrire.

Sans être connecté nous pouvons voir l'ensemble des logements, voir
le détails du logement en cliquant dessus (équipements/services, ville, prix, etc.),
nous pouvons également filtrer les logements par:
- prix
- ville
- équipements
- services
- type de logement

Mais nous ne devons pas réserver, ni ajouter en favoris le logement.

Lors du lancement du projet, sont créé plusieurs comptes utilisateurs basiques:

    Identifiant : `elise@elise.com`
    Mdp: `elise`

    Identifiant : `joe@joe.com`
    Mdp: `joe`

Les utilisateurs s'ils sont connectés peuvent :
- mettre en favoris un logement
- réserver un logement si les dates sont disponnibles
- laisser un unique avis sur sa réservation une fois celle-ci terminée
- modifier son profil (nom, prénom, num de tél, mail, mdp)
- voir l'ensemble de ses logements favoris, sont historiques de 
  réservations et d'avis

Un compte administrateur est également créé:

    Identifiant : `admin@admin.com`
    Mdp: `admin`

L'administrateur peut:
- voir l'ensemble des utilisateurs, modifier leur profil, en créer 
  de nouveaux et en supprimer
- voir l'ensemble des logements, modifier leur description 
  (titre, prix, équipements/services dispo, type de logement, etc.), 
  en créer de nouveaux et un supprimer
- voir l'ensemble des types de logement, des services et des équipements
  modifier leur nom, en créer de nouveaux et en supprimer
- voir l'ensemble des avis, les modifier (date, note, commentaire)
  en créer de nouveaux et en supprimer
- voir l'ensemble des réservations et des favoris, en ajouter et en supprimer
- filter les logements par nom du logement




