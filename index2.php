<?php
require 'sql.php';
require 'head.php';


if(isset($_GET['page']) && !empty($_GET['page']))
{
	$page = htmlspecialchars($_GET['page']);

	switch($page)
	{
		case $page == 'data';
		include 'data.php';
		break;

		/*case $page == 'graphique';
		include 'graphique.php';
		break;*/

		default:
		include 'about.php';
		break;
	}
}
else
{
	include 'about.php';
}


require 'footer.php';

?>
