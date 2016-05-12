<?php
  require_once 'db.php';

  if(isset($_COOKIE['wz-user']) && isset($_COOKIE['wz-session']))
  {
    $username = $_COOKIE['wz-user']; //get data from cookie
    $session = $_COOKIE['wz-session'];

    //get data from database
    $db_query = $db->prepare("SELECT `id`, `last_session_hash`, `name` FROM `users` WHERE `username` = :username");
    $db_query->bindParam(":username", $username);
    $db_query->execute();
    $result = $db_query->fetch(PDO::FETCH_ASSOC);

    if($result['last_session_hash'] != $session) //expired cookies
    {
      setcookie("wz-user", "", time()-60*60*24);
      setcookie("wz-session", "", time()-60*60*24);
      define("LOGGED_IN", FALSE);

      print_r($result);
    }
    else //fresh cookies or already logged in
    {
      define("LOGGED_IN", TRUE);
      define("USER_ID", $result['id']);
      define("USERNAME", $username);
      define("SHOWN_USERNAME", $result['name']);

      $user['logged_in'] = 1;
      $user['name'] = SHOWN_USERNAME;
    }
  }
  else
  {
    define("LOGGED_IN", FALSE);
  }
?>
