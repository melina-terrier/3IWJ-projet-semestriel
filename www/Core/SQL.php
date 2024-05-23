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
            $this->pdo = new PDO("mysql:host=postgres;dbname=esgi;port=5432","esgi","esgipwd");
        }catch (\Exception $e){
            die("Erreur SQL : ".$e->getMessage());
        }

        $classChild = get_called_class();
        $this->table = "pro_".strtolower(str_replace("App\\Models\\","",$classChild));
    }

    public function save()
    {
        //Vous ne devez ecrire en dure le nom de la table ou des colonnes à inserer en bdd
        $columnsAll = get_object_vars($this);
        $columnsToDelete = get_class_vars(get_class());
        $columns = array_diff_key($columnsAll, $columnsToDelete);

        if( empty($this->getId()) ) {
            $sql = "INSERT INTO ".$this->table. " (". implode(', ', array_keys($columns) ) .")  
        VALUES (:". implode(',:', array_keys($columns) ) .")";
        }else{

            //UPDATE esgi_user SET firstname=:firstname, lastname=:lastname WHERE id=1
            foreach ( $columns as $column=>$value){
                $sqlUpdate[] = $column."=:".$column;
            }

            $sql = "UPDATE ".$this->table. " SET ".implode(',', $sqlUpdate). " WHERE id=".$this->getId();
        }
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($columns);

    }

    public function search() {
        $sql = "SELECT id, name, first_name FROM pro_user WHERE email = ':email'";
        $queryPrepared = $this->pdo->prepare($sql);
        $stmt->bind_param(':email', $user_mail);
        $queryPrepared->execute();
        $queryPrepared->bind_result($userId, $userName, $userFirstName);
        $_SESSION["user_id"] = $userId;
        $_SESSION["user_name"] = $userName;
        $_SESSION["user_firstname"] = $userFirstName;
    }

}