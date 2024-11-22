
<h1>Test de CSS: tablas</h1>

<p>En este ejemplo se prueba el CSS por defecto, que se encuentra en el fichero
<a href="/css/base.css">base.css</a>, para los distintos elementos HTML.</p>

<p>Lo utilizo para comprobar que los estilos por defecto tienen un aspecto 
medianamente decente.</p>


<h2>Ejemplos de tablas</h2>


<p>Esta tabla tiene clase <code>table</code>.</p>

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
            <td>8</td>
        </tr>
        <tr>
            <td>Bartolomeo Meomeo</td>
            <td>lengua</td>
            <td>recuperación</td>
            <td>4</td>
        </tr>
        <tr>
            <td>Eva Pagudo</td>
            <td>interpretación</td>
            <td>primera</td>
            <td>6</td>
        </tr>
        <tr>
            <td>Pablo Moreno</td>
            <td>programación en C</td>
            <td>primera</td>
            <td>10</td>
        </tr>
        <tr>
            <td>Marta Terrano</td>
            <td>diseño web</td>
            <td>primera</td>
            <td>7</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">Alumnos evaluados: 5</td>
        </tr>
    </tfoot>
</table>

<hr>

<p>Esta es una tabla con botones en su interior.</p>

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

<hr>

<p>Esta tabla tiene clases <code>table</code>, <code>border</code>, <code>centered-block</code> y <code>w75</code>.</p>

<table class="table centered-block border w75">
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
            <td>8</td>
        </tr>
        <tr>
            <td>Bartolomeo Meomeo</td>
            <td>lengua</td>
            <td>recuperación</td>
            <td>4</td>
        </tr>
        <tr>
            <td>Eva Pagudo</td>
            <td>interpretación</td>
            <td>primera</td>
            <td>6</td>
        </tr>
        <tr>
            <td>Pablo Moreno</td>
            <td>programación en C</td>
            <td>primera</td>
            <td>10</td>
        </tr>
        <tr>
            <td>Marta Terrano</td>
            <td>diseño web</td>
            <td>primera</td>
            <td>7</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">Alumnos evaluados: 5</td>
        </tr>
    </tfoot>
</table>

<hr>

<p>Esta tabla tiene clases <code>table</code>, <code>w50</code> y <code>big-cell</code>.</p>

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
            <td>8</td>
        </tr>
        <tr>
            <td>Bartolomeo Meomeo</td>
            <td>lengua</td>
            <td>recuperación</td>
            <td>4</td>
        </tr>
        <tr>
            <td>Eva Pagudo</td>
            <td>interpretación</td>
            <td>primera</td>
            <td>6</td>
        </tr>
        <tr>
            <td>Pablo Moreno</td>
            <td>programación en C</td>
            <td>primera</td>
            <td>10</td>
        </tr>
        <tr>
            <td>Marta Terrano</td>
            <td>diseño web</td>
            <td>primera</td>
            <td>7</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">Alumnos evaluados: 5</td>
        </tr>
    </tfoot>
</table>

<hr>

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
            <td>8</td>
        </tr>
        <tr>
            <td>Bartolomeo Meomeo</td>
            <td>lengua</td>
            <td>recuperación</td>
            <td>4</td>
        </tr>
        <tr>
            <td>Eva Pagudo</td>
            <td>interpretación</td>
            <td>primera</td>
            <td>6</td>
        </tr>
        <tr>
            <td>Pablo Moreno</td>
            <td>programación en C</td>
            <td>primera</td>
            <td>10</td>
        </tr>
        <tr>
            <td>Marta Terrano</td>
            <td>diseño web</td>
            <td>primera</td>
            <td>7</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">Alumnos evaluados: 5</td>
        </tr>
    </tfoot>
</table>


