<?php
namespace App\Core;
use PDO;

// require __DIR__ . '/../config.php';
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
        // Vous ne devez pas écrire en dur le nom de la table ou des colonnes à insérer en BDD
        $columnsAll = get_object_vars($this);
        $columnsToDelete = get_class_vars(get_class());
        $columns = array_diff_key($columnsAll, $columnsToDelete);

        if( empty($this->getId()) ) {
            unset($columns['id']);
            $sql = "INSERT INTO ".$this->table. " (". implode(', ', array_keys($columns) ) .")  
            VALUES (:". implode(',:', array_keys($columns) ) .")";
        }else{
            $isUpdate = true;
            //UPDATE esgi_user SET firstname=:firstname, lastname=:lastname WHERE id=1
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
        $queryPrepared->execute($columns); //pour exécuter la requête
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
        return $queryPrepared->fetch(); // pour récupérer le résultat de la requête (un seul enregistrement)
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
            // les resultats seront sous forme d'objet de la classe appelée
            $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        } else {
            // pour récupérer un tableau associatif
            $queryPrepared->setFetchMode(\PDO::FETCH_ASSOC);
        }

        return $queryPrepared->fetchAll();
    }

    public function getDataObject(): array //pour récupérer les données de l'objet
    {
        return array_diff_key(get_object_vars($this), get_class_vars(get_class())); //mettre dans un tableau les données de l'objet
    }

    public function setDataFromArray(array $data): void //pour mettre à jour les données de l'objet
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getDataId($value) {
        $sql = "SELECT id FROM msnu_status WHERE status= :status LIMIT 1";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->bindValue(':status', $value, PDO::PARAM_STR);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['id'];
        }
        return null;
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
