<?php
require 'settings.php';
try
{
	$dsnhost = 'mysql:dbname='.BDD.';host='.SERVEUR_BDD;
	$user = LOGIN;
	$pass = MDP;
	$db = new PDO($dsnhost, $user, $pass);
	echo 'Successfully logged in !';
}
catch(PDOException $e)
{
	die('Could not connect to MySQL :' .$e->getMessage());
}
