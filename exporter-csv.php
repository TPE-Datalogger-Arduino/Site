<?php

$title = 'Graphique';

include 'includes/sql.php';

$limit = isset($_GET['limite']) && $_GET['limite'] > 0 ? htmlspecialchars($_GET['limite']) : 20;

exportCSV($limit);
