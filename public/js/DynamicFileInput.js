/*
	Fichero: dynamicFileInput.js
	
	para generar inputs de tipo file dinámicamente
	
	funcionamiento:
	- incluir este fichero con <script src="js/preview.js"></script>
	- añadir un elemento con ID dynamicFileInput de la siguiente forma:
	
		<div id="dynamicFileInput" 
			 data-bytes="0" data-types="image/*"
			 data-mininputs="3" data-maxinputs="5">
		</div>
		
	- las opciones son:
		- daya-bytes: tamaño máximo en bytes (0 para ilimitado)
		- data-types: tipos de fichero a mostrar en el cuadro de diálogo
		- data-mininputs: número mínimo de inputs
		- data-maxinputs: número máximo de inputs
	
	Autor: Robert Sallent
	Última modificación: 23/02/2023	
*/ 

class DynamicFileInput{
	inputNumber = 1;
	minInputs = 1;
	maxInputs = 10;
	
	container = null;
	bytes = 0;
	types = '';
	
	buttonPlus = null;
	buttonLess = null;
	
	constructor(){
		this.container = document.getElementById('dynamicFileInput');
	    this.bytes = parseInt(this.container.dataset.bytes);
		this.types = this.container.dataset.types;
		this.minInputs = parseInt(this.container.dataset.mininputs);
		this.maxInputs = parseInt(this.container.dataset.maxinputs);
		this.createButtons();
		
		while(this.inputNumber <= this.minInputs)
			this.createInput();
	}
	
	createButtons(){
		this.buttonPlus = document.createElement('input');
		this.buttonPlus.type = 'button';
		this.buttonPlus.className = 'button';
		this.buttonPlus.value = "+";
		this.buttonPlus.addEventListener('click', function(){
			dynamicFileInput.createInput();
		});
		
		this.buttonLess = document.createElement('input');
		this.buttonLess.type = 'button';
		this.buttonLess.className = 'button';
		this.buttonLess.setAttribute('disabled', 'disabled');
		this.buttonLess.value = "-";
		this.buttonLess.addEventListener('click', function(){
			dynamicFileInput.deleteInput();
		});
		
		this.container.appendChild(this.buttonPlus);
		this.container.appendChild(this.buttonLess);
		this.container.appendChild(document.createElement('br'));
	}
	
	createInput(){

		var hidden = null;

		if(this.bytes>0){
			hidden = document.createElement('input');
			hidden.type = 'hidden';
			hidden.name = 'MAX_FILE_SIZE';
			hidden.value = this.bytes;
		}
		
		var input = document.createElement('input');
		input.type = 'file';
		if(this.types != "" && this.types != undefined)
			input.accept = this.types;
		input.name = 'file'+this.inputNumber;
		
		if(this.bytes>0)
			this.container.appendChild(hidden);
			
		this.container.appendChild(input);
		this.container.appendChild(document.createElement('br'));
		
		this.inputNumber++;
		
		if(this.inputNumber > this.maxInputs)
			this.buttonPlus.disabled = 'disabled';
			
		if(this.inputNumber > this.minInputs+1)
			this.buttonLess.removeAttribute('disabled');
	}
	
	deleteInput(){
		this.container.lastElementChild.remove(); // borra br
		
		this.container.lastElementChild.remove(); // borra input
		
		if(this.container.lastElementChild.type == 'hidden')
			this.container.lastElementChild.remove();
			
		this.inputNumber--;
		
		if(this.inputNumber <= this.minInputs+1)
			this.buttonLess.setAttribute('disabled','disabled');
	
		if(this.inputNumber < this.maxInputs+1)
			this.buttonPlus.removeAttribute('disabled');
	}
	
}

window.addEventListener('load', function(){
	dynamicFileInput = new DynamicFileInput();	
});




