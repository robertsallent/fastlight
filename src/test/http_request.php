<main>
    <h1>Test de la clase Request</h1>
    
    <section id="Request">
        <h2>Objeto Request</h2>
        
        <p>Este objeto <b>contiene información sobre la petición y los datos que llegan
        </b> mediante la <i>Request HTTP</i> que realiza el cliente. Dispone también 
        de una referencia al usuario identificado, información de la ruta actual y la anterior,
        el <i>token CSRF</i> (si se adjunta), los datos que se enviaron desde <i>inputs</i> 
        en la petición anterior...</p>
        
        <p>En nuestras aplicaciones, tendremos varias formas de recuperar el 
        objeto <code>Request</code>:</p>
        <ul>
        	<li>Usando el método estático <code>Request::retrieve()</code> (opción óptima).</li>
        	<li>Usando el <i>helper</i> <code>request()</code> (opción preferida, más simple).</li>
        	<li>Usando la propiedad $request del controlador <code>$this->request</code> (en un controlador).</li>        	
        </ul>
        
        <h3>Mostrando la Request recibida</h3>
                
        <p>Esta es la estructura y la información que contiene la petición actual,
        que acabas de realizar al abrir este test:</p>
                
        <?php 
            $request = request(); 
            dump($request);
        ?>
    </section>
    
    <h2>Propiedades</h2>
    <section id="properties">
        <h3>Propiedades básicas</h3>
        
        <ul>
            <li>Ruta previa <code>$request->previousUrl</code>:   <b><?= $request->previousUrl ?></b></li>
            <li>Ruta actual <code>$request->url</code>: 		  <b><?= $request->url ?></b></li>
            <li>Método <code>$request->method</code>: 		      <b><?= $request->method ?></b></li>
            <li>IP del cliente <code>$request->ip</code>: 	      <b><?= $request->ip ?></b></li>
        </ul>
        
        <h3>Recuperando el usuario identificado</h3>
        <p>A partir de la Request podemos recuperar el usuario identificado, puesto
        que dispone de una referencia al objeto <code>User</code> en <code>$request->user</code>.</p>
        <?php dump($request->user); ?>
       
       
        <h3>CSRF</h3>
        <p>Para <b>evitar ataques de <i>Cross Site Request Forgery</i></b>, <i>FastLight</i> incorpora el mecanismo
        de tokens <i>CSRF</i>. El token se puede recuperar a partir de la Request mediante la propiedad
        <code>$request->csrfToken</code>. Para ver un ejemplo completo, revisa el test 
        <a href="/test/security_csrf">security_csrf</a>.</p>
        <p><i>Token CSRF</i> recibido en la Request:<b><?= $request->csrfToken ?? 'Ninguno' ?></b></p>
    </section>
    
    
    <h2>Métodos para recuperar información</h2>
   
   
   <section id="get">
        <h3 id="get">get() y gets()</h3> 
        <p>El método <code>get()</code> permite recuperar valores que llegan por el método
        <i>HTTP GET</i> de forma individual (a partir de su nombre), mientras que el método 
        <code>gets()</code> recupera en un solo paso todos los valores 
        a modo de <i>array</i> asociativo. Los valores se recuperan ya saneados.</p>
                    
        <p>Probemos la siguiente URL: <i>/test/http_request?id=10&texto=hola</i>, puedes hacerlo pulsando
         el botón.</p> <a class="button" href="/test/http_request?id=10&texto=hola#get">Probar</a>
       
       <p>La URL actual es: <b><i><?= $request->url ?></i></b>.</p>
		
        <p>Ejemplo <code>$request->get('id')</code>: <b><?= $request->get('id') ?></b></p>
        <p>Ejemplo <code>$request->get('texto')</code>: <b><?= $request->get('texto') ?></b></p>
    
        <p>Ejemplo <code>$request->gets()</code>:</p>
        <?php dump($request->gets()) ?>
            
        
    </section>
        
    
    <section id="post">
        <h3>post() y posts()</h3> 
        <p>El método <code>post()</code> permite recuperar valores 
        que llegan por el método <i>HTTP POST</i>, mientras que el método <code>posts()</code> 
        permite recuperar todos los valores en un solo paso a modo de <i>array</i> asociativo.
        Los valores se recuperan ya saneados.</p>
           
        <div class="flex-container gap2 space-between">   
            <form method="POST"  action="#post" class="flex1">
            	<label>Nombre:</label>
            	<input type="text" class="long" name="nombre">
            	<br>
            	<label>Apellido:</label>
            	<input type="text" class="long" name="apellido">
            	<br>
            	<input class="button mt2" type="submit" value="enviar">
            </form>
        	<div class="flex1">
                <p>Ejemplo <code>$request->post('nombre')</code>: <b><?= $request->post('nombre') ?></b></p>
                <p>Ejemplo <code>$request->post('apellido')</code>: <b><?= $request->post('apellido') ?></b></p>
 
                <p>Ejemplo <code>$request->posts()</code>:</p> 
                <?php dump($request->posts()) ?>
            </div>
       </div>
    </section>
    
     
    <section id="cookie">
        <h3>cookie()</h3>
        
        <p>El método <code>cookie()</code> recupera los datos que llegan por <i>COOKIE</i>.
        Por ejemplo, probemos a recuperar el ID de sesión que llega mediante la cookie de 
        sesión <i>PHPSESSID</i>.</p>     
        
 		<p>ID de sesión <code>$request->cookie('PHPSESSID')</code>: <b><?= $request->cookie('PHPSESSID') ?></b></p>
    </section>
    
    
    <section id="has">
        <h3>has()</h3>
        
        <p>El método <code>has()</code> comprueba si llega un determinado parámetro
        vía <i>GET</i>, <i>POST</i> o <i>COOKIE</i>. Le pasamos el nombre del parámetro
        y el método <i>HTTP</i> y nos retornará un <i>boolean</i>.</p>  
        
        <p>Ejemplo <code>$request->has('nombre', 'GET')</code>: 
        <b><?= $request->has('nombre', 'GET') ? 'SI' : 'NO' ?></b></p>

 		<p>Ejemplo <code>$request->has('nombre', 'POST')</code>: 
 		<b><?= $request->has('nombre', 'POST') ? 'SI' : 'NO' ?></b></p>
 		
 		<p>Ejemplo <code>$request->has('PHPSESSID', 'COOKIE')</code>:
 		<b><?= $request->has('PHPSESSID', 'COOKIE') ? 'SI' : 'NO' ?></b></p>
    </section>
    
    
    <section id="all">
        <h3>all()</h3>     
        <p>El método <code>all()</code> recupera los datos que llegan por <i>POST</i>, 
        <i>GET</i> o <i>COOKIE</i>.</p>
        
        <p>Ejemplo <code>$request->all()</code>:</p>
        <?php dump($request->all()) ?>   
    </section>
    
    
   
    
    <section id="header">
        <h3>header()</h3>     
        <p>El método <code>header()</code> recupera la información contenida en la cabecera con el 
        nombre indicado.</p>
        <p>Cabecera User-Agent <code>$request->header('User-Agent')</code>: <b><?= $request->header('User-Agent') ?></b></p>
       	
       	<h3>headers()</h3>     
        <p>El método <code>headers()</code> recupera todas las caceberas HTTP de la Request a modo
        de array.</p>
        <?php dump($request->headers()) ?>     
    </section>  
    
    
    <section id="body">
        <h3>body()</h3>     
        <p>El método <code>body()</code> recupera el contenido del cuerpo de la 
        petición <i>HTTP</i>. Se usa principalmente para recuperar la información que llega en <i>XML</i>
        o <i>JSON</i> en peticiones <i>POST</i> y <i>PUT</i>, con los datos en crudo (raw),
         cuando trabajamos con APIs. Ojo porque <b>no sanea los datos</b>.</p>
        
        <p>Ejemplo <code>$request->body()</code>:</p> 
        <?php dump($request->body()) ?>    
    </section>      
        
    
    <h2>Métodos para comprobar URLs</h2>
    <section id="sameAsPrevious">
        <h3>sameAsPrevious()</h3>     
        <p>El método de objeto <code>sameAsPrevious()</code> retorna <i>true</i> si la 
        URL actual y la de la petición anterior coinciden.</p>
        
		<p>Url actual: <b><?= $request->url ?></b></p>
		<p>Url anterior: <b><?= $request->previousUrl ?></b></p>
		<p>Es la misma? <code>$request->sameAsPrevious()</code>: <b><?= $request->sameAsPrevious() ? 'SI' : 'NO' ?></b></p>
   </section>
   
    
    <section id="urlHas">
        <h3>urlHas()</h3>
        <p>Este método permite comprobar si la URL solicitada contiene una cadena de texto concreta.</p>
        
        <p>Url actual: <b><?= $request->url ?></b></p>
        
        <p>La ruta tiene el texto <i>/test</i> <code>$request->urlHas('/test')</code>? 
        <b><?= $request->urlHas('/test') ? 'SI' : 'NO' ?></b>.</p>
        
        <p>La ruta tiene el texto <i>http</i> <code>$request->urlHas('http')</code>? 
        <b><?= $request->urlHas('http') ? 'SI' : 'NO' ?></b>.</p>
        
        <p>La ruta tiene el texto <i>patata</i> <code>$request->urlHas('patata')</code>? 
        <b><?= $request->urlHas('patata') ? 'SI' : 'NO' ?></b>.</p>  
    </section>
    
    
    <section id="urlBeginsWith">
        <h3>urlBeginsWith()</h3>
        <p>Este método comprueba si la URL solicitada comienza por una cadena de texto concreta.</p>
        
        <p>Url actual: <b><?= $request->url ?></b></p>
        
        <p>La ruta comienza por el texto <i>/test</i> <code>$request->urlBeginsWith('/test')</code>? 
        <b><?= $request->urlBeginsWith('/test') ? 'SI' : 'NO' ?></b></p>
        
        <p>La ruta comienza por el texto <i>/library</i> <code>$request->urlBeginsWith('/library')</code>? 
        <b><?= $request->urlBeginsWith('/library') ? 'SI' : 'NO' ?></b></p>
        
        <p>La ruta comienza por el texto <i>http</i> <code>$request->urlBeginsWith('http')</code>? 
        <b><?= $request->urlBeginsWith('http') ? 'SI' : 'NO' ?></b></p>  
    </section>   
    
    
    
    <h2 id="file">Recuperando ficheros</h2>
    <section>
        <h3>file()</h3>
        <p>El método <code>file()</code> permite recuperar un fichero a partir de la
        petición. Lo recupera como objeto de tipo <i>UploadedFile</i>, para más información
        y ejemplos, podéis consultar el test 
        <a href="/test/library_uploadedfile">library_uploadedFile</a>.</p>
        
        
        <div class="flex-container gap2 space-between">   
            <form method="POST"  action="#file" class="flex1" enctype="multipart/form-data">
            	<label>Nombre:</label>
            	<input type="text" class="long" name="nombre">
            	<br>
            	<label>Apellido:</label>
            	<input type="text" class="long" name="apellido">
            	<br>
            	<label>Foto de perfil:</label>
            	<input type="file" name="imagen">
            	<br>
            	<input class="button mt2" type="submit" value="enviar">
            </form>
        	<div class="flex1">
                <p>Ejemplo <code>$request->file('imagen')</code>:</p>
                <?php dump($request->file('imagen')) ?>
            </div>
       </div>        
    </section> 
    
    
    <section id="previousInputs">
        <h3>$request->previousInputs</h3>
        
        <p>La propiedad <code>previousInputs</code> contiene los datos que se enviaron
        mediante formulario en la petición anterior, que se encuentran "flasheados" en 
        sesión.</p>
        
        <p>Es usada por los <i>helpers</i> <code>old()</code> para rellenar automáticamente
        campos de formulario con valores antiguos cuando se producen errores de validación.
        Para ver ejemplos de funcionamiento de estos <i>helpers</i>, consultad el test
        <a href="/test/helpers_old">helpers_old</a>.</p>     
        
 		<?php dump($request->previousInputs) ?>
    </section>
    
    
    
    
    <h2>Otros métodos</h2>
    <section id="allowedByCors">
        <h3>allowedByCors()</h3>
        <p>Este método comprueba la petición llega por alguno de los métodos permitidos
        según la política <i>CORS</i>. Los métodos permitidos se configuran mediante
        la constante <code>ALLOW_METHODS</code> en el fichero <i>config/config.php</i>.</p>
        
        <p>Es utilizado desde el Kernel de la API en <i>app/core/Api.php</i>, para comprobar
        si debe responder correctamente o lanzar un error 405. No está pensado para que
        lo usemos directamente.</p>
        
        <p>Método de la petición: <b><?= $request->method ?></b></p>
        <p>Permitimos peticiones por ese método?  <b><?= $request->allowedByCors() ? 'SI' : 'NO' ?></b></p>  
    </section> 
       
</main>    
