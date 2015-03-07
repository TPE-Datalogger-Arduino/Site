<?php
require 'connect.php';


function afficher_tableau($limit)
{
	/*
		Crée et affiche le tableau
	*/
	$db = $GLOBALS['db'];
	?>
	<table>
		<thead>
			<tr>
				<td>Date et Heure</td>
				<td>Température (&deg;C)</td>
				<td>Pression (hPa)</td>
			</tr>
		</thead>
					
		<tbody>
	<?php
	$query = $db->query('SELECT temps, temperature, pression FROM `datalog_meteo` ORDER BY id DESC LIMIT '.$limit);
	$meteo = $query->fetchAll (PDO::FETCH_ASSOC);
	foreach($meteo as $data)
	{
	$temps = preg_replace('#(\d{4})-(\d{2})-(\d{2}) (\d{2}:\d{2}:\d{2})#','Le $3/$2/$1 à $4', $data['temps']);
	//format de timestamp : YYYY-MM-DD HH:MM:SS
		echo '<tr>';
			echo '<td>'.$temps.'</td>';
			echo '<td>'.$data['temperature'].'</td>';
			echo '<td>'.$data['pression'].'</td>';
		echo '</tr>';
	}   
	?>
		</tbody>
	</table>
	<?php
}



function insert($data)
{
	/*
		insère les données de $data dans la table datalog_meteo
	*/
	$db = $GLOBALS['db'];
	$query = $db->prepare('INSERT INTO datalog_meteo(temps, temperature, pression) VALUES(NOW(),?,?)');
	$query->execute(array(
		$data['temperature'],
		$data['pression']));

}

function highchart($limit)
{
	function formatTime($value)
	{
		return preg_replace('#(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})#', 'Date.UTC($1,$2,$3,$4,$5,$6)', $value);
	}
	$db = $GLOBALS['db'];
	$temps = array(); $temperature = array(); $pression = array();
	$query = $db->query("SELECT DATE_SUB(temps, INTERVAL 1 MONTH) AS time, temperature, pression FROM `datalog_meteo` ORDER BY id DESC LIMIT ".$limit);
	$meteo = $query->fetchAll (PDO::FETCH_ASSOC);
	/* Association variables avec les valeurs de la base */
	foreach($meteo as $data)
	{
		$temps[] = $data['time'];
		$temperature[] = $data['temperature'];
		$pression[] = $data['pression'];
	}
	$temps = array_reverse($temps);
	$temperature = array_reverse($temperature);
	$pression = array_reverse($pression);
	$titre = "'Pression et température'";
	$sous_titre = "'20 derniers relevés'";
	$script = "<script>
	$(function () {
		$('#container').highcharts({
			chart: {
				zoomType: 'xy'
			},
			title: {
				text: $titre
			},
			subtitle :{
				text: $sous_titre
			},
			xAxis: [{
				type: 'datetime',
				categories: [";
				for ($i=0; $i <sizeof($temps) ; $i++) { 
					$script .= formatTime($temps[$i]).", ";
				}
				$script .= formatTime(end($temps));
				$script.= "],

				title: {
					text: 'Date'
				},
				labels: {
					formatter: function () {
						return Highcharts.dateFormat('%d/%m/%y %H:%M:%S', this.value);
					}
				}
			}],
			yAxis: [{
				labels: {
					format: '{value}°C',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				title: {
					text: 'Température',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				opposite: true

			}, {
				gridLineWidth: 0,
				title: {
					text: 'Pression',
					style: {
						color: Highcharts.getOptions().colors[0]
					}
				},
				labels: {
					format: '{value}hPa',
					style: {
						color: Highcharts.getOptions().colors[0]
					}
				}
			}],
			tooltip: {
				shared: true
			},
			legend: {
				layout: 'vertical',
				align: 'left',
				x: 80,
				vericalAlign: 'top',
				y: 55,
				floating: true,
				backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
			},
			series: [{
				name: 'Température',
				yAxis: 0,
				tooltip: {
					valueSuffix: ' °C'
				},
				data: [";
			/*for ($i=0; $i < sizeof($temperature); $i++) { 
				$script .= "[".formatTime($temps[$i]).", ".$temperature[$i]."], ";
			}
			$script .= "[".formatTime(end($temps)).", ".end($temperature)."]";*/
			for ($i=0; $i <sizeof($temperature) ; $i++) { 
				$script .= $temperature[$i].", ";
			}
			$script .= end($temperature);
			$script .= "]
			}, {
				name: 'Pression',
				yAxis: 1,
				marker: {
					enabled: false
				},
				dashStyle: 'shortdot',
				tooltip: {
					valueSuffix: ' hPa'
				},
				data: [";
			/*for ($i=0; $i < sizeof($pression); $i++) { 
				$script .= "[".formatTime($temps[$i]).", ".$pression[$i]."], ";
			}
			$script .= end($pression);*/
			for ($i=0; $i <sizeof($pression) ; $i++) { 
				$script .= $pression[$i].", ";
			}
			$script .= end($pression);
			$script .= "]
			}]
		});
	});
	</script>";
echo $script;

}
