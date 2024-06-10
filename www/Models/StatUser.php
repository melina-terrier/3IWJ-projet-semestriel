<?php
// StatUser.php
namespace App\Models;

use PDO;
use PDOException;
use App\Core\SQL;

class StatUser extends SQL {
    private $db;
    public function __construct() {
        try {
            $this->db = new PDO('pgsql:host=postgres;dbname=esgi;port=5432', 'esgi', 'esgipwd');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
    }

    public function getPagesByUser() {
        try {
            // Ajoutez votre logique de récupération des pages par utilisateur ici
            // Par exemple :
            $query = "SELECT user_id, COUNT(*) as pages_count FROM msnu_page GROUP BY user_id";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Query failed: ' . $e->getMessage();
        }
    }

     public function getProjectsByUser() {
       try {
            $stmt = $this->db->prepare(SQL::$GET_PROJECTS_BY_USER);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Query failed: ' . $e->getMessage();
        }
     }

    public function getCategoriesByUser() {
        try {
            $stmt = $this->db->prepare(SQL::$GET_CATEGORIES_BY_USER);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Query failed: ' . $e->getMessage();
        }
    }

    public function getCommentsByUser() {
        try {
            $stmt = $this->db->prepare(SQL::$GET_COMMENTS_BY_USER);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Query failed: ' . $e->getMessage();
        }
    }
}
?>
