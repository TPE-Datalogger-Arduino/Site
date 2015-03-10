<?php

$title = 'Graphique';

include 'includes/sql.php';
include 'includes/head.php';

/* Valeur limite passé dans l'URL ; si elle est négative ou n'existe pas, on la met à 20 */
$limit = isset($_GET['limite']) && $_GET['limite'] > 0 ? htmlspecialchars($_GET['limite']) : 20;

?>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/highcharts/4.1.3/highcharts.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/highcharts/4.1.3/modules/exporting.js"></script>
	<?php // Insertion du script pour le graphique
	chart($limit); ?>

	<header>
		<h1>Graphique des <?php echo $limit; ?> derniers relevés</h1>
	</header>

	<div id="contenu">
		<!-- Formulaire pour le nombre de relevé à afficher -->
		<form method="get" action="graphique.php">
			Quantité de données : <input type="number" name="limite" value="<?php echo $limit; ?>" pattern="\d+">
			<button type="submit">Go !</button>
		</form>

		<div id="graphique"></div>
	</div>
<?php include 'includes/footer.php';
