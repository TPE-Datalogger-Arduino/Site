<?php
require 'sql.php';
//require 'head.php';


if(!empty($_GET['page']))
{
	$page = htmlspecialchars($_GET['page']);

	switch($page)
	{
		case $page == 'data';
		include 'data.php';
		break;

		case $page == 'graphique';
		include 'graphique.php';
		break;

		default:
		include 'about.php';
		break;
	}
}


require 'footer.php';

?>
