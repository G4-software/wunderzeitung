<?php
  require_once 'db.php';

  setcookie("wz-user", "", time()-60*60*24); //reset cookies
  setcookie("wz-session", "", time()-60*60*24);
  define(LOGGED_IN, FALSE);

  header("Location: login.html"); //redirect to the login page
?>
