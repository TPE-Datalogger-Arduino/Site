<?php
require 'connect.php';

function select($interval, $interval_type)
{
	/*
		renvoie l'ensemble des données entre le temps actuel et un temps donné (par l'intervalle)
	*/
	$db = $GLOBALS['db'];
	//requête à modifier quand humidité implémentée
	$query = $db->prepare('SELECT temps, temperature FROM datalog_meteo WHERE temps BETWEEN DATEADD(-:interval, :interval_type, CURRENT_TIMESTAMP) AND NOW()'); // prépare la requête
	
	$query->execute(array(
		'interval' => $interval,
		'interval_type' => $interval_type)); // donne les valeurs à mettre et exécute la requête
	$response = $query->fetchAll();
	return $response;
}

function afficher_tableau($interval, $interval_type)
{
	/*
		Crée et affiche le tableau
	*/
	?>
	<table>
		<thead>
			<tr>
				<td>Date et Heure</td>
				<td>Température (&deg;C)</td>
				<!--<td>Humidité (%)</td>-->
			</tr>
		</thead>
					
		<tbody>
	<?php
	$meteo = select($interval, $interval_type);
	foreach($meteo as $data)
	{
	$temps = preg_replace('#(\d{4})-(\d{2})-(\d{2}) (\d{2}:\d{2}:\d{2})#','Le $3/$2/$1 à $4', $data['temps']);
	//format de timestamp : YYYY-MM-DD HH:MM:SS
		echo '<tr>';
			echo '<td>'.$temps.'</td>';
			echo '<td>'.$data['temperature'].'</td>';
			//echo '<td>'.$data['humidite'].'</td>';
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
	//requête à modifier quand humidité implémentée
	$query = $db->prepare('INSERT INTO datalog_meteo(temps, temperature) VALUES(?,?)');
	$query->execute(array(
		$data['temps'],
		$data['temperature']));
}
