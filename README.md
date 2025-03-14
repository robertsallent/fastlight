<h1>FastLight Framework</h1>

    		
<h2>Bienvenido!</h2>
        		
<a href="https://fastlight.org">FastLight</a> es un framework rápido y ligero para desarrollar aplicaciones web en PHP o APIs RESTFUL.

Está planteado como framework para docencia, pero se puede utilizar para desarrollos profesionales pequeños y medianos. Incorpora las características esenciales para crear aplicaciones web rápidas, sólidas y fiables, pero no incluye algunas funcionalidades que desarrollamos en clase (las encontraréis detalladas en la documentación y tutoriales). 

Todas las herramientas que incorpora han sido creadas expresamente para él, aunque está basado en frameworks PHP anteriores que he implementado desde 2013, cogiendo las ideas más interesantes en cada caso.

Su modo de empleo está inspirado en Laravel/Symfony (aunque sus ancestros se inspiraban en CodeIgniter), lo que deriva en una transición muy sencilla desde FastLight hacia Laravel, Symfony u otros frameworks MVC sobre PHP.	    
		   
<h2>Características</h2>
		    	
Como todo framework, dispone de herramientas para facilitar las tareas necesarias para llevar a buen término un proyecto web, de forma rápida y organizada.

<h3>Lo que incorpora de serie:</h3>

- Patrón de diseño MVC con kernels distintos para aplicaciones web y apis restful. 
- Dispatcher con mapeo directo de URL a controlador y metodo.
- ORM completo, compatible con mysqli y PDO.
- Autoload mediante mapa de clases.
- Gestión integrada de errores y herramientas de depuración.
- Registo en ficheros (log).
- Motor de plantillas con templates intercambiables.
- CSS con multitud de clases para facilitar la tarea de maquetación.
- Mecanismos para diseños adaptables con flex layout 
- Sistema para tests unitarios.
- Motor de estadísticas para analizar las visitas a las distintas URLs del proyecto.
- Mecanismos de búsqueda y paginación de resultados.
- Autenticación y autorización basada en roles.
- Librerias para trabajar con XML, JSON y CSV.
- Herramientas de exportacion de datos a múltiples formatos.
- Protección CSRF para formularios y APIs.
- Herramientas para generación rápida de APIs restful.
- Multitud de librerías para las funcionalidades habituales: trabajo con ficheros y directorios, subida de ficheros, bases de datos...
- Ejemplos, documentación, tutoriales y manuales para clase.
- ...

<h3>Lo que se desarrolla en clase:</h3>

- Formulario de contacto con envío de email.
- Espacio personal (home).
- Operaciones de registro y baja de usuario.
- Gestión de usuarios y roles.
- Otras operaciones del administrador.
- Aplicaciones de gestión completas.
- APIs restful.
- ...
                        
<h3>Lo que incoroprará en futuras versiones:</h3>
                       
- API Keys.
- Router.
- Configuración de entorno .env.
- Middleware.
- ...
    				
  
<h2>IMPORTANTE</h2>
En unos meses se hará pública la documentación sobre cómo implementar proyectos web completos haciendo uso de este framework. Estad atentos a mi <a href='https://www.linkedin.com/in/robert-sallent-l%C3%B3pez-4187a866'>LinkedIn</a>.
 
<h2>Requisitos</h2>

En docencia trabajamos cada año con las últimas versiones de PHP. En este sentido, el código del framework se va adaptando para funcionar en versiones nuevas, eliminando el soporte para las antiguas.

Actualmente, la versión 1.8.0 del framework ha sido testeada en PHP 8.2 con MySQL 5.7, MySQL 8+ y MariaDB 10.4+. Esto no quiere decir que no funcione en versiones ligeramente anteriores o posteriores, pero no se garantiza que lo haga.

<h2>Consideraciones</h2>

Ha sido desarrollado completamente desde cero por <a href="https://robertsallent.com">Robert Sallent</a> y no tiene dependencias con paquetes externos. Su funcionamiento se explica en detalle en los cursos de <a href="https://php.net">PHP</a> y desarrollo web, que imparte desde 2010, en distintos <a href="https://serveiocupacio.gencat.cat/es/soc/com-ens-organitzem/centres-propis-formacio-cifo-cfpa/centres-dinnovacio-i-formacio-ocupacional-cifo/index.html">Centros de Innovación y Formación Ocupacional</a> (CIFO) de la província de Barcelona para la Generalitat de Catalunya.
        		   	   
     		   
<h2>Licencia</h2>    

FastLight se distribuye bajo licencia <b>GPL 3.0</b>, con lo que puedes usarlo libremente para desarrolar aplicaciones web sin tener que pagar absolutamente nada. Solamente tienes la obligación de reconocer al autor (Robert Sallent).
  

Estas son algunas consideraciones a tener en cuenta:
- Eres libre de usar este framework para desarrollar aplicaciones web y APIs para uso particular y profesional.
- En docencia, puedes usar tanto el framework como los apuntes y tutoriales. Si creas apuntes derivados de los originales no puedes omitir la mención al autor.
- Puedes desarrollar aplicaciones web y distribuirlas libremente. 
- Puedes obtener ingresos con las aplicaciones desarrolladas a partir de FastLight, pero si pretendes distribuir versiones modificadas o derivadas del framework, debes mantenerlas como Open Source.
- Si te es útil en el trabajo y sacas rendimiento de él, plantéate la posibilidad de realizar una donación al autor.

Este software es Open Source, el autor (Robert Sallent) <b>no se hará responsable de los errores o fallos de seguridad que se pudieran producir y de los daños que pudieran derivar de ello</b>.

Se aceptan sugerencias y los reportes de errores serán tenidos en consideración, actualizando o corrigiendo los problemas lo antes posible.


