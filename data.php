<?php

$interval = (!empty($_GET['interval']))? htmlspecialchars($_GET['interval']) : 10;
$interval_type = (!empty($_GET['interval_type']))? htmlspecialchars($_GET['interval_type']) : 'DAY';

afficher_tableau($interval, $interval_type);
?>
