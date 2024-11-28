/*
	Fichero: BigPicture.js
	
	Se usa para agrandar las imágenes al hacerles clic.
	
	Funcionamiento:
	- Incluir este fichero con <script src="/js/BigPicture.js"></script>.
	- Poner imágenes de clase "enlarge-image".
	
	Autor: Robert Sallent
	Última modificación: 28/11/2024	
*/ 

class BigPicture{
	
	constructor(imagen){
		this.imagen = imagen;
	}
	
	// método que crea la nueva figura grande en un modal
	open(){
		
		// preparación del contenedor externo
		let container = document.createElement('div');
		container.className = 'modal';
		container.onclick = function(){ 
			this.remove(); 
		};
		
		// preparación de la figura interna
		let figure  = document.createElement('figure');
		figure.className = 'card';
		
		// preparación de la imagen dentro de la figura
		let image   = document.createElement('img');
		image.src = this.imagen.src;
		image.alt = this.imagen.alt;
		
		// usa el texto alternativo de la imagen en la figcaption
		let caption = document.createElement('figcaption');
		caption.innerText = this.imagen.alt;
		
		// coloca las cosas en la figura
		figure.appendChild(image);
		figure.appendChild(caption);	
		
		// si existe la propiedad data-description...
		if(this.imagen.dataset.description != undefined){
			
			// crea un párrafo con la descripción
			let p   = document.createElement('p');
			p.innerText = this.imagen.dataset.description;
			figure.appendChild(p);
		}else
			image.classList.add('no-description');
			
		// coloca la figura y el modal en el documento	
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

