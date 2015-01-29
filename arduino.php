<?php
require 'sql.php';
$data = array();


/*
if(isset($_GET['']))
{
$data[''] = $_GET[''];
}
else
{
$data[''] = NULL;
}
*/
if(isset($_GET['pass']) && $_GET['pass'] == '123')
{
	$data['temps'] = (isset($_GET['temps']))? htmlspecialchars($_GET['temps']) : NULL;
	$data['temperature'] = (isset($_GET['temperature']))? htmlspecialchars($_GET['temperature']) : NULL;
	$data['pression'] = (isset($_GET['pression']))? htmlspecialchars($_GET['pression']) : NULL;
}
else
{
	header('Location: index2.php');
}
echo '<pre>';
print_r($data);
echo '</pre>';
	
//insert($data);
?>
