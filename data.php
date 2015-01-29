<?php

$interval = (isset($_GET['interval']))? htmlspecialchars($_GET['interval']) : 10;
$interval_type = (isset($_GET['interval_type']))? htmlspecialchars($_GET['interval_type']) : 'DAY';

afficher_tableau($interval, $interval_type);
?>
