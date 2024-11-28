<main>
    <h1>Test de CSS: tablas</h1>
    
    <p>En este ejemplo se prueba el CSS por defecto, que se encuentra en el fichero
    <a href="/css/base.css">base.css</a>, para los distintos elementos HTML.</p>
    
    <p>Lo utilizo para comprobar que los estilos por defecto tienen un aspecto 
    medianamente decente.</p>
    
    
    <h2>Ejemplos de tablas</h2>
    
    <h3>Una tabla normal</h3>
    
    <p>Esta tabla tiene clase <code>table</code>. Las celdas de la última columna 
    tienen la clase <code>bold</code>.</p>
    
    <table class="table">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Materia</th>
                <th>Evaluación</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Perico Palotes</td>
                <td>matemáticas</td>
                <td>primera</td>
                <td class="bold">8</td>
            </tr>
            <tr>
                <td>Bartolomeo Meomeo</td>
                <td>lengua</td>
                <td>recuperación</td>
                <td class="bold">4</td>
            </tr>
            <tr>
                <td>Eva Pagudo</td>
                <td>interpretación</td>
                <td>primera</td>
                <td class="bold">6</td>
            </tr>
            <tr>
                <td>Pablo Moreno</td>
                <td>programación en C</td>
                <td>primera</td>
                <td class="bold">10</td>
            </tr>
            <tr>
                <td>Marta Terrano</td>
                <td>diseño web</td>
                <td>primera</td>
                <td class="bold">7</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Alumnos evaluados: 5</td>
            </tr>
        </tfoot>
    </table>
    
	<h3>Una tabla con botones</h3>
    
    <p>Esta es una tabla con botones en el interior de algunas de las celdas.
       Estos botones tienen clases: <code>button</code>, 
    <code>button-light</code>, <code>button-success</code>, <code>button-warning</code> 
    y <code>button-danger</code>.</p>
    
    <table class="table">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Materia</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Perico Palotes</td>
                <td>matemáticas</td>
                <td><button class="button">Aceptar</button></td>
            </tr>
            <tr>
                <td>Bartolomeo Meomeo</td>
                <td>lengua</td>
                <td><button class="button-light">Aceptar</button></td>
            </tr>
            <tr>
                <td>Eva Pagudo</td>
                <td>interpretación</td>
                <td><button class="button-success">Aceptar</button></td>
            </tr>
            <tr>
                <td>Pablo Moreno</td>
                <td>programación en C</td>
                <td><button class="button-warning">Aceptar</button></td>
            </tr>
            <tr>
                <td>Marta Terrano</td>
                <td>diseño web</td>
                 <td><button class="button-danger">Aceptar</button></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Alumnos: 5</td>
            </tr>
        </tfoot>
    </table>
    

	<h3>Una tabla centrada en la página</h3>
    
    <p>Esta tabla tiene clases:</p>
   	<ul>
   		<li><code>table</code>: formato de tabla.</li>
   		<li><code>border</code>: coloca un borde fino alrededor de la tabla.</li>
   		<li><code>centered-block</code>: alinea en el centro horizontalmente.</li>
   		<li><code>w50</code>: ocupa el 50% del ancho disponible.</li>
	</ul>
    
    <table class="table centered-block border w50">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Materia</th>
                <th>Evaluación</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Perico Palotes</td>
                <td>matemáticas</td>
                <td>primera</td>
                <td class="bold">8</td>
            </tr>
            <tr>
                <td>Bartolomeo Meomeo</td>
                <td>lengua</td>
                <td>recuperación</td>
                <td class="bold">4</td>
            </tr>
            <tr>
                <td>Eva Pagudo</td>
                <td>interpretación</td>
                <td>primera</td>
                <td class="bold">6</td>
            </tr>
            <tr>
                <td>Pablo Moreno</td>
                <td>programación en C</td>
                <td>primera</td>
                <td class="bold">10</td>
            </tr>
            <tr>
                <td>Marta Terrano</td>
                <td>diseño web</td>
                <td>primera</td>
                <td class="bold">7</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Alumnos evaluados: 5</td>
            </tr>
        </tfoot>
    </table>
    
    <h3>Una tabla con imágenes en las celdas</h3>
    
    <p>Celdas con imágenes en la primera columna. A las imágenes
       les podemos añadir la clase <code>table-image</code>.</p>
    
    <table class="table border w50">
        <thead>
            <tr>
            	<th>Foto</th>
                <th>Alumno</th>
                <th>Materia</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            	<td class="centered">
            		<img class="table-image" src="/images/template/logo.png" alt="FastLight">
        		</td>
                <td>Perico Palotes</td>
                <td>primera</td>
                <td class="bold">8</td>
            </tr>
            <tr>
            	<td class="centered">
            		<img class="table-image" src="/images/template/github.png" alt="GitHub">
        		</td>
                <td>Eva Pagudo</td>
                <td>interpretación</td>
                <td class="bold">6</td>
            </tr>
            <tr>
            	<td class="centered">
            		<img class="table-image" src="/images/template/linkedin.png" alt="LinkedIn">
        		</td>
                <td>Pablo Moreno</td>
                <td>programación en C</td>
                <td class="bold">10</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Alumnos evaluados: 4</td>
            </tr>
        </tfoot>
    </table>
    

	<h3>Más padding en las celdas</h3>
    
    <p>Esta tabla tiene clases <code>table</code>, <code>w50</code> y <code>big-cell</code> 
    (aumenta el padding de las celdas). 
       Las celdas de la última columna tienen las clases:</p>
       <ul>
       		<li><code>maxi</code>: hace la letra más grande.</li>
       		<li><code>centered</code>: alineación centrada.</li>
       		<li><code>bold</code>: negrita.</li>
       </ul>
       <p>Y una de éstas: <code>success</code>, <code>warning</code> o <code>danger</code></p>
    
    <table class="table w50 big-cell">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Materia</th>
                <th>Evaluación</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Perico Palotes</td>
                <td>matemáticas</td>
                <td>primera</td>
                <td class="maxi centered bold success">8</td>
            </tr>
            <tr>
                <td>Bartolomeo Meomeo</td>
                <td>lengua</td>
                <td>recuperación</td>
                <td class="maxi centered bold danger">4</td>
            </tr>
            <tr>
                <td>Eva Pagudo</td>
                <td>interpretación</td>
                <td>primera</td>
                <td class="maxi centered bold warning">6</td>
            </tr>
            <tr>
                <td>Pablo Moreno</td>
                <td>programación en C</td>
                <td>primera</td>
                <td class="maxi centered bold success">10</td>
            </tr>
            <tr>
                <td>Marta Terrano</td>
                <td>diseño web</td>
                <td>primera</td>
                <td class="maxi centered bold success">7</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Alumnos evaluados: 5</td>
            </tr>
        </tfoot>
    </table>
    

	<h3>Tomando el 100% del ancho</h3>
    
    <p>Esta tabla tiene clases <code>table</code> y <code>w100</code>.</p>
    <table class="table w100">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Materia</th>
                <th>Evaluación</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Perico Palotes</td>
                <td>matemáticas</td>
                <td>primera</td>
                <td class="bold">8</td>
            </tr>
            <tr>
                <td>Bartolomeo Meomeo</td>
                <td>lengua</td>
                <td>recuperación</td>
                <td class="bold">4</td>
            </tr>
            <tr>
                <td>Eva Pagudo</td>
                <td>interpretación</td>
                <td>primera</td>
                <td class="bold">6</td>
            </tr>
            <tr>
                <td>Pablo Moreno</td>
                <td>programación en C</td>
                <td>primera</td>
                <td class="bold">10</td>
            </tr>
            <tr>
                <td>Marta Terrano</td>
                <td>diseño web</td>
                <td>primera</td>
                <td class="bold">7</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Alumnos evaluados: 5</td>
            </tr>
        </tfoot>
    </table>
</main>

