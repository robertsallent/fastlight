
/*	

	Slider animado, por Robert Sallent para el curso de 
	aplicaciones web en CIFO Sabadell 
	
*/

// CONFIGURACION - todos estos parámetros se pueden modificar


class Slider{
	
	// propiedades
	container;
	numImagenes;
	botones;
	fotos;
	tiempo;
	proporcion;	
	inicial;
	final;
	intervalo;
	modales
	captions;
	descriptions;
	
	// constructor
	constructor(container, options){
		this.container 		= document.getElementById(container);
		this.numImagenes 	= options.numImagenes ?? 1;
		this.botones 		= options.botones ?? true;
		this.tiempo 		= options.tiempo ?? 0;
		this.proporcion 	= options.proporcion ?? 4/3;
		this.inicial 		= options.inicial ?? 0;
		this.final 			= options.final ?? options.numImagenes+2;
		this.modales		= options.modales ?? false;
		this.fotos 			= options.fotos ?? [];
		this.captions 		= options.captions ?? [];
		this.descriptions	= options.descriptions ?? [];
	}
	
	
	// métodos
	start(){
		
		// para el CSS
		this.container.classList.add('slider-container');
		
		// crea tantas imágenes como se haya configurado
		// (+2 que sobresalen por los extremos pero no se ven)
		for(let j=this.inicial; j<this.final; j++){
			let imagen = document.createElement('img');
			imagen.src = this.fotos[j];
			
				
			if(this.captions[j] != undefined)
				imagen.setAttribute('data-caption', this.captions[j]);
			
			if(this.descriptions[j] != undefined)
				imagen.setAttribute('data-description', this.descriptions[j]);
			
			if(this.modales)
				imagen.addEventListener('click', function(){
					new Modal().showFigure(imagen);
				});
			
			// cálculos para el posicionamiento absoluto
			imagen.style.width = 100/this.numImagenes+'%';
			imagen.style.left = 100/(this.numImagenes)*(j-1)+'%';

			this.container.appendChild(imagen);
		}
		
		
		const slider = this;

		// Si el tiempo es 0 o menor que 0, está desactivado el avance automático
		if(this.tiempo>0){
			this.intervalo = setInterval(function(){
				slider.avanzar()
			}, this.tiempo*1000);
		}
		
		
		if(this.botones){
			// coloca el botón "anterior"
			const btnPrev = document.createElement('div');
			btnPrev.className = 'arrow';
			btnPrev.id = 'slider-btnPrev';
			let span1 = document.createElement('span');
			span1.innerText = '<';
			btnPrev.appendChild(span1);
			this.container.appendChild(btnPrev);
			
			// coloca el botón "siguiente"
			const btnNext = document.createElement('div');
			btnNext.className = 'arrow';
			btnNext.id = 'slider-btnNext';
			let span2 = document.createElement('span');
			span2.innerText = '>';
			btnNext.appendChild(span2);
			this.container.appendChild(btnNext);
	
			btnNext.onclick = function() {
				
				slider.avanzar()
				
				if(slider.tiempo>0){
					clearInterval(slider.intervalo);
					slider.intervalo = setInterval(function(){
						slider.avanzar()
					}, slider.tiempo*1000);
				}
			}; // añade el evento al botón atrás
	
			btnPrev.onclick = function() {
				
				slider.retroceder()
				
				if(slider.tiempo>0){
					clearInterval(slider.intervalo);
					slider.intervalo = setInterval(function(){
						slider.avanzar()
					}, slider.tiempo*1000);
				}
			}; // añade el evento al botón siguiente
		}
		

		// calcula la altura de la galería de forma dinámica
		this.container.style.height = this.container.offsetWidth/(this.numImagenes*this.proporcion)+'px';
					
					
		// si varía el tamaño de la ventana, recalculamos el alto de la galería
		window.addEventListener('resize', function(){
			slider.container.style.height = slider.container.offsetWidth/(slider.numImagenes*slider.proporcion)+'px';
		});	
		
		// poner los índices correctos para las imágenes a mostrar
		// impide que se repitan imágenes al avanzar o retroceder por primera vez
		this.incial = 1;
		this.final = 1+this.numImagenes;	
	}
	
	
	// avanzar
	avanzar(){
		this.inicial=(this.inicial+1)%this.fotos.length; // actualiza índices
		this.final=(this.final+1)%this.fotos.length;
			 
		// crea una nueva imagen y colócala al final (derecha)
		var imagen = document.createElement('img');
		
		
			
		if(this.captions[this.final] != undefined)
			imagen.setAttribute('data-caption', this.captions[this.final]);
						
		if(this.descriptions[this.final] != undefined)
			imagen.setAttribute('data-description', this.descriptions[this.final]);
		
		if(this.modales)
			imagen.addEventListener('click', function(){
				new Modal().showFigure(imagen);
			});
					
		imagen.src = this.fotos[this.final];
		imagen.style.width = 100/this.numImagenes+'%';       // cálculo del ancho
		imagen.style.left  = 100+(100/this.numImagenes)+'%'; // cálculo de su posición
		this.container.appendChild(imagen);
		
		// recupera las imágenes de la galería
		var imagenes = this.container.getElementsByTagName('img');

		for(let imagen of imagenes) // recalcula sus nuevas posiciones
			imagen.style.left = parseInt(imagen.style.left)-(100/this.numImagenes)+'%';

		imagenes[0].remove(); // elimina la foto que se sale por el inicio (izquierda)
	}
	
	
	
	
	// retroceder
	retroceder(){
		this.inicial=((this.inicial-1)+this.fotos.length)%this.fotos.length;  // actualiza índices
		this.final=((this.final-1)+this.fotos.length)%this.fotos.length;
		
		// crea una nueva imagen y colócala al inicio (izquierda)
		var imagen = document.createElement('img');
		
		
		if(this.captions[this.inicial] != undefined)
			imagen.setAttribute('data-caption', this.captions[this.inicial]);
									
		if(this.descriptions[this.inicial] != undefined)
			imagen.setAttribute('data-description', this.descriptions[this.inicial]);
		
		if(this.modales)
			imagen.addEventListener('click', function(){
				new Modal().showFigure(imagen);
			});
								
		imagen.src = this.fotos[this.inicial];
		imagen.style.width = 100/this.numImagenes+'%';		// cálculo del ancho
		imagen.style.left  = -(100/this.numImagenes)*2+'%';	// cálculo de su posición
		this.container.insertBefore(imagen, this.container.firstElementChild);

		// recupera las imágenes de la galería
		var imagenes = this.container.getElementsByTagName('img');

		for(let imagen of imagenes) // recalcula sus nuevas posiciones
			imagen.style.left = parseInt(imagen.style.left)+(100/this.numImagenes)+'%';
		
		imagenes[imagenes.length-1].remove(); // elimina la foto que se sale por el final (derecha)
	}

	
	
}




	






