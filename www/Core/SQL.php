<?php
namespace App\Core;

use PDO;

class SQL
{
    private $pdo;
    private $table;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("pgsql:host=postgres;dbname=esgi;port=5432", "esgi", "esgipwd");
        } catch (\Exception $e) {
            die("Erreur SQL : " . $e->getMessage());
        }

        $classChild = get_called_class();
        $this->table = "msnu_" . strtolower(str_replace("App\\Models\\", "", $classChild));
    }

    private function prepareColumns($columns)
    {
        foreach ($columns as $key => $value) {
            if ($value instanceof \DateTime) {
                $columns[$key] = $value->format('Y-m-d H:i:s');
            }
        }
        return $columns;
    }

    public function save()
    {
        // Vous ne devez pas écrire en dur le nom de la table ou des colonnes à insérer en BDD
        $columnsAll = get_object_vars($this);
        $columnsToDelete = get_class_vars(get_class());
        $columns = array_diff_key($columnsAll, $columnsToDelete);

        // Préparer les colonnes pour gérer les objets DateTime
        $columns = $this->prepareColumns($columns);

        if (empty($this->getId())) {
            $sql = "INSERT INTO " . $this->table . " (" . implode(', ', array_keys($columns)) . ")  
            VALUES (:" . implode(', :', array_keys($columns)) . ")";
        } else {
            // UPDATE esgi_user SET firstname=:firstname, lastname=:lastname WHERE id=1
            foreach ($columns as $column => $value) {
                $sqlUpdate[] = $column . "=:" . $column;
            }

            $sql = "UPDATE " . $this->table . " SET " . implode(', ', $sqlUpdate) . " WHERE id=" . $this->getId();
        }
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($columns);
    }
}
