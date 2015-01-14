<?php
require 'connect.php';

function select($interval, $interval_type)
{
	/*
		renvoie l'ensemble des données entre le temps actuel et un temps donné (par l'intervalle)
	*/
	$query = $db->prepare('SELECT temps, temperature, humidite FROM datalog_meteo WHERE temps BETWEEN DATEADD(-:interval, :interval_type, CURRENT_TIMESTAMP) AND CURRENT_TIMESTAMP');// prépare la requête
	
	$response = $query->execute(array(
			'interval' => $interval,
			'interval_type' => $interval_type)); // donne les valeurs à mettre et exécute la requête
return $response;
}

function afficher_tableau($interval, $interval_type)
{
	/*
		Crée et affiche le tableau
	*/
	echo '<table>
			<thead>
				<tr>
					<td>Date et Heure</td>
					<td>Température (&deg;C)</td>
					<td>Humidité (%)</td>
				</tr>
			</thead>
					
			<tbody>';
	$meteo = select($interval, $interval_type);
	while($data = $meteo->fetch())
	{
	//$temps = preg_replace('#(\d{4})-(\d{2})-(\d{2}) (\d{2}:\d{2}:\d{2})#','Le $3/$2/$1 à $4', $data['temps']);
	//$temps = preg_replace('#(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})#','Le $3/$2/$1 à $4:$5:$6', $data['temps']);
	//à choisir en fonction du format de TIMESTAMP
		echo '<tr>';
			echo '<td>'.$data['temps'].'</td>';
			//$temps au lieu de $data['temps'] ?
			echo '<td>'.$data['temperature'].'</td>';
			echo '<td>'.$data['humidite'].'</td>';
		echo '</tr>';
	}	
	echo '</tbody>
	</table>';
}

function insert($data)
{
	/*
		insère les données de $data dans la table datalog_meteo
	*/
	if(empty($data['temps']))
	{
		$data['temps'] = 'CURRENT_TIMESTAMP'; // Si $data['temps'] est vide, on remplace par la valeur actuelle
	}

	$query = $db->prepare('INSERT INTO datalog_meteo(temps, temperature, humidite) VALUES(?,?,?)');
	$query->execute(array(
		$data['temps'],
		$data['temperature'],
		$data['humidite']));
}
