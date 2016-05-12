<?php
	require_once 'vendor/autoload.php';
	require_once 'db.php';
	require_once 'check_login.php';

	Twig_Autoloader::register();

	$loader = new Twig_Loader_Filesystem('templates');
	$twig = new Twig_Environment($loader);

	$template = $twig->loadTemplate('index.html');

	$result = $db->prepare("SELECT `username` FROM `users` "); //get all usernames
	$result->execute();
	if($result->rowCount() > 0)
	{
		while($res = $result->fetch(PDO::FETCH_BOTH))
		{
        $users[$res['username']] = $res['username'];
  	}
	}

	$username = (LOGGED_IN) ? USERNAME : '';

	echo $template->render(array(	'title' => "Домашняя страница | Wunderzeitung",
																'logged_in' => LOGGED_IN,
																'username' => $username,
																'users' => $users,
																'numOfUsers' => count($users)));
