-------------------------------------------------INSTRUCCIONES API------------------------------------------------------

-----------------------------------------------------RESUMEN------------------------------------------------------------

El concepto detrás del trabajo es el de una base de datos de exoplanetas directamente fotografiados. Para ello se registran los exoplanetas en una tabla y las estrellas correspondientes a ellos en otra. Esto tiene sentido en el contexto del trabajo porque hay estrellas que tienen varios planetas. Hay dos recursos accesibles mediante la API: "exoplanet" y "star". Ambos tienen cinco atributos.

Exoplanet tiene: [(string) "name", (float) "mass", (float) "radius", (string) method, (string) star]. Method y star son FOREIGN KEYS que en la tabla de la base de datos se manejan por las IDS correspondientes, pero no hace falta saber las ids para hacer requests. Basta con poner el nombre correspondiente al method y a la star bien escrito.

Star tiene: [(string) "name", (float) "mass", (float) "radius", (float) distance, (string) type]. Ninguna es FK así que puede crearse cualquier estrella sin restricción. Sería un equivalente a "categoría" en una tabla de productos, si se quiere.

----------------------------------------------------REQUESTS------------------------------------------------------------


--------GET (todo)-------

Una request GET .../api/exoplanets dará como resultado TODOS los exoplanetas de la tabla ordenadas por nombre de forma descendente. Equivalentemente, una request GET .../api/stars dará TODAS las estrellas de la tabla ordenadas de la misma forma.

SORT Y ORDER: para cambiar el parámetro de referencia a partir del cual se ordena, basta con enviar en la request GET un sort=parametro y un order=asc o bien order=desc. Por ejemplo, .../api/exoplanets/sort=method&order=desc dará como resultado todos los exoplanetas ordenados de forma descendiente según la columna "method".



--------GET (un elemento)------

Una request GET .../api/exoplanet/:ID donde ":ID" es un número, dará como resultado el exoplaneta asociado a esa id. Similarmente GET .../api/star/:ID dará la estrella asociada a esa ID.



-------POST-------

Para hacer una request POST, la URI será .../api/exoplanet o .../api/star y el body debe ser un JSON. 

En el caso de ser un exoplaneta, según lo estipulado en el resumen, deberá tener los siguientes atributos (ejemplo):

{
    "name": "coco planeta",
    "mass": "2.2",
    "radius": "1.3",
    "method": "KLIP",
    "star": "AB Aurigae"
}

donde "KLIP" es un método registrado en la lista y "AB Aurigae" también es una estrella de la lista. La lista de métodos puede consultarse en el home de la página web y las estrellas pueden obtenerse con un GET o también en las tablas de la página web.

En el caso de ser una estrella, deberá enviarse el siguiente JSON:

{
    "name": "coco estrella",
    "mass": "2.3",
    "radius": "1.7",
    "distance": "19.5",
    "type": "AKJ"
}




---------PUT--------
Para hacer una request POST, la URI será .../api/exoplanet/:ID o .../api/star/:ID y el body debe ser un JSON, de forma equivalente a lo que se sugirió para el método POST. Aquí ":ID" también es el número de ID del objeto de la tabla A SER REEMPLAZADO. 




---------DELETE-----
Para hacer una request DELETE, la URI será .../api/exoplanet/:ID o .../api/star/:ID, al igual que antes.





--------------------------------------NOTAS EXTRA PARA EL PROFESOR INTERESADO-------------------------------------------
En esta segunda versión del trabajo, además de cumplir con la consigna, traté de recuperar aquello que hice en la primera entrega. Sé que la consigna no incluía necesariamente reutilizar o rehacer lo anterior, pero dado que el anterior trabajo (https://github.com/CamiloCagliolo/TPE-Web-2) estaba muy mal hecho (me saqué un 4), decidí redimirme e intentar demostrar que la devolución no fue en vano, así que hice un refactoreo de todo el código (fue empezar de casi cero).

--------------------------------------------Explicación del trabajo:
----------Sobre las tablas: 
La base de datos tiene CUATRO TABLAS: exoplanets, stars, methods y users. Exoplanets es la tabla principal, que tiene dos foreign keys, que representan la id de una star y la id de un method. Users guarda usuarios y contraseñas hasheadas mediante Argon2ID.

----------Sobre la página:
En total hay CUATRO MVC. Cada una de las tablas es operada por un Model y tiene su propio Controller y View, SALVO el model para la tabla methods que es operado por el NavController. NavController es el controller que se encarga únicamente de la navegación por la página y hace uso de ese model en particular porque lo necesita para renderizar cierto contenido, pero nada más: el contenido de methods no es editable de ninguna forma. MessageHelper es simplemente un ayudante que se invoca en los controllers para manejar las páginas de error (por ejemplo, al querer entrar a páginas restringidas o que no existen) y mensajes HTTP para que JavaScript los renderice en la página.

----------Explicación de la estructura de los archivos: 
En la carpeta "src" se encuentran todos los Models, Views, Controllers y Helpers que corresponden a la página web. 
ParentView es una clase padre para todas las otras Views y el Helper. 
Model es una clase padre para todos los otros Models. 
Controller es una clase padre SÓLO para ExoplanetController y StarController. 
Siempre que fue posible elevar métodos y atributos repetidos o extremadamente similares a clases padres, traté de hacerlo. 
Las carpetas "data-manipulation" están para separar un poco mejor aquellos modelos y controladores que se dedican exclusivamente a la manipulación de los datos en las tablas.

En la carpeta "api" se encuentran los controller y views para operar las tablas de Exoplanets y Stars mediante API REST. Estos controllers hacen uso de los models en la carpeta src, es decir, los que hice para la página.