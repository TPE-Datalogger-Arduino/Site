<?php

$title = 'Accueil';

include 'includes/sql.php';
include 'includes/head.php';

$lastData = lastData();

?>
	<header>
			<h1>Bienvenue sur notre site</h1>
	</header>

	<div id="contenu">
		<p>Notre projet a pour but de créer un releveur de données météorologiques qui puisse transmettre les données sur un site Web. Ce site tourne sous nginx avec une base de données MariaDB le tout codé en PHP.</p>

		<p>Vous pouvez lire le dossier <a href="dossier.php">ici</a>.</p>
		
		<h2>Dernier relevé</h2>
		
		<div class="dernier-releve">
			<div class="temps">
				Date
				<span class="valeur"><?php echo $lastData['temps'];?></span>
			</div>

			<div class="temperature">
				Température
				<span class="valeur"><?php echo $lastData['temperature']; ?> &deg;C</span>
			</div>

			<div class="pression">
				Pression
				<span class="valeur"><?php echo $lastData['pression']; ?> hPa</span>
			</div>
		</div>
	</div>
<?php include 'includes/footer.php';
