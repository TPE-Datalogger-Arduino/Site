<?php

require 'connect.php'; // Inclusion du fichier pour la connexion à la base

/* Fonction qui crée et affiche le tableau
   - $limit le nombre de donneés que le tableau doit afficher */
function table($limit)
{
	$db = $GLOBALS['db'];
?>
	<table>
		<thead>
			<tr>
				<td>Date et heure</td>
				<td>Température (&deg;C)</td>
				<td>Pression (hPa)</td>
			</tr>
		</thead>
		<tbody>
<?php
	$query = $db->query('SELECT temps, temperature, pression FROM `datalog_meteo` ORDER BY id DESC LIMIT '.$limit); // Requête SQL avec LIMIT
	$meteo = $query->fetchAll(PDO::FETCH_ASSOC);

	foreach($meteo as $data) // Parcours des données
	{
		$temps = preg_replace('#(\d{4})-(\d{2})-(\d{2}) (\d{2}:\d{2}:\d{2})#', '$3/$2/$1 à $4', $data['temps']); // Conversion du temps
		/* Nombre décimal avec une virgule */
		$temperature = preg_replace('/\./', ',', $data['temperature']);
		$pression = preg_replace('/\./', ',', $data['pression']);

		/* Affichage des donneés : création d'une ligne */
		echo '<tr>';
			echo '<td>'.$temps.'</td>';
			echo '<td>'.$temperature.'</td>';
			echo '<td>'.$pression.'</td>';
		echo "</tr>\r\n";
	}
?>
		</tbody>
	</table>
<?php
}

/* Fonction qui retourne la dernière valeur */
function lastData()
{
	$db = $GLOBALS['db'];

	$query = $db->query('SELECT * FROM `datalog_meteo` ORDER BY id DESC LIMIT 1');
	$meteo = $query->fetch(PDO::FETCH_ASSOC);

	return array(
		'temps' => preg_replace('#(\d{4})-(\d{2})-(\d{2}) (\d{2}:\d{2}:\d{2})#', '$3/$2/$1<br>$4', $meteo['temps']),
		'temperature' => preg_replace('/\./', ',', $meteo['temperature']),
		'pression' => preg_replace('/\./', ',', $meteo['pression'])
	);
}

/* Fonction qui exporte les données au format CSV
   - $limit le nombre de donneés que le tableau doit afficher */
function exportCSV($limit)
{
	$db = $GLOBALS['db'];

	$query = $db->query('SELECT * FROM (SELECT id, temps, temperature, pression FROM `datalog_meteo` ORDER BY id DESC LIMIT '.$limit.') AS sq ORDER BY id ASC'); // Requête SQL
	$meteo = $query->fetchAll(PDO::FETCH_ASSOC);

	/* Type du fichier */
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Donnees.csv');

	echo "Temps;Température;Pression\r\n";

	foreach($meteo as $data) // Parcours des données
	{
		$temps = preg_replace('#(\d{4})-(\d{2})-(\d{2}) (\d{2}:\d{2}:\d{2})#', '$3/$2/$1 $4', $data['temps']);
		$temperature = preg_replace('/\./', ',', $data['temperature']);
		$pression = preg_replace('/\./', ',', $data['pression']);

		echo $temps.";".$temperature.";".$pression."\r\n"; // Affichage des données
	}

	echo "\r\n";
}

/* Insère les données $data dans la table datalog_meteo */
function insert($data)
{
	$db = $GLOBALS['db'];
	$query = $db->prepare('INSERT INTO datalog_meteo(temps, temperature, pression) VALUES(NOW(), ?, ?)');
	$query->execute(array(
		$data['temperature'],
		$data['pression']
	));
}

/* Fonction qui génère le script pour le graphique */
function chart($limit)
{
	/* Pour convertir le temps */
	function formatTime($value)
	{
		return preg_replace('#(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})#', 'Date.UTC($1, $2, $3, $4, $5, $6)', $value);
	}

	$db = $GLOBALS['db'];
	$temps = array();
	$temperature = array();
	$pression = array();

	$query = $db->query('SELECT * FROM (SELECT id, temps, temperature, pression FROM `datalog_meteo` ORDER BY id DESC LIMIT '.$limit.') AS sq ORDER BY id ASC'); // Requête SQL
	$meteo = $query->fetchAll (PDO::FETCH_ASSOC);

	/* Association des variables avec les valeurs de la base */
	foreach($meteo as $data)
	{
		$temps[] = $data['temps'];
		$temperature[] = $data['temperature'];
		$pression[] = $data['pression'];
	}

	$max = sizeof($temps);
?>
	<script>
		$(function () {
			Highcharts.setOptions({
				lang: {
					decimalPoint: ',' // Nombre décimal avec une virgule
				}
			});
			$('#graphique').highcharts({
				chart: { // Style du graphique
					zoomType: 'xy',
					backgroundColor: '#fcfcfc',
					style: {
						font: 'inherit'
					}
				},
				title: { // Titre
					text: 'Données météorologiques'
				},
				xAxis: { // Abscisses
					categories: [
						<?php
						for ($i = 0 ; $i < $max ; $i++)
						{
							echo formatTime($temps[$i]).", ";
						}
						echo formatTime(end($temps));
						?>
					],
					title: {
						text: 'Date'
					},
					type: 'datetime',
					labels: {
						formatter: function() {
							return Highcharts.dateFormat('%d/%m/%Y à %H:%M:%S', this.value);
						}
					}
				},
				yAxis: [ // Ordonnées
					{ // Températures
						labels: {
							style: {
								color: Highcharts.getOptions().colors[0]
							}
						},
						title: {
							text: 'Température (\u00B0C)',
							style: {
								color: Highcharts.getOptions().colors[0]
							}
						},
						opposite: true
					}, { // Pressions
						gridLineWidth: 0,
						title: {
							text: 'Pression (hPa)',
							style: {
								color: Highcharts.getOptions().colors[1]
							}
						},
						labels: {
							style: {
								color: Highcharts.getOptions().colors[1]
							}
						}
					}
				],
				tooltip: { // Boîte pour voir les informations
					shared: true,
					formatter: function() {
						return Highcharts.dateFormat('%d/%m/%Y à %H:%M:%S', this.x) + '<br>' +
							'<span style="color: ' + Highcharts.getOptions().colors[0] + '">\u25CF</span> Température : ' + this.points[0].y + ' \u00B0C<br>' +
							'<span style="color: ' + Highcharts.getOptions().colors[1] + '">\u25C6</span> Pression : ' + this.points[1].y + ' hPa';
					},
					style: {
						fontSize: '10pt'
					}
				},
				legend: {
					enabled: false
				},
				series: [ // Données
					{ // Températures
						name: 'Température',
						yAxis: 0,
						data: [
							<?php
							for ($i = 0 ; $i < $max ; $i++)
							{
								echo $temperature[$i].", ";
							}
							echo end($temperature);
							?>
						]
					}, { // Pressions
						name: 'Pression',
						yAxis: 1,
						marker: {
							enabled: false
						},
						dashStyle: 'shortdot',
						data: [
							<?php
							for ($i = 0 ; $i < $max ; $i++)
							{
								echo $pression[$i].", ";
							}
							echo end($pression);
							?>
						]
					}
				]
			});
		});
	</script>
<?php
}
