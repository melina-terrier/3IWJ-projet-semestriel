<?php

try {
    $pdo = new PDO("pgsql:host=postgres;dbname=esgi;port=5432", "esgi", "esgipwd");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer chaque utilisateur avec le nombre de projets réalisés
    $sql_users_projects = "
        SELECT u.firstname, u.lastname, COUNT(p.id) AS project_count
        FROM msnu_user u   
        LEFT JOIN msnu_project p ON u.id = p.id
        GROUP BY u.firstname, u.lastname
        ORDER BY project_count DESC;
    ";

    
?>




