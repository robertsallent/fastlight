/*
	Fichero: BigPicture.js
	
	Se usa para agrandar las imágenes al hacerles clic.
	
	Funcionamiento:
	- Incluir este fichero con <script src="/js/BigPicture.js"></script>.
	- Poner imágenes de clase "enlarge-image".
	
	Autor: Robert Sallent
	Última modificación: 23/07/2024	
*/ 

class BigPicture{
	

	constructor(imagen){
		this.imagen = imagen;
	}
	
	// método que crea la nueva figura grande en un modal
	open(){
		let container = document.createElement('div');
		container.className = 'modal';
		container.onclick = function(){ 
			this.remove(); 
		};
		
		let figure  = document.createElement('figure');
		figure.className = 'card';
		
		let image   = document.createElement('img');
		image.src = this.imagen.src;
		image.alt = this.imagen.alt;
		
		let caption = document.createElement('figcaption');
		caption.innerText = this.imagen.alt;

		figure.appendChild(image);
		figure.appendChild(caption);		
		container.appendChild(figure);
		document.body.appendChild(container);
	}
}

// cuando cargue la ventana
window.addEventListener('load', function(){
	
	// recupera todas las imagenes enlarge-image
	let imagenes = document.querySelectorAll('.enlarge-image');
	
	// colocar el listener a cada una de las imagenes
	for(let imagen of imagenes){
		imagen.addEventListener('click', function(){
			let big = new BigPicture(imagen);
			big.open();
		});
	}
});

