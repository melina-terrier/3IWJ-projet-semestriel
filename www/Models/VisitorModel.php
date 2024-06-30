<?php
namespace App\Models;
use PDO;
class VisitorModel {
    private $pdo;
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    public function getRegisteredUsersCount() {
        $result = $this->pdo->query("SELECT COUNT(*) AS total_user FROM msnu_user");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['total_user'];
    }
    public function getUniqueVisitorsCount($file) {
        return file_exists($file) ? (int)file_get_contents($file) : 0;
    }
}
