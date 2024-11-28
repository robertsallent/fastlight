<main>
    <h1>Test de CSS: figuras e imágenes</h1>
    
    <p>En este ejemplo se prueba el CSS por defecto, que se encuentra en el fichero
    <a href="/css/base.css">base.css</a>, y las distintas clases para los elementos HTML
    que tienen que ver con <b>imágenes</b>, <b>figuras</b> y <b>galerías</b>. Además se muestra cómo utilizar modales con las herramientas que incluye el 
    framework.</p>
    
    <h2>Ejemplo de figuras con imágenes</h2>
    
    <p>La clase <code>card</code> hace que tenga aspecto de tarjeta.</p>
    
    <p>Podemos usar también las clases <code>x-small</code>, <code>small</code>, <code>medium</code> 
    , <code>large</code> o <code>x-large</code>
    para dar un ancho máximo de 100, 200, 400, 600 u 800px. Si las imágenes son más pequeñas de la medida
    indicada, no se estirarán.</p> 
    
    <figure class="x-small card m1">
    	<img src="/images/template/logo.png" alt="FastLight">
    	<figcaption>x-small.</figcaption>
    </figure> 
    
    <figure class="small card m1">
    	<img src="/images/template/logo.png" alt="FastLight">
    	<figcaption>Figura small.</figcaption>
    </figure> 
    
    <figure class="medium card m1">
    	<img src="/images/template/logo.png" alt="FastLight">
    	<figcaption>Ejemplo de figura medium.</figcaption>
    </figure> 
    
    
    
    
    <h2>Ejemplo de modal con imagen</h2>
    
    <p>Los <b>modales</b> son contenedores a los que les colocaremos la clase <code>modal</code>.</p>
    
    <p>FastLight automatiza la creación de modales con imágenes mediante 
       el fichero <code>public/js/BigPicture.js</code>. Para usarlo, tan solo tenemos que incluir el fichero con 
    <code>&lt;script src="/js/BigPicture.js"&gt;</code> y añadir la clase 
    <code>enlarge-image</code> a las imágenes que queramos que se amplien mediante
    un modal.</p>
    
    <p>La clase <code>pointer</code> sirve para que se muestre el cursor tipo "mano" al pasar
    el ratón por encima, con lo que el usuario intuirá que se puede hacer clic.</p>
    
    <p>Podemos añadir un par de líneas de texto oculto, que sí se mostrará en el modal, 
    usando la propiedad <code>data-description</code> de HTML en la imagen.</p>
    
    <script src="/js/BigPicture.js"></script>
    
    <figure class="small card">
    	<img class="enlarge-image" src="/images/template/logo.png" alt="FastLight"
    	data-description="Este texto se encuentra en la propiedad data-description, no
    	se muestra en la imagen pequeña pero sí en el modal.">
    	<figcaption>Ejemplo de figura.</figcaption>
    </figure> 
    
     
    
    <h2>Ejemplo de galería</h2>
    
    <p>En este ejemplo se muestra el aspecto de una galería con el CSS por defecto en
    FastLight. Para hacerla, he colocado un contenedor con las siguientes clases:
    <ul>
    	<li><code>gallery</code>: le da el aspecto y aplica el <b>flex</b>.</li>
    	<li><code>w75</code>: para que ocupe el 75% del ancho disponible.</li>
    	<li><code>centered-block</code>: centrado en el documento.</li>
    	<li><code>my2</code>: aumentar el espacio vertical con otros elementos.</li>
    </ul>
    
    <p>Las figuras dentro de la galería tienen las clases:</p>
    <ul>
    	<li><code>small</code>: tamaño pequeño.</li>
    	<li><code>card</code>: forma de tarjeta</li>
    	<li><code>pointer</code>: mostrar el cursor como apuntador (usabilidad).</li>
    </ul>
    
    <p>Las imágenes tienen la clase <code>enlarge-image</code> para que el script 
    en el fichero <code>js/BigPicture.js</code> les añada el manejador de evento clic y las
    convierta en "extensibles" (se abran en el modal).<p>
    
    
    <div class="gallery w75 centered-block my2">
    	<figure class="small card">
    		<img class="enlarge-image" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>Ejemplo de figura.</figcaption>
    	</figure>
    		
    	<figure class="small card">
    		<img class="enlarge-image" src="/images/template/github.png" alt="GitHub"
    		data-description="https://github.com/robertsallent/fastlight">
    		<figcaption>Ejemplo de figura.</figcaption>
    	</figure>
    	
    	<figure class="small card">
    		<img class="enlarge-image" src="/images/template/linkedin.png" alt="LinkedIn"
    		data-description="Robert Sallent en LinkedIn">
    		<figcaption>Ejemplo de figura.</figcaption>
    	</figure>
    	
    	<figure class="small card">
    		<img class="enlarge-image" src="/images/template/fastlight_base.png" alt="FastLight"
    		data-description="FastLight es un framework chulo.">
    		<figcaption>Ejemplo de figura.</figcaption>
    	</figure> 
    </div>
    
    
    
    <h2>Ejemplo de galería con filtros en las imágenes</h2>
     
    <div class="gallery my2">
    	<figure class="small card">
    		<img class="blur" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>.blur</figcaption>
    	</figure>
    		
    	<figure class="small card">
    		<img class="bright" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>.bright</figcaption>
    	</figure>
    	    	
    	<figure class="small card">
    		<img class="dark" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>.dark</figcaption>
    	</figure>
    	
    	<figure class="small card">
    		<img class="high-contrast" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>.high-contrast</figcaption>
    	</figure>
    	
    	<figure class="small card">
    		<img class="low-contrast" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>.low-contrast</figcaption>
    	</figure>
    	
    	<figure class="small card">
    		<img class="shadow" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>.shadow</figcaption>
    	</figure>
    	 
    	 <figure class="small card">
    		<img class="grayscale" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>.grayscale</figcaption>
    	</figure>
    	
    	<figure class="small card">
    		<img class="invert" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>.invert</figcaption>
    	</figure>
    	
    	<figure class="small card">
    		<img class="high-saturation" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>.high-saturation</figcaption>
    	</figure>
    	
    	<figure class="small card">
    		<img class="low-saturation" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>.low-saturation</figcaption>
    	</figure>
    	
    	<figure class="small card">
    		<img class="sepia" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>.sepia</figcaption>
    	</figure>
    	
    	<figure class="small card">
    		<img class="hue90" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>.hue90</figcaption>
    	</figure>
    	
    	<figure class="small card">
    		<img class="hue180" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>.hue180</figcaption>
    	</figure>
    	
    	<figure class="small card">
    		<img class="hue270" src="/images/template/logo.png" alt="Robert Sallent">
    		<figcaption>.hue270</figcaption>
    	</figure>
    	
    </div>
</main>
