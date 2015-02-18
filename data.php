<?php
include 'sql.php';
include 'head.php';

$limit = (isset($_GET['limit']))? htmlspecialchars($_GET['limit']) : 20;


afficher_tableau($limit);
include 'footer.php';
?>
