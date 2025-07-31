
/*	

	Slider animado, por Robert Sallent para el curso de 
	aplicaciones web en CIFO Sabadell 
	
*/

// CONFIGURACION - todos estos parámetros se pueden modificar


class Slider{
	
	// propiedades
	numImagenes;
	fotos;
	tiempo;
	proporcion;	
	inicial;
	final;
	intervalo;
	
	// constructor
	constructor(options){
		this.numImagenes = options.numImagenes;
		this.fotos = options.fotos;
		this.tiempo = options.tiempo;
		this.proporcion = options.proporcion;
		this.inicial = options.inicial;
		this.final = options.final;
	}
	
	// métodos
	prepare(){
		let real = document.getElementById('slider');
		
		// crea tantas imágenes como se haya configurado
		// (+2 que sobresalen por los extremos pero no se ven)
		for(let j=this.inicial; j<this.final; j++){
			let imagen = document.createElement('img');
			imagen.src = this.fotos[j];

			// cálculos para el posicionamiento absoluto
			imagen.style.width = 100/this.numImagenes+'%';
			imagen.style.left = 100/(this.numImagenes)*(j-1)+'%';

			real.appendChild(imagen);
		}

		// calcula la altura de la galería de forma dinámica
		real.style.height = real.offsetWidth/(this.numImagenes*this.proporcion)+'px';
	}
	
	
	// avanzar
	avanzar(){
		this.inicial=(this.inicial+1)%this.fotos.length; // actualiza índices
		this.final=(this.final+1)%this.fotos.length;
		
		let real = document.getElementById('slider');
		 
		// crea una nueva imagen y colócala al final (derecha)
		var imagen = document.createElement('img');
		imagen.src = this.fotos[this.final];
		imagen.style.width = 100/this.numImagenes+'%';       // cálculo del ancho
		imagen.style.left  = 100+(100/this.numImagenes)+'%'; // cálculo de su posición
		real.appendChild(imagen);
		
		// recupera las imágenes de la galería
		var imagenes = real.getElementsByTagName('img');

		for(let imagen of imagenes) // recalcula sus nuevas posiciones
			imagen.style.left = parseInt(imagen.style.left)-(100/this.numImagenes)+'%';

		imagenes[0].remove(); // elimina la foto que se sale por el inicio (izquierda)
	}
	
	
	
	
	// retroceder
	retroceder(){
		this.inicial=((this.inicial-1)+this.fotos.length)%this.fotos.length;  // actualiza índices
		this.final=((this.final-1)+this.fotos.length)%this.fotos.length;

		let real = document.getElementById('slider');
		
		// crea una nueva imagen y colócala al inicio (izquierda)
		var imagen = document.createElement('img');
		imagen.src = this.fotos[this.inicial];
		imagen.style.width = 100/this.numImagenes+'%';		// cálculo del ancho
		imagen.style.left  = -(100/this.numImagenes)*2+'%';	// cálculo de su posición
		real.insertBefore(imagen, real.firstElementChild);

		// recupera las imágenes de la galería
		var imagenes = real.getElementsByTagName('img');

		for(let imagen of imagenes) // recalcula sus nuevas posiciones
			imagen.style.left = parseInt(imagen.style.left)+(100/this.numImagenes)+'%';
		
		imagenes[imagenes.length-1].remove(); // elimina la foto que se sale por el final (derecha)
	}

	
	
}



// al cargar la página
window.addEventListener('load', function(){
	
	const sliderObject = new Slider(sliderConfig);
	sliderObject.prepare();
	
	sliderObject.intervalo = setInterval(function(){sliderObject.avanzar()}, sliderObject.tiempo*1000);
	
	btnBack.onclick = function() {
		clearInterval(sliderObject.intervalo);
		sliderObject.avanzar()
		sliderObject.intervalo = setInterval(function(){sliderObject.avanzar()}, sliderObject.tiempo*1000);
	}; // añade el evento al botón atrás
	
	btnNext.onclick = function() {
		clearInterval(sliderObject.intervalo);
		sliderObject.retroceder()
		sliderObject.intervalo = setInterval(function(){sliderObject.avanzar()}, sliderObject.tiempo*1000);
	}; // añade el evento al botón siguiente
	
	// si varía el tamaño de la ventana, recalculamos el alto de la galería
	window.onresize = function(){
		document.getElementById('slider').style.height = document.getElementById('slider').offsetWidth/(sliderObject.numImagenes*sliderObject.proporcion)+'px';
	}

});









