<?php

/* Inclure l'en-t^ete */
function getEnTete() {
	include("/statiques/inclusions/en-tete.php");
}

/* Inclure le début de la page */
function getDebut() {
	include("/statiques/inclusions/debut-page.php");
}

/* Inclure la fin de la page */
function getFin() {
	include("/statiques/inclusions/fin-page.php");
}

/* Ajoute le titre */
function titre($titre) {
	echo("<header><h1>".$titre."</h1></header>");
}

?>