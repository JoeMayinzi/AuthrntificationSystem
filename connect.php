<?php
    $host = 'localhost';
    $dbname = 'tutos-php';
    $user = 'root';
    $pass = '';

    $dsn = "mysql:host=$host;dbname=$dbname;";

    try {
        $dataBase = new PDO($dsn, $user, $pass);
    } catch(PDOException $e) {
        echo "Erreur". $e->getMessage();
    }