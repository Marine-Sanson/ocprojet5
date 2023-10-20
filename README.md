<img src="https://badgen.net/#badge/php/8.1.10?icon=php" alt="my banner">

<img src="https://user-content.gitlab-static.net/94973800a55d9ec83fe4703b5a4df6bbd9e2ae89/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f56657273696f6e2d312e302d627269676874677265656e2e737667" alt="my banner">

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
