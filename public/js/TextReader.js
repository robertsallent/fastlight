/*
	Fichero: TextReader.js
	
	Implementa el lector de pantalla
	
	Funcionamiento:
	- Incluir este fichero con <script src="/js/TextReader.js"></script>.
	- Poner elementos con la clase "readable".
	
	Ejemplos en https://www.demo.fastlight.org/example/legibles
	
	Autor: Robert Sallent
	Última modificación: 16/07/2025	
*/ 

class TextReader{
	
	// Propiedades
	voiceIndex;
	pitch;
	rate;
	volume;
	
	constructor(
		voiceIndex = 0, 
		pitch = 1.0, 
		rate  = 1.0, 
		volume= 1.0
	){
		this.voiceIndex = voiceIndex;
		this.pitch = pitch;
		this.rate  = rate;
		this.volume = volume;
	}
	
	// método de objeto para leer textos
	// TextReader read(String text)
	read(text){
		const toRead = new SpeechSynthesisUtterance(text);
		
		toRead.pitch = this.pitch;	 	// 0.0 a 2.0, 1 es paso normal
		toRead.rate  = this.rate;   	// 0.1 a 10, 1.0 es velocidad normal
		toRead.volumen = this.volume;
		toRead.voice = window.speechSynthesis.getVoices()[this.voiceIndex];
		
		window.speechSynthesis.speak(toRead);
		return this;
	}
	
	// retorna el índice de la voz usada para leer
	// int getVoiceIndex()
	getVoiceIndex(){
		return this.voiceIndex;
	}
	
	// cambia la voz del lector a partir de un índice
	// TextReader changeVoice(int voiceIndex)
	changeVoice(voiceIndex){
		this.voiceIndex = voiceIndex;
		return this;
	}
}


window.addEventListener('load', function(){
			
	let textReader = new TextReader();
	
	// toma todos los elementos de clase readable	
	let readables = document.querySelectorAll('.readable');
	
	// para cada elemento readable, gestiona los eventos
	for(let r of readables){
		r.title = "Haz clic para reproducir el texto mediante voz";

		r.addEventListener('click',function(){
			
			// cambia la voz (si es necesario)
			if(r.dataset.voice != undefined)
				textReader.changeVoice(r.dataset.voice).read(r.textContent);
			else
				textReader.read(r.textContent);
			
		});
	}
});