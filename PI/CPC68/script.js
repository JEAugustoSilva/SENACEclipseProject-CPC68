document.getElementById("btSideNav").addEventListener("click", menuAbrirFechar);

var menuStado = 0;
function menuAbrirFechar() {

	if (menuStado === 0) { /* Se o menu estiver fechado */
		menuStado = 1;
		document.getElementById('sideMenu').style.width = '225px';
		document.getElementById('main').style.marginLeft = '225px';
		this.classList.add("active");
	} else { /* Se não vai estar aberto */
		menuStado = 0;
		document.getElementById('sideMenu').style.width = '0';
		document.getElementById('main').style.marginLeft = '0';
		this.classList.remove("active");
	}
	console.log(menuStado);
}

// function para fechar o menu quando clicar em #main
document.getElementById("main").addEventListener("click", menuFechar);
document.getElementById("footer").addEventListener("click", menuFechar);
function menuFechar() {
	if (menuStado === 1) {
		menuStado = 0;
		document.getElementById('sideMenu').style.width = '0';
		document.getElementById('main').style.marginLeft = '0';
		document.getElementById("btSideNav").classList.remove("active");
	}
}

// Criando Dropdown menus dentro do Side Menu
var dropdown = document.getElementsByClassName("btDropdown");
var i;

for (i = 0; i < dropdown.length; i++) {
	dropdown[i].addEventListener("click", function() {
		this.classList.toggle("active");
		var dropdownContent = this.nextElementSibling;
		if (dropdownContent.style.display === "block") {
			dropdownContent.style.display = "none";
		} else {
			dropdownContent.style.display = "block";
		}
	});
}

// Mascara de telefone
function mascara(o, f) {
	v_obj = o
	v_fun = f
	setTimeout("execmascara()", 1)
}
function execmascara() {
	v_obj.value = v_fun(v_obj.value)
}
function mtel(v) {
	v = v.replace(/\D/g, ""); // Remove tudo o que não é dígito
	v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); // Coloca parênteses em volta dos dois primeiros dígitos
	v = v.replace(/(\d)(\d{4})$/, "$1-$2"); // Coloca hífen entre o quarto e o quinto dígitos
	return v;
}
function id(el) {
	return document.getElementById(el);
}
window.onload = function() {
	id('telefone').onkeyup = function() {
		mascara(this, mtel);
	}
}

// LINK NA <tr> TODA

jQuery(document).ready(function($) {
    $(".trLink").click(function() {
        window.location = $(this).data("href");
    });
});