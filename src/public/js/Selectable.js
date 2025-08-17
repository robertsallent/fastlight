/*
	Fichero: Selectable.js
	
	Se usa para seleccionar o quitar la selección de elementos HTML.
	
	Funcionamiento:
	- Incluir este fichero.
	- Poner imágenes de clase "selectable".
	
	Autor: Robert Sallent
	Última modificación: 26/06/2025	
*/ 


// cuando cargue la ventana
window.addEventListener('load', function(){
	
	// recupera todos los elementos seleccionables
	let seleccionables = document.querySelectorAll('.selectable');
	
	// colocar el listener a cada uno
	for(let elemento of seleccionables){
		elemento.addEventListener('click', function(){
			elemento.classList.toggle('selected');
		});
	}
});

