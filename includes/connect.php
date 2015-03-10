<?php

require 'settings.php';

try
{
	$GLOBALS['db'] = new PDO('mysql:dbname='.BDD.';host='.SERVEUR_BDD, LOGIN, MDP, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
}
catch(PDOException $e)
{
	die('Impossible de se connecter à MySQL : '.$e->getMessage());
}
