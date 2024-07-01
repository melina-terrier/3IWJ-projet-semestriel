<?php
namespace App\Core;
use PDO;
class SQL
{
    private $pdo;
    private $table;

    public function __construct()
    {
        if (file_exists('../config.php')){
            require_once '../config.php';
            $dbHost = DB_HOST;
            $dbName = DB_NAME;
            $dbUser = DB_USER;
            $dbPassword = DB_PASSWORD;
            $dbport = DB_PORT;
            $tablePrefix = TABLE_PREFIX;
            try{
                $this->pdo = new PDO('pgsql:host='.$dbHost.';dbname='.$dbName.';port='.$dbport,$dbUser,$dbPassword);
            }catch (\Exception $e){
                die('Erreur SQL : '.$e->getMessage());
            }
            $classChild = get_called_class();
            $this->table = $tablePrefix.'_'.strtolower(str_replace('App\\Models\\','',$classChild));
        }
    }

    public function save()
    {
        $columnsAll = get_object_vars($this);
        $columnsToDelete = get_class_vars(get_class());
        $columns = array_diff_key($columnsAll, $columnsToDelete);
        if( empty($this->getId()) ) {
            unset($columns['id']);
            $sql = 'INSERT INTO '.$this->table. ' ('. implode(', ', array_keys($columns) ) .')  
            VALUES (:'. implode(',:', array_keys($columns) ) .')';
        }else{
            $isUpdate = true;
            foreach ( $columns as $column=>$value){
                $sqlUpdate[] = $column.'=:'.$column;
            }
            $sql = 'UPDATE ' . $this->table . ' SET ' . implode(', ', $sqlUpdate) . ' WHERE id=' . $this->getId();
        }
        $queryPrepared = $this->pdo->prepare($sql);
        foreach ($columns as $key => $value) {
            $type = is_bool($value) ? \PDO::PARAM_BOOL : (is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
            $queryPrepared->bindValue(':'.$key, $value, $type);
        }
        $queryPrepared->execute($columns); 
        if (isset($isUpdate)) {
            return $this->getId();
        }
        return $this->pdo->lastInsertId();
    }

    public function isUnique(array $data): bool {
        $sql = 'SELECT COUNT(*) FROM ' . $this->table . ' WHERE'; 
        foreach ($data as $column => $value) {
            $sql .= ' '.$column.'=:'.$column. ' AND';
        }
        $sql = substr($sql, 0, -3);
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($data);
        $number = $queryPrepared->fetchColumn();
        return $number > 0;
    }

    public function checkUserCredentials(string $email, string $password): ?object
    {
        $user = $this->getOneBy(['email' => $email], 'object');
        if ($user && password_verify($password, $user->getPassword())) {
            return $user;
        }
        return null;
    }

    public function getOneBy(array $data, string $return = 'array')
    {
        $sql = 'SELECT * FROM '.$this->table. ' WHERE ';
        foreach ($data as $column => $value) {
            $sql .= ' '.$column.'=:'.$column. ' AND';
        }
        $sql = substr($sql, 0, -3);
        $queryPrepared = $this->pdo->prepare($sql); 
        $queryPrepared->execute($data);
        if($return == 'object') {
            $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        } else {
            $queryPrepared->setFetchMode(\PDO::FETCH_ASSOC);
        }
        return $queryPrepared->fetch();
    }

    public function populate(int $id, string $return = 'object' )
    {
        $class = get_called_class();
        $object = new $class();
        if($return == 'object') {
            return $object->getOneBy(['id'=>$id], 'object');

        } else {
            return $object->getOneBy(['id'=>$id], 'array');
        }
    }

    public function getAllData(array $where = null, array $groupBy = null, string $return = 'array')
    {
        $sql = 'SELECT '; 
        if ($groupBy){
            $sql .= $groupBy['condition']; 
        } else {
            $sql .= '*'; 
        }
        $sql .= ' FROM ' . $this->table;
        if ($where) {
            $sql .= ' WHERE ';
            $conditions = []; 
            foreach ($where as $column => $value) {
              $conditions[] = $column.' = :'.$column;
            }
            $whereString = implode(' AND ', $conditions);
            $sql .= $whereString;
        }
        if ($groupBy){
            $sql .= ' GROUP BY ' . $groupBy['name'];
            $sql .= ' ORDER BY ' . $groupBy['name'] .' ASC';
        }
        $queryPrepared = $this->pdo->prepare($sql);
        if ($where) {
            $parameters = array_combine(array_keys($where), array_values($where)); // Assuming $where is an associative array
            $queryPrepared->execute($parameters);
        } else {
            $queryPrepared->execute();
        }
        if($return == 'object') {
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
        $sql = 'DELETE FROM ' . $this->table . ' WHERE ';
        foreach ($data as $column => $value) {
            $sql .= ' ' . $column . '=:' . $column . ' AND';
        }
        $sql = substr($sql, 0, -3);
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($data);
        return $queryPrepared->rowCount() > 0;
    }

    public function countElements($typeColumn = null, $typeValue = null): int {
        if ($typeColumn && $typeValue) {
            $sql = 'SELECT COUNT(*) FROM ' . $this->table . ' WHERE ' . $typeColumn . ' = :typeValue';
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute(['typeValue' => $typeValue]);
        } else {
            $sql = 'SELECT COUNT(*) FROM ' . $this->table;
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute();
        }
        return $queryPrepared->fetchColumn();
    }

    public function search(array $where = null, string $return = 'array') {
        $sql = 'SELECT * FROM ' . $this->table;
        if ($where) {
            $sql .= ' WHERE ';
            $conditions = []; 
            foreach ($where as $column => $value) {
                $conditions[] = $column.' ILIKE :'.$column;
            }
            $whereString = implode(' OR ', $conditions);
            $sql .= $whereString;
        }
        $queryPrepared = $this->pdo->prepare($sql);
        if ($where) {
            $parameters = array_combine(array_keys($where), array_values($where));
            $queryPrepared->execute($parameters);
        } else {
            $queryPrepared->execute();
        }
        if ($return == 'object') {
            $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        } else {
            $queryPrepared->setFetchMode(\PDO::FETCH_ASSOC);
        }
        return $queryPrepared->fetchAll();
    }
}