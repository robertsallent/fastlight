<main>
    
    <h1>Test de CSS: listas</h1>
    
    <p>En este ejemplo se prueban los estilos para las <b>listas</b>, <b>menú principal</b>
    y <b>migas</b>, que se encuentran en el fichero <a href="/css/base.css">base.css</a>.</p>
    
    <h2>Ejemplos de listas</h2>
    
    <p>Una lista numerada.</p>
    
    <ol>
    	<li>Un elemento.</li>
    	<li>Un elemento.</li>
    	<li>Un elemento.</li>
    	<li>Un elemento.</li>
    </ol>
    
    <p>Una lista no numerada.</p>
    
    <ul>
    	<li>Un elemento.</li>
    	<li>Un elemento.</li>
    	<li>Un elemento.</li>
    	<li>Un elemento.</li>
    </ul>
    
    
    <p>Una listade definiciones.</p>
    
    <dl>
    	<dt>Una palabra</dt>
    	<dd>Una descripción de lo que significa.</dd>
    	<dt>Otra palabra</dt>
    	<dd>Otra descripción de lo que significa.</dd>
    	<dt>Más palabras</dt>
    	<dd>Otras descripciones.</dd>
    </dl>
    
    <h2>Listas dentro de listas.</h2>
    
    <ul>
    	<li>Un elemento.
        	<ul>
        		<li>Un sub-elemento.</li>
        		<li>Un sub-elemento.</li>
        		<li>Un sub-elemento.
        			<ul>
                		<li>Un sub-sub-elemento.</li>
                		<li>Un sub-sub-elemento.</li>
                		<li>Un sub-sub-elemento.</li>
                		<li>Un sub-sub-elemento.</li>
                	</ul>
            	</li>
        		<li>Un sub-elemento.</li>
        	</ul>
    	</li>
    	<li>Un elemento.</li>
    	<li>Un elemento.</li>
    	<li>Un elemento.</li>
    </ul>
    
    <h2>Ejemplo de menú</h2>
    
    <p>Para hacer el menú principal, usamos la clase <code>menu</code> en un elemento de tipo <code>menu</code>.</p>
    
    <menu class="menu">
    	<li><a href="#">Enlace 1</a></li>
    	<li><a href="#">Enlace 2</a></li>
    	<li><a href="#">Enlace 3</a></li>
    	<li><a href="#">Enlace 4</a></li>
    	<li><a href="#">Enlace 5</a></li>
    </menu>
    
    <h2>Ejemplo de migas</h2>
    
    <p>Para hacer el "migas", usamos un elemento <code>nav</code> de clase <code>breadcrumbs</code>.
       La lista con los enlaces se encuentra dentro del elemento <code>nav</code>.</p>
       
    <p>Este migas de ejemplo tiene las clases: <code>breadcrumbs dashed-border p1 w50</code>.</p>
    
    <nav aria-label='Breadcrumb' class='breadcrumbs dashed-border p1 w50'>
    	<ul>
    		<li><a href='/'>Inicio</a></li>
    		<li><a href='#'>Categoria</a></li>
    		<li><a href='#'>Sección</a></li>
    		<li>Página</li>
    	</ul>
    </nav>
</main> 
