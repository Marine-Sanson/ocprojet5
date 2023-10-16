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
