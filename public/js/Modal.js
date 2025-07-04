/*
	Fichero: Modal.js
	
	Se usa para agrandar las imágenes al hacerles clic.
	
	Funcionamiento:
	- Incluir este fichero con <script src="/js/Modal.js"></script>.
	- Poner imágenes con la clase "with-modal".
	
	Si queremos que el modal tenga un figcaption, hay que añadir el atributo
	data-caption a la imagen.
	
	Si queremos que el modal muestre una descripción ampliada en un párrafo,
	hay que añadir el atributo data-description a la imagen.
	
	Autor: Robert Sallent
	Última modificación: 04/07/2025	
*/ 

class Modal{
		
	// método que crea la nueva figura grande en un modal
	// prototipo: void showFigure(HTMLImageElement imagen)
	showFigure(imagen){
		
		// preparación del contenedor externo
		let container = document.createElement('div');
		container.className = 'modal zoom-out';
		container.onclick = function(){ 
			this.remove(); 
		};
		
		// preparación de la figura interna
		let figure  = document.createElement('figure');
		figure.className = 'card';
		
		// preparación de la imagen dentro de la figura
		let image   = document.createElement('img');
		image.src = imagen.src;
		image.alt = imagen.alt;
		figure.appendChild(image);
		
		
		// colocar el texto alternativo en el figcaption
		if(imagen.dataset.caption != undefined){
			let caption = document.createElement('figcaption');
			caption.className = 'm2';
			caption.innerText = imagen.dataset.caption;		
			figure.appendChild(caption);
			
		}else{
			image.classList.add('no-caption');
		}
		
		
		// colocar la descripción en un párrafo
		if(imagen.dataset.description != undefined){
			let p   = document.createElement('p');
			p.innerText = imagen.dataset.description;
			figure.appendChild(p);
			
		}else{
			image.classList.add('no-description');
		}
		
		// coloca la figura y el modal en el documento	
		container.appendChild(figure);
		document.body.appendChild(container);
	}
}

// cuando cargue la ventana
window.addEventListener('load', function(){
	
	// recupera todas las imagenes enlarge-image
	let imagenes = document.querySelectorAll('img.with-modal');
	
	// colocar el listener a cada una de las imagenes
	for(let imagen of imagenes){
		imagen.addEventListener('click', function(){
			new Modal().showFigure(imagen);
		});
	}
});

