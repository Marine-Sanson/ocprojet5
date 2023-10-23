<div align="center">
    <img src="https://upload.wikimedia.org/wikipedia/fr/0/0d/Logo_OpenClassrooms.png" width="120" height="120" alt="logo OpenClassrooms">
</div>


# Ocprojet5
Project for OpenClasssrooms : create a blog with PHP


## What I used for this project :


### Main language :

<img src="https://img.shields.io/badge/php-8.10.1-%23777BB4?logo=php" alt="php banner">

I have decide to use php without any framework, because it is my first big project of this training.
I have made all the project in MVC advanced pattern, I also used singleton, an abstract class and enum classes.


### Front-end :

<img src="https://img.shields.io/badge/HTML-5-%23E34F26?logo=html5" alt="HTML5 banner"> <img src="https://img.shields.io/badge/CSS-3-%231572B6?logo=css3" alt="CSS3 banner"> <img src="https://img.shields.io/badge/Bootstrap-5.3.1-%237952B3?logo=bootstrap" alt="bootstrap banner"> <img src="https://img.shields.io/badge/Twig-3.0-%23bacf29" alt="Twig banner">

Of course this project use HTML5 and CSS3, but I also used Bootsrap (a free theme from staartBootstrap : Grayscale v7.0.6) and Twig


### Database :

<img src="https://img.shields.io/badge/MySQL-8.0.30-%234479A1?logo=mysql" alt="MySQL banner"> <img src="https://img.shields.io/badge/HeidiSQL-12.1.0-%234479A1?logo=mysql" alt="MySQL banner"> <img src="https://img.shields.io/badge/Laragon-6.0-%230E83CD?logo=laragon" alt="MySQL banner">

For the database I use MySQL with HeidiSQL because they are in my development server solution <a href="https://laragon.org/index.html">Laragon</a>


### Tools :

<img src="https://img.shields.io/badge/Composer-2.4.1-%23885630?logo=composer" alt="composer banner"> <img src="https://img.shields.io/badge/phpdotenv-5.5-%23ECD53F?logo=dotenv" alt="phpdotenv banner"> <img src="https://img.shields.io/badge/PHPMailer-6.8-%23f0c563" alt="PHPMailer banner"> <img src="https://img.shields.io/badge/Tools-GitHub-%23181717?logo=github" alt="GitHub banner">

I used <a href="https://getcomposer.org/">Composer</a>, that is an easy way to install Twig, PHPMailer and .env

I chose to use <a href="https://github.com/vlucas/phpdotenv">.env</a> to secure my environnement variables, and <a href="https://github.com/PHPMailer/PHPMailer">PHPMailer</a> to manage the mail sending 

This project is avaliable on <a href="https://github.com/">GitHub</a>, and received a **A** notation in <a href="https://www.codacy.com/">Codacy</a> ! Vous pouvez voir la dernière annalyse ici : <a href="https://app.codacy.com/gh/Marine-Sanson/ocprojet5/dashboard">https://app.codacy.com/gh/Marine-Sanson/ocprojet5/dashboard</a>

<div align="center">
    <img src="https://img.shields.io/codacy/grade/591cf51d80244641be9c2514f607a6ce" alt="code quality from Codacy">
    <br>
</div>


## How to run this project :

To run this project, you need to use composer, and run :
```
composer require "twig/twig:^3.0"
```
```
composer require phpmailer/phpmailer
```
```
composer require vlucas/phpdotenv
```

For your connection informations (database and SMTP), copy the ```.env``` file in a ```.env.local``` file and replace the data by yours

You will find the database script and uml diagrams in the documents file. Before using the database instalation file, be sure that you have replaced the name of my database by yours 


## GitHub stats :

[![Top Langs](https://github-readme-stats.vercel.app/api/top-langs/?username=Marine-Sanson&layout=compact)](https://github.com/Marine-Sanson)
