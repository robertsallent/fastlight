/*
	Fichero: CodeDisplay.js
	
	Se usa para mostrar el código de los ejemplos de maquetación.

		Autor: Robert Sallent
	Última modificación: 27/06/2025	
*/ 


// función que muestra el código HTML en un contenedor de código
function showCode(codeContainer){
	// escribe en su interior el código de su hermano previo
	let id = codeContainer.dataset.example;
	let text = document.getElementById(id).innerHTML;
	text = text.replace(/</g, "&lt;")
	text = text.replace(/>/g, "&gt;");
	codeContainer.innerHTML = text;
}



window.addEventListener('load', function(){
	// recupera los elementos de clase code-display
	let containers = document.querySelectorAll('.code-display');
	
	// para cada elemento
	for(let container of containers)	
		showCode(container);
});