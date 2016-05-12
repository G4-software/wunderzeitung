<?php
    define('DB_HOST', 'localhost');

    define('DB_USERNAME', 'php');
    define('DB_PASSWORD', '123');

    define('DB_NAME', 'php');

    try
    {
        $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
    }
    catch (PDOException $e)
    {
        echo "<p>DB access malfunction: " . $e->getMessage() . "</p>";
        die();
    }
