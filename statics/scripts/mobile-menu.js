window.onload = function () {
	"use strict";

	var bouton = document.getElementById("bouton"),
	    nav = document.getElementById("navigation");

	bouton.onclick = function () {
		if (nav.className === "affiche") {
			nav.removeAttribute("class");
		} else {
			nav.className = "affiche";
		}
	};
};
