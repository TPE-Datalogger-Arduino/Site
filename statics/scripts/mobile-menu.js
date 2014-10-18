/* Script pour afficher le menu mobile */
window.onload=function() {
	var bouton = document.getElementById('bouton');
	var nav = document.getElementById('navigation');
	bouton.onclick = function(e) {nav.className == "affiche" ? nav.removeAttribute("class") : nav.className = "affiche"};
};