<?php

$title = 'Dossier';

include 'includes/head.php';

?>
	<header>
		<h1>Dossier complet</h1>
	</header>

	<div id="contenu">
		<p>Le dossier a été entièrement rédigé avec LaTeX. Son code est <a href="https://github.com/TPE-Datalogger-Arduino/Dossier">disponible</a> sur notre GitHub.</p>

		<object data="https://cdn.rawgit.com/TPE-Datalogger-Arduino/Dossier/master/Dossier.pdf" type="application/pdf" style="width: 100%; height: 500px">
			Votre navigateur ne gère pas l'affichage du PDF. Essaye de le <a href="https://cdn.rawgit.com/TPE-Datalogger-Arduino/Dossier/master/Dossier.pdf">télécharger</a> sur notre GitHub.
		</object>
	</div>
</section>

<?php include 'includes/footer.php';
