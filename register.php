<?php
    require_once 'db.php';

    if(count($_POST)<4)
    {
        die("Wrong arguments");
    }

    $data['username'] = $_POST['username']; //get data from the form
    $data['password'] = $_POST['pass'];
    $data['password_confirmation'] = $_POST['pass_conf'];
    $data['name'] = $_POST['name'];

    if($data['password'] != $data['password_confirmation'])
    {
        die("Passwords don't match!");
    }

    $db_query = $db->prepare("SELECT `username` FROM `users` WHERE `username` = :username;");
    $db_query->bindParam(":username", $data['username']);
    $db_query->execute();
    $result = $db_query->fetchColumn();
    if($result == $data['username'])
    {
        header("Location: login.html");
    }

    //insert new user to the database
    $db_query = $db->prepare("INSERT INTO `users` (`id`, `username`, `password_hash`, `name`) VALUES (NULL, :username, :pass_hash, :name);");
    $pass_hash = md5($data['password']);
    $db_query->bindParam(":username", $data['username']);
    $db_query->bindParam(":pass_hash", $pass_hash);
    $db_query->bindParam(":name", $data['name']);
    $db_query->execute();

    header("Location: login.html"); //redirect to the login page
