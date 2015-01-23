<?php
	require 'sql.php';
	$data = array();



$data['temps'] = (!empty($_GET['temps']))? htmlspecialchars($_GET['temps']) : NULL;
$data['temperature'] = (!empty($_GET['temperature']))? htmlspecialchars($_GET['temperature']) : NULL;
$data['humidite'] = (!empty($_GET['humidite']))? htmlspecialchars($_GET['humidite']) : NULL;


	echo '<pre>';
	print_r($data);
	echo '</pre>';
	
	//insert($data);
?>
