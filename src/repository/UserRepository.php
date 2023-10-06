<?php
/**
 * UserRepository File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category Repository
 * @package  App\repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\repository;

use App\model\RegisterModel;
use App\service\DatabaseService;
use DateTime;

/**
 * UserRepository Class Doc Comment
 * 
 * @category Repository
 * @package  App\repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserRepository
{
    /**
     * Summary of _db
     * 
     * @var DatabaseService $_db connection between PHP and a database server
     */
    private DatabaseService $_db;

    /**
     * Summary of _instance
     * 
     * @var UserRepository
     */
    private static $_instance;

    /**
     * Summary of __construct
     */
    private function __construct()
    {
        $this->_db = DatabaseService::getInstance();
    }

    /**
     * Summary of getInstance
     * 
     * @return \App\repository\UserRepository
     */
    public static function getInstance(): UserRepository
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new UserRepository();
        }
    
        return self::$_instance;
    }

    /**
     * Summary of insertNewUser
     * 
     * @param \App\model\RegisterModel $registerModel RegisterModel
     * 
     * @return int
     */
    public function insertNewUser(RegisterModel $registerModel): int
    {
        $date = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
        $request = 'INSERT INTO users (
                name,
                first_name,
                username,
                email,
                password,
                role,
                creation_date,
                last_update_date,
                is_allowed
                ) 
            VALUES (
                :name,
                :first_name,
                :username,
                :email,
                :password,
                :role,
                :creation_date,
                :last_update_date,
                :is_allowed
                )';
        $parameters = [
            'name' => $registerModel->getName(),
            'first_name' => $registerModel->getFirstName(),
            'username' => $registerModel->getUsername(),
            'email' => $registerModel->getEmail(),
            'password' => $registerModel->getPassword(),
            'role' => 'user',
            'creation_date' => $date->format('Y-m-d H:i:s'),
            'last_update_date' => $date->format('Y-m-d H:i:s'),
            'is_allowed' => 0
        ];
        $this->_db->execute($request, $parameters);
        $newReq = 'SELECT LAST_INSERT_ID()';
        $lastInsertId = $this->_db->execute($newReq, null);
        $id = $lastInsertId[0]["LAST_INSERT_ID()"];

        return $id;
    }

    /**
     * Summary of getUser
     * 
     * @param string $username username
     * 
     * @return array with all the data of a User
     */
    public function getUser(string $username): array
    {
        $request = 'SELECT * FROM users WHERE username = :username';
        $parameters = [
            'username' => $username
        ];
        $result = $this->_db->execute($request, $parameters);

        return $result;
    }

    /**
     * Summary of getUserId
     * 
     * @param string $username username
     * 
     * @return int
     */
    public function getUserId(string $username): int
    {
        $request = 'SELECT id FROM users WHERE username = :username';
        $parameters = [
            'username' => $username
        ];
        $id = $this->_db->execute($request, $parameters);

        return $id[0]["id"];
    }

    /**
     * Summary of getAllUsernames
     * 
     * @return array
     */
    public function getAllUsernames(): array
    {
        $request = 'SELECT username FROM users';

        return $this->_db->execute($request, []);
    }

    /**
     * Summary of getAllUsers
     * 
     * @return array
     */
    public function getAllUsers(): array
    {
        $request = 'SELECT * FROM users';

        return $this->_db->execute($request, []);
    }

    /**
     * Summary of updateRole
     * 
     * @param int    $userId    id of the user
     * @param string $role      role of the user
     * @param int    $isAllowed 1 if the user is allowed
     * 
     * @return void
     */
    public function updateRole(int $userId, string $role, int $isAllowed): void
    {
        $request = 'UPDATE users SET role = :role, is_allowed =:is_allowed WHERE id = :id';
        $parameters = [
            'id' => $userId,
            'role' => $role,
            'is_allowed' => $isAllowed
        ];
        $this->_db->execute($request, $parameters);
    }

    // // Préparez la requête SQL
    // $sql = "SELECT * FROM ma_table WHERE condition = :valeur";

    // // Utilisez la méthode prepare pour préparer la requête
    // $stmt = $pdo->prepare($sql);

    // // Remplacez :valeur par la valeur réelle que tu souhaites rechercher
    // $valeur = "valeur_recherchee";

    // // Lier la valeur à la variable dans la requête préparée
    // $stmt->bindParam(':valeur', $valeur, PDO::PARAM_STR);

    // // Configurez le mode de récupération pour utiliser la classe personnalisée
    // $stmt->setFetchMode(PDO::FETCH_CLASS, CommentEntity::class);

    // // Exécutez la requête
    // $stmt->execute();

    // // Utilisez fetch pour récupérer un seul résultat sous forme d'objet de la classe personnalisée
    // $resultat = $stmt->fetch();

    // if ($resultat) {
    //     // Vous pouvez accéder aux propriétés de l'objet comme ceci
    //     echo "ID : " . $resultat->id . "<br>";
    //     echo "Nom : " . $resultat->nom . "<br>";
    //     // ... etc.
    // } else {
    //     echo "Aucun résultat trouvé.";
    // }

}
