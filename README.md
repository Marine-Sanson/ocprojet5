<img src="https://img.shields.io/badge/php-8.1.10-%23777BB3" alt="php banner">
<img src="https://img.shields.io/badge/Twig-3.0-%23bacf29" alt="Twig banner">
<img src="https://img.shields.io/badge/PHPMailer-6.8-%23f0c563" alt="PHPMailer banner">
<img src="https://img.shields.io/badge/phpdotenv-5.5-%23e5ce3d" alt="phpdotenv banner">
<img src="https://img.shields.io/badge/Bootstrap-5.3.1-%237432f9" alt="bootstrap banner">
<img src="https://img.shields.io/badge/Composer-2.4.1-%23c29019" alt="composer banner">


# ocprojet5
Project for OpenClasssrooms : create a blog with PHP

To run this project, you need to use composer, and install :
twig": "^3.0",
phpmailer": "^6.8",
"vlucas/phpdotenv": "^5.5"

For your database connection, use a file .env.local with 4 const : 
DB_HOST
DB_NAME
DB_USER
DB_PASS

For SMTP connexion, use a config.php file, in src/service, who have 5 const : 
SMTP_HOST
SMTP_PORT
SMTP_USERNAME
SMTP_PASSWORD
SMTP_NAME

You will find the database script and uml diagrams in the documents file
