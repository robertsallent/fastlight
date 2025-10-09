/*
	Fichero: TextReader.js
	
	DESCRIPCION
	
	Implementa el lector de pantalla.
	
	El lector de pantalla leerá de viva voz los elementos "readables" cuando 
	se produzca un determinado evento en ellos (por defecto clic). Ante el mismo
	evento mientras está reproduciendo, se detendrá.
	
	
	MODO DE EMPLEO
	
	- Incluir este fichero haciendo: <script src="/js/TextReader.js"></script>.
	- Poner la clase "readable" a los elementos que queramos que puedan ser leidos.
	
	Se puede indicar el tipo de evento que debe disparar la lectura del elemento,
	mediante el atributo personalizado data-event, por ejemplo para que el texto
	sea leido al hacer doble clic, indicaremos: data-event="dblclick".
		
	El lector intentará seleccionar automáticamente una voz en el idioma definido en 
	el elemento html de la página (en el framework FastLight se puede 
	indicar en el fichero config.php).
	
	Si queremos que no lea el texto de algunos elementos internos al
	elemento de clase "readable", debemos poner el atributo aria-hidden="true"
	a esos elementos internos.
	
	Ejemplos en https://www.demo.fastlight.org/example/legibles
	
	Autor: Robert Sallent
	Última modificación: 08/10/2025	
*/ 

class TextReader{
	
	// Propiedades
	voiceIndex;		// índice de la voz a usar
	pitch;			// velocidad
	rate;			// paso
	volume;			// volumen
	reading;		// para saber si está leyendo o parado
	
	constructor(
		voiceIndex 	= null, 
		pitch 		= 1.0, 
		rate  		= 1.0, 
		volume		= 1.0
	){
		this.voiceIndex = voiceIndex;
		this.pitch = pitch;
		this.rate  = rate;
		this.volume = volume;
		this.reading = false;
	}
	
	// método de objeto para leer textos
	read(text){
		let toRead = new SpeechSynthesisUtterance(text);
		this.reading = true;
				
		toRead.pitch = this.pitch;	 	// 0.0 a 2.0, 1 es paso normal
		toRead.rate  = this.rate;   	// 0.1 a 10, 1.0 es velocidad normal
		toRead.volume = this.volume;
		toRead.voice = window.speechSynthesis.getVoices()[this.voiceIndex ?? this.getBestVoiceIndex()];
		
		window.speechSynthesis.speak(toRead);
		
		toRead.addEventListener('end', () => {
			this.reading = false;
		});
		
		return this;
	}
	
	// retorna el índice de la voz usada para leer
	// int getVoiceIndex()
	getVoiceIndex(){
		return this.voiceIndex;
	}
	
	// retorna si está leyendo o no
	isReading(){
		return this.reading;
	}
	
	stopReading(){
		speechSynthesis.cancel()
		this.reading = false;
	}

	// cambia la voz del lector a partir de un índice
	// TextReader changeVoice(int voiceIndex)
	changeVoice(voiceIndex){
		this.voiceIndex = voiceIndex;
		return this;
	}
	
	
	// calcula el índice de la voz adecuada para el idioma de la página
	getBestVoiceIndex() {
	  const pageLang = (document.documentElement.lang || 'es').toLowerCase();
	  const voices = speechSynthesis.getVoices();

	  // si no están cargadas, usaremos la 0 por defecto
	  if (!voices.length) 
		return 0; 

	  // coincidencia total
	  let index = voices.findIndex(v => v.lang.toLowerCase() === pageLang);

	  // coincidencia parcial (si no hay coincidencia total)
	  if (index === -1)
	    index = voices.findIndex(v => v.lang.toLowerCase().startsWith(pageLang.split('-')[0]));

	  // si no hay coincidencia alguna, usaremos la primera 
	  if (index === -1) index = 0;

	  this.voiceIndex = index;
	}
}



// retorna el texto visible de un elemento. Se quitan los elementos con atributo aria-hidden="true"
function getVisibleText(element) {
  // si el elemento o alguno de sus ancestros tiene aria-hidden="true", ignóralo
  if (element.closest('[aria-hidden="true"]')) 
    return '';

  // si el elemento no tiene hijos, devuelve su texto directamente
  if (!element.children.length)
    return element.textContent.trim();


  // si tiene hijos, recorre recursivamente solo los visibles
  let text = '';
  for (const child of element.childNodes) {
    if (child.nodeType === Node.TEXT_NODE) {
      text += child.textContent;
    } else if (child.nodeType === Node.ELEMENT_NODE && !child.matches('[aria-hidden="true"]')) {
      text += ' ' + getVisibleText(child);
    }
  }
  return text.trim();
}


// al cargar la ventana...
window.addEventListener('load', function(){
			
	// crea un oebjeto TextReader con los valores por defecto
	// esto es: voiceIndex 0, pitch 1, rate 1, volume 1
	let textReader = new TextReader();
		
	// toma todos los elementos de clase readable	
	let readables = document.querySelectorAll('.readable');
	
	// para cada elemento readable, gestiona los eventos
	for(let r of readables){
		
		// recupera el tipo de evento y la descripción
		let eventName = r.dataset.event ?? 'click';
		let infoEvent =  r.dataset.info ?? eventName ;
		
		r.title = "Haz '"+infoEvent+"' para reproducir el texto mediante voz";

		r.addEventListener(eventName, function(){
			
			// cambia la voz (si es necesario)
			if(r.dataset.voice != undefined)
				textReader.changeVoice(r.dataset.voice);
			
			// comienza a leer o detiene la lectura
			textReader.isReading() ? textReader.stopReading() : textReader.read(getVisibleText(r));
			
		});
	}
	
});