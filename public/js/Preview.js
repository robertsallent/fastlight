/*
	Fichero: Preview.js
	
	Se usa para mostrar previsualizaciones de imágenes en formularios con inputs de tipo file
	
	Funcionamiento:
	- Incluir este fichero con <script src="/js/Preview.js"></script>.
	- Poner una imagen en el formulario con id "preview-image" y una imagen por defecto.
	- Colocar un input de tipo file con id "file-with-preview".
	- Si hay un input tipo hidden MAX_FILE_SIZE antes del input, se comprobará también el tamaño.
	
	Autor: Robert Sallent
	Última modificación: 24/02/2023	
*/ 

// CONFIGURA AQUÍ LAS EXTENSIONES PERMITIDAS
// se configuran a modo de expresión regular
const extensions = /\.(jpe?g|png|gif|webp)$/i;

class Preview{
	
	// propiedades
	image = null;      // referencia al elemento <img>
	fileInput = null;  // referencia al <input>
	defaultImage = ''; // ruta de la imagen por defecto
	
	// constructor
	constructor(){
		this.image = document.getElementById('preview-image'); 
		this.fileInput = document.getElementById('file-with-preview'); 
		this.defaultImage = this.image.src;
	}
}

// cuando cargue la ventana
window.addEventListener('load', function(){
	
	// crea un nuevo objeto preview
	const preview = new Preview();

	// pone el manejador de eventos para el input
	preview.fileInput.onchange = function() {	
		// si el fichero no es de los tipos adecuados, no se hacen cambios
		if(!this.files[0].name.match(extensions)){
			alert('El tipo del fichero debe ser '+this.accept);
			preview.image.src = preview.defaultImage; // pone de nuevo la imagen original
			this.value = ''; 	    // borra el contenido del input	
			return;
		}

		// comprueba el tamaño
		const previo = this.previousElementSibling;
		if(previo != null && previo.tagName == 'INPUT' && previo.name == "MAX_FILE_SIZE"){
			if(previo.value < this.files[0].size){ 
				alert('El tamaño máximo es de  '+(previo.value)+'bytes.');
				preview.image.src = preview.defaultImage; // pone de nuevo la imagen original
				this.value = ''; 	    // borra el contenido del input	
				return;
			}
		}

		// si el fichero si es del tipo y tamaño adecuado
	    let reader = new FileReader(); // nuevo objeto FileReader
	    reader.readAsDataURL(this.files[0]); // lee el fichero

	    reader.onload = function(){ // cuando esté listo...
			preview.image.src = reader.result; // coloca la previsualización en la imagen
			
		}
	}
});

