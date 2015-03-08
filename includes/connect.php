<?php

require 'settings.php';

try
{
	$dsnhost = 'mysql:dbname='.BDD.';host='.SERVEUR_BDD;
	$user = LOGIN;
	$pass = MDP;
	$GLOBALS['db'] = new PDO($dsnhost, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
}
catch(PDOException $e)
{
	die('Impossible de se connecter à MySQL : '.$e->getMessage());
}
