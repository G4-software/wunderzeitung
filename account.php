<?php
	require_once 'vendor/autoload.php';
	require_once 'db.php';
  require_once 'check_login.php';

	Twig_Autoloader::register();

	$loader = new Twig_Loader_Filesystem('templates');
	$twig = new Twig_Environment($loader);

	$template = $twig->loadTemplate('account.html');

  if(LOGGED_IN)
  {
    $username = USERNAME;
    echo $template->render(array(	'title' => "$username | Wunderzeitung",
																	'logged_in' => LOGGED_IN,
																	'username' => $username,
																	'name' => SHOWN_USERNAME));
  }
  else
  {
    header("Location: login.html"); //redirect to the login page
  }
?>
