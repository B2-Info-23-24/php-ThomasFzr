# Troc Mon Toit, Thomas FOLTZER B2A #



# Installation de docker desktop

[Download Docker Desktop | Docker](https://www.docker.com/products/docker-desktop/)

# Mise en place du projet

- Créer un dossier qui contiendra votre code.
- Dans ce dossier, creer un fichier : `docker-compose.yml`
- Coller dedans (attention aux espaces et aux tabulations):
===================

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

===================
- Creer un fichier : `Dockerfile`
- Coller dedans:
===================
  
FROM php:8.2-apache
# Install additional PHP extensions
RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
RUN service apache2 restart

===================
- Lancer le serveur apache : `docker-compose up -d`
- Donner les autorisations nécessaires au dossier src : `sudo chmod 777 -R src`
- 
- Installer Composer : `sudo apt install composer`
- Installer Twig : `composer require twig/twig`
- Installer Faker : `sudo docker run --rm --interactive --tty --volume %PWD:/app composer require fakerphp/faker`

- Arreter le serveur apache : `docker-compose down`
- Relancer le serveur apache : `docker-compose up --build`

- Cloner le repo github: `git clone https://github.com/B2-Info-23-24/php-ThomasFzr.git src`
- Creer la BDD: `docker exec b21268552815 php createDb.php`

- Aller sur internet et écrire l'url: `http://localhost:8080/`
- Bienvenue sur mon site!

  


