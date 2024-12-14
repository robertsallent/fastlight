<main>
    <h1>Test de la clase Request</h1>
    
    <section>
        <h2>Objeto Request</h2>
        
        <p>Este objeto <b>contiene la información y datos que llegan al servidor</b> a través de la 
        petición <code>HTTP</code> que realiza el cliente. También dispone de referencias
        al usuario identificado, tokens...</p>
        
        <p>Tenemos varias formas de recuperar el objeto <code>Request</code>:</p>
        <ul>
        	<li>Usando el método estático <code>Kernel::getRequest()</code></li>
        	<li>Usando el método estático <code>Request::take()</code></li>
        	<li>Usando el <i>helper</i> <code>request()</code></li>
        </ul>
        
        <h3>Mostrando la Request recibida</h3>
        <?php 
            $request = request(); 
            dump($request);
        ?>
    </section>
    
    <h2>Propiedades</h2>
    <section>
        <h3>Propiedades básicas</h3>
        
        <ul>
            <li>Ruta previa (<code>$request->previousUrl</code>): <b><?= $request->previousUrl ?></b></li>
            <li>Ruta actual (<code>$request->url</code>): 		  <b><?= $request->url ?></b></li>
            <li>Método (<code>$request->method</code>): 		  <b><?= $request->method ?></b></li>
            <li>IP del cliente (<code>$request->ip</code>): 	  <b><?= $request->ip ?></b></li>
        </ul>
        
        <h3>Recuperando el usuario identificado</h3>
        <p>A partir de la Request podemos recuperar el usuario identificado, puesto
        que dispone de una referencia al objeto <code>User</code> en <code>$request->user</code>.</p>
        <?php dump($request->user); ?>
       
       
        <h3>CSRF</h3>
        <p>Para <b>evitar ataques de <i>Cross Site Request Forgery</i></b>, <i>FastLight</i> incorpora el mecanismo
        de tokens CSRF. El token se puede recuperar a partir de la Request mediante la propiedad
        <code>$request->csrfToken</code>. Para ver un ejemplo completo, revisa el test 
        <a href="/test/security_csrf">security_csrf</a>.</p>
        <p>Token CSRF recibido en la Request:<b><?= $request->csrfToken ?? 'Ninguno' ?></b></p>
    </section>
    
    
    <h2>Métodos para recuperar información</h2>
   
   
   <section>
        <h3 id="get">get() y gets()</h3> 
        <p>El método <code>get()</code> permite recuperar valores que llegan por el método
        HTTP GET. El método <code>gets()</code> permite recuperar en un solo paso todos los valores 
        que llegan por el método HTTP GET. Los valores se recuperan ya saneados.</p>
                    
        <p>Probemos la siguiente URL: <i>/test/http_request?id=10&texto=hola</i>, puedes hacerlo pulsando
         el botón: <a class="button" href="/test/http_request?id=10&texto=hola#get">Clic</a>.</p>
       
		<div class="flex-container"> 
    		<div class="flex1">
                <p>Usando <code>get()</code>:</p> 
                <p>ID: <b><?= $request->get('id') ?></b></p>
                <p>texto: <b><?= $request->get('texto') ?></b></p>
            </div>
            <div class="flex1">
                <p>Usando<code>gets()</code>:</p>
                <?php dump($request->gets()) ?>
            </div>
        </div>
    </section>
        
    
    <section>
        <h3 id="post">post() y posts()</h3> 
        <p>El método <code>post()</code> permite recuperar valores 
        que llegan por el método HTTP POST. El método <code>posts()</code> permite recuperar todos los valores 
        que llegan por el método HTTP POST en un solo paso. Los valores se recuperan ya saneados.</p>
           
        <div class="flex-container gap2 space-between">   
            <form method="POST"  action="#post" class="flex1">
            	<label>nombre:</label>
            	<input type="text" name="nombre">
            	<br>
            	<label>apellido:</label>
            	<input type="text" name="apellido">
            	<br>
            	<input class="button mt2" type="submit" value="enviar">
            </form>
        	<div class="flex1">
                <p>Usando <code>post()</code>:</p> 
                <p>Nombre: <b><?= $request->post('nombre') ?></b></p>
                <p>Apellido: <b><?= $request->post('apellido') ?></b></p>
            </div>
            <div class="flex1">    
                <p>Usando <code>posts()</code>:</p> 
                <?php dump($request->posts()) ?>
            </div>
       </div>
    </section>
    
     
    <section>
        <h3>cookie()</h3>
        
        <p>El método <code>cookie()</code> recupera los datos que llegan por <i>COOKIE</i>.
        Por ejemplo, probemos a recuperar el ID de sesión que llega mediante la cookie de 
        sesión <i>PHPSESSID</i></p>     
        
 		<p>ID de sesión: <b><?= $request->cookie('PHPSESSID') ?></b></p>
    </section>
    
    
    <section>
        <h3>all()</h3>     
        <p>El método <code>all()</code> recupera los datos que llegan por <i>POST</i>, 
        <i>GET</i> o <i>COOKIE</i>.</p>
        <?php dump($request->all()) ?>   
    </section>
    
    
   
    
    <section>
        <h3>header()</h3>     
        <p>El método <code>header()</code> recupera la información contenida en la cabecera con el 
        nombre indicado.</p>
        <p>Cabecera User-Agent: <b><?= $request->header('User-Agent') ?></b></p>
       	
       	<h3>headers()</h3>     
        <p>El método <code>headers()</code> recupera todas las caceberas HTTP de la Request a modo
        de array.</p>
        <?php dump($request->headers()) ?>
       
    </section>    
        
    
    <h2>Métodos para comprobar URLs</h2>
    <section>
        <h3>sameAsPrevious()</h3>     
        <p>El método de objeto <code>sameAsPrevious()</code> retorna <i>true</i> si la 
        URL actual y la de la petición anterior coinciden.</p>
        
		<p>Url actual: <b><?= $request->url ?></b></p>
		<p>Url anterior: <b><?= $request->previousUrl ?></b></p>
		<p>Es la misma?: <b><?= $request->sameAsPrevious() ? 'SI' : 'NO' ?></b></p>
   </section>
   
    
    <section>
        <h3>urlHas()</h3>
        <p>Este método permite comprobar si la URL solicitada contiene una cadena de texto concreta.</p>
        
        <p>La ruta tiene el texto /test? <b><?= $request->urlHas('/test') ? 'SI' : 'NO' ?></b>.</p>
        <p>La ruta tiene el texto library? <b><?= $request->urlHas('library') ? 'SI' : 'NO' ?></b>.</p>
        <p>La ruta tiene el texto patata? <b><?= $request->urlHas('patata') ? 'SI' : 'NO' ?></b>.</p>  
    </section>
    
    
    <section>
        <h3>urlBeginsWith()</h3>
        <p>Este método comprueba si la URL solicitada comienza por una cadena de texto concreta.</p>
        
        <p>La ruta comienza por el texto /test? <b><?= $request->urlBeginsWith('/test') ? 'SI' : 'NO' ?></b></p>
        <p>La ruta comienza por el texto library? <b><?= $request->urlBeginsWith('library') ? 'SI' : 'NO' ?></b></p>
        <p>La ruta comienza por el texto patata? <b><?= $request->urlBeginsWith('patata') ? 'SI' : 'NO' ?></b></p>  
    </section>    
       
    
    <h2>Métodos estáticos</h2>
    <section>    
    	<h3>Request::create()</h3>
        <p>Crea un objeto <code>Request</code> a partir de los datos que recibe el servidor. Este método
        no lo usaremos en las aplicaciones, el objeto <code>Request</code> es creado en el núcleo de <i>FastLight</i> en 
        <code>/core/Kernel.php</code> automáticamente, aquí solamente lo estoy testeando.</p>
        <?php dump(Request::create()) ?>
    </section>
</main>    
