<?php
namespace App\Core;
use PDO;

class SQL
{
    private $pdo;
    private $table;

    public function __construct()
    {
        try{
            $this->pdo = new PDO("pgsql:host=postgres;dbname=esgi;port=5432","esgi","esgipwd");
        }catch (\Exception $e){
            die("Erreur SQL : ".$e->getMessage());
        }
        $classChild = get_called_class();
        $this->table = "msnu_".strtolower(str_replace("App\\Models\\","",$classChild));
    }

    public function save()
    {
        $columnsAll = get_object_vars($this);
        $columnsToDelete = get_class_vars(get_class());
        $columns = array_diff_key($columnsAll, $columnsToDelete);
        if( empty($this->getId()) ) {
            unset($columns['id']);
            $sql = "INSERT INTO ".$this->table. " (". implode(', ', array_keys($columns) ) .")  
            VALUES (:". implode(',:', array_keys($columns) ) .")";
        }else{
            $isUpdate = true;
            foreach ( $columns as $column=>$value){
                $sqlUpdate[] = $column."=:".$column;
            }
            $sql = "UPDATE " . $this->table . " SET " . implode(', ', $sqlUpdate) . " WHERE id=" . $this->getId();
        }
        $queryPrepared = $this->pdo->prepare($sql);
        foreach ($columns as $key => $value) {
            $type = is_bool($value) ? \PDO::PARAM_BOOL : (is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
            $queryPrepared->bindValue(":$key", $value, $type);
        }
        $queryPrepared->execute($columns);
        if (isset($isUpdate)) {
            return $this->getId();
        }
        return $this->pdo->lastInsertId($this->table."_id_seq");
    }

    public function emailExists($email): bool {
        $sql = "SELECT COUNT(*) FROM " . $this->table . " WHERE email = :email";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([':email' => $email]);
        $number = $queryPrepared->fetchColumn();
        return $number > 0;
    }

    public function getOneBy(array $data, string $return = "array")
    {
        $sql = "SELECT * FROM ".$this->table. " WHERE ";
        foreach ($data as $column => $value) {
            $sql .= " ".$column."=:".$column. " AND";
        }
        $sql = substr($sql, 0, -3);
        $queryPrepared = $this->pdo->prepare($sql); 
        $queryPrepared->execute($data);
        if($return == "object") {
            $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        } else {
            $queryPrepared->setFetchMode(\PDO::FETCH_ASSOC);
        }
        return $queryPrepared->fetch();
    }

    public function checkUserCredentials(string $email, string $password): ?object
    {
        $user = $this->getOneBy(['email' => $email], 'object');
        if ($user && password_verify($password, $user->getPassword())) {
            return $user;
        }
        return null;
    }

    public function getAllData(string $return = "array")
    {
        $sql = "SELECT * FROM " . $this->table;
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        if($return == "object") {
            $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        } else {
            $queryPrepared->setFetchMode(\PDO::FETCH_ASSOC);
        }
        return $queryPrepared->fetchAll();
    }

    public function getDataObject(): array
    {
        return array_diff_key(get_object_vars($this), get_class_vars(get_class()));
    }

    public function setDataFromArray(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
    
    public function delete(array $data)
    {
        $recordToDelete = $this->getOneBy($data);
        if (!$recordToDelete) {
            return false;
        }
        $sql = "DELETE FROM " . $this->table . " WHERE ";
        foreach ($data as $column => $value) {
            $sql .= " " . $column . "=:" . $column . " AND";
        }
        $sql = substr($sql, 0, -3);
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($data);
        return $queryPrepared->rowCount() > 0;
    }

    public function countElements($typeColumn = null, $typeValue = null): int {
        if ($typeColumn && $typeValue) {
            $sql = "SELECT COUNT(*) FROM " . $this->table . " WHERE " . $typeColumn . " = :typeValue";
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute(['typeValue' => $typeValue]);
        } else {
            $sql = "SELECT COUNT(*) FROM " . $this->table;
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute();
        }
        return $queryPrepared->fetchColumn();
    }
}
