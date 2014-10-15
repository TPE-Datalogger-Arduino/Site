/* Script pour afficher le menu mobile */
window.onload=function() {
	var bouton = document.getElementById('bouton');
	var nav = document.getElementById('navigation');
	bouton.onclick = function(e) {
		if (nav.style.display == "block") {
			nav.style.display = "none";
		} else {
			nav.style.display = "block";
		}
	};
};