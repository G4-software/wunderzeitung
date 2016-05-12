<?php
    require_once 'db.php';
    require_once 'check_login.php';

    if(LOGGED_IN)
    {
        header("Location: account.php"); //redirect to the account page
    }
    else
    {
        header("Location: login.html"); //redirect to the login page
    }

    $data['username'] = $_POST['username']; //get data from the form
    $data['password'] = $_POST['pass'];

    $db_query = $db->prepare("SELECT `username` FROM `users` WHERE `username` = :username;"); //get username from database
    $db_query->bindParam(":username", $data['username']);
    $db_query->execute();
    $usrName = $db_query->fetchColumn();

    if($usrName == $data['username']) //check the username
    {
        $password_hash = md5($data['password']); //get password from database
        $db_query = $db->prepare("SELECT `password_hash` FROM `users` WHERE `password_hash` = :password_hash;");
        $db_query->bindParam(":password_hash", $password_hash);
        $db_query->execute();
        $usrPassword = $db_query->fetchColumn();

        if($usrPassword == $password_hash) //check the password
        {
            $login_time = time(); //get current time
            $session_hash = md5($login_time.rand(0, $login_time)); //generating hash of current session

            //insert hash to the database
            $db_query = $db->prepare("UPDATE `users` SET `last_session_hash` = :session_hash WHERE `users`.`username` = :username");
            $db_query->bindParam(":session_hash", $session_hash);
            $db_query->bindParam(":username", $usrName);
            $db_query->execute();

            //set the cookies
            setcookie("wz-user", $usrName, $login_time+60*60*24);
            setcookie("wz-session", $session_hash, $login_time+60*60*24);

            //insert time of begin of current session to the database
            $db_query = $db->prepare("UPDATE `users` SET `last_login_time` = :last_login_time WHERE `users`.`username` = :username");
            $db_query->bindParam(":last_login_time", $login_time);
            $db_query->bindParam(":username", $usrName);
            $db_query->execute();

            header("Location: account.php"); //redirect to the account page
        }
        else die("Wrong password!");
    }
    else die("Wrong username!");
