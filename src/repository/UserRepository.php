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

use App\service\DatabaseService;

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
     * Summary of getUser
     * 
     * @param string $username username
     * 
     * @return array with all the data of a User
     */
    public function getUser(string $username): array
    {
        $this->_db = DatabaseService::getInstance();
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
        $this->_db = DatabaseService::getInstance();
        $request = 'SELECT id FROM users WHERE username = :username';
        $parameters = [
            'username' => $username
        ];
        $id = $this->_db->execute($request, $parameters);

        return $id[0]["id"];
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
