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
	
}
