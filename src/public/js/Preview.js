/*
	Fichero: Preview.js
	
	Se usa para mostrar previsualizaciones de imágenes en formularios con inputs de tipo file
	
	Funcionamiento:
	- Incluir este fichero con <script src="/js/Preview.js"></script>.
	- Poner una imagen en el formulario con id "preview-image" y una imagen por defecto.
	- Colocar un input de tipo file con id "file-with-preview".
	
	- Para indicar las extensiones permitidas, podemos usar el atributo data-extensions en el input 
	- Si hay un input tipo hidden MAX_FILE_SIZE antes del input, se comprobará también el tamaño.
	
	Ojo, las extensiones son CASE SENSITIVE.
		
	EJEMPLO:
	
	<input type="file" id="file-with-preview"  data-extensions="jpg|jpeg|png|gif|webp" name="foto">
	<img id="preview-image" src="default.png" alt="imagen con previsualización">
	
	Autor: Robert Sallent
	Última modificación: 06/08/2025	
*/ 

class Preview{
	
	// propiedades
	image 			= null;     // referencia al elemento <img>
	fileInput 		= null;  	// referencia al <input>
	defaultImage 	= ''; 		// ruta de la imagen por defecto
	extensions		= []; 		// array de extensiones permitidas
	
	// constructor
	constructor(){
		this.image 			= document.getElementById('preview-image'); 
		this.fileInput 		= document.getElementById('file-with-preview'); 
		this.defaultImage 	= this.image.src;
		
		let tmp 			= this.fileInput.dataset.extensions ?? null;
		this.extensions		= tmp ? tmp.split('|') : [];
	}
}

// cuando cargue la ventana
window.addEventListener('load', function(){
	
	// crea un nuevo objeto preview
	const preview = new Preview();
	
	// cambia los tipos admitidos en el input de tipo file por los indicados
	// en el atributo data-extensions
	if(preview.extensions.length)
		preview.fileInput.accept = '.'+preview.extensions.join(', .');

	// pone el manejador de eventos para el input de tipo file
	preview.fileInput.onchange = function() {	
		
		// recupera la extensión del fichero seleccionado
		var extension = this.files[0].name.split('.').pop();
			
		// comprueba que sea una de las permitidas, en caso contrario avisar y deshacer
		if(preview.extensions.length && !preview.extensions.some((texto) => texto.includes(extension))){
			alert('El tipo del fichero debe ser de uno de estos tipos: '+this.accept);
			
			preview.image.src = preview.defaultImage; // pone de nuevo la imagen original
			this.value = ''; 	    // borra el contenido del input	
			return;
		}

		// comprueba el tamaño, si supera el máximo hay que avisar y deshacer
		const previo = this.previousElementSibling;
		if(previo != null && previo.tagName == 'INPUT' && previo.name == "MAX_FILE_SIZE"){
			if(previo.value < this.files[0].size){ 
				alert('El tamaño máximo es de  '+(Math.floor(previo.value/1024))+' Kbytes.');
				preview.image.src = preview.defaultImage; // pone de nuevo la imagen original
				this.value = ''; 	    // borra el contenido del input	
				return;
			}
		}

		// si el fichero si es del tipo y tamaño adecuado
	    let reader = new FileReader(); 			// nuevo objeto FileReader
    	reader.readAsDataURL(this.files[0]); 	// lee el fichero

		// cuando esté listo, coloca el resultado en la imagen
	    reader.addEventListener('load', function(){ 
			preview.image.src = reader.result; 		
		});		
	}
});

