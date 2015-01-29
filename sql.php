<?php
require 'connect.php';


function afficher_tableau($interval, $interval_type)
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
	$query = $db->query('SELECT * FROM datalog_meteo WHERE temps BETWEEN DATE_SUB(NOW(), INTERVAL '.$interval.' '.$interval_type.') AND NOW()');
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
	if(empty($data['temps']))
	{
		$data['temps'] = 'CURRENT_TIMESTAMP'; // Si $data['temps'] est vide, on remplace par la valeur actuelle
	}
	$query = $db->prepare('INSERT INTO datalog_meteo(temps, temperature, pression) VALUES(?,?,?)');
	$query->execute(array(
		$data['temps'],
		$data['temperature'],
		$data['pression']));
}
