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
		container.className = 'modal';
				
		// preparación de la figura interna
		let figure  = document.createElement('figure');
		figure.className = 'card';
		
		// "botón" de cerrar
		let closeModal = document.createElement('a');
		closeModal.className = 'close-modal pointer';
		closeModal.innerText = '[X]';
		closeModal.onclick = function(){ 
			container.remove(); 
		};
		figure.appendChild(closeModal);
		
		// preparación de la imagen dentro de la figura
		let image   = document.createElement('img');
		image.src = imagen.src;
		image.alt = imagen.alt;
		figure.appendChild(image);
		
		
		
		// creación del figcaption
		if(imagen.dataset.caption != undefined || imagen.dataset.description != undefined){
			var caption = document.createElement('figcaption');
			
			// coloca el data-caption en un h2
			if(imagen.dataset.caption != undefined){
				let title = document.createElement('h2'); 
				title.className = 'm2';
				title.innerText = imagen.dataset.caption;		
				caption.appendChild(title);
			}
			
			// coloca el data-description en un p
			if(imagen.dataset.description != undefined){
				let p   = document.createElement('p');
				p.innerText = imagen.dataset.description;
				caption.appendChild(p);
			}	
			
			figure.appendChild(caption);		
		}else{
			figure.classList.add('no-caption');
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

