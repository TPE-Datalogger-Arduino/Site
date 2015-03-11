<?php

$title = 'Tableau';

include 'includes/sql.php';
include 'includes/head.php';

/* Valeur limite passée dans l'URL ; si elle est négative ou n'existe pas, on la met à 20 */
$limit = isset($_GET['limite']) && $_GET['limite'] > 0 ? htmlspecialchars($_GET['limite']) : 20;

?>
	<header>
		<h1>Tableau des <?php echo $limit; ?> derniers relevés</h1>
	</header>

	<div id="contenu">
		<!-- Formulaire pour le nombre de relevés à afficher -->
		<form method="get" action="donnees.php">
			Quantité de données : <input type="number" name="limite" value="<?php echo $limit; ?>" pattern="\d+">
			<button type="submit">Go !</button>
		</form>

		<!-- Formulaire pour exporter au format CSV -->
		<form method="get" action="exporter-csv.php">
			Vous pouvez également exporter les données au format CSV pour les traiter dans un tableur. <input type="number" name="limite" value="<?php echo $limit; ?>" pattern="\d+">
			<button type="submit">Exporter</button>
		</form>

		<?php // Affichage du tableau
		table($limit); ?>
	</div>
<?php include 'includes/footer.php';
