# INSTRUCCIONES API

## RESUMEN

El concepto detrás del trabajo es el de una base de datos de exoplanetas directamente fotografiados. Para ello se registran los exoplanetas en una tabla y las estrellas correspondientes a ellos en otra. Esto tiene sentido en el contexto del trabajo porque hay estrellas que tienen varios planetas. Hay dos recursos accesibles mediante la API: "exoplanet" y "star". Ambos tienen cinco atributos.

Exoplanet tiene: `[(string) "name", (float) "mass", (float) "radius", (string) method, (string) star]`. Method y star son FOREIGN KEYS que en la tabla de la base de datos se manejan por las IDS correspondientes, pero no hace falta saber las ids para hacer requests. Basta con poner el nombre correspondiente al method y a la star bien escrito.

Star tiene: `[(string) "name", (float) "mass", (float) "radius", (float) distance, (string) type]`. Ninguna es FK así que puede crearse cualquier estrella sin restricción. Sería un equivalente a "categoría" en una tabla de productos, si se quiere.

## REQUESTS

### TOKEN
Para poder hacer una request de POST, PUT o DELETE primero es necesario tener un token TEMPORAL de autorización (dura sólo TRES MINUTOS). Esta autorización se debe pedir a `.../api/auth/token` con un header que especifique `Authorization: Basic username:password`. Ya hay registrados un par de usuarios para hacer pruebas. El más sencillo es:

`user:` invitado
`password:` 123

Si quieren otro usuario pueden entrar a la página de registro (`.../register`) y registrarse.

Luego hay que usar el token que consiguieron en sus próximas requests que no sean GET, poniendo en el header `Authorization: Bearer {token}`.

### GET (todo)

Una request GET `.../api/exoplanets` dará como resultado TODOS los exoplanetas de la tabla ordenadas por nombre de forma ascendente. Equivalentemente, una request GET `.../api/stars` dará TODAS las estrellas de la tabla ordenadas de la misma forma.

SORT Y ORDER: para cambiar el parámetro de referencia a partir del cual se ordena, basta con enviar en la request GET un `sort=atributo` y un `order=asc` o bien `order=desc`. Por ejemplo, `.../api/exoplanets/sort=method&order=desc` dará como resultado todos los exoplanetas ordenados de forma descendiente según la columna "method".

PAGINACIÓN: para paginar los resultados hace falta agregar los parámetros `page=n&limit=m` con n y m números. Por ejemplo, para sacar la página 2 de una paginación de 10 elementos, ordenados por "radius", en orden descendente, se podría hacer la siguiente request: `.../api/exoplanets/sort=radius&order=desc&page=2&limit=10`.

FILTRO: para filtrar los resultados en base a un atributo, basta con elegir alguno de los cinco atributos de cada tabla y dar un valor para ese atributo. Por ejemplo, `.../api/stars?name=coco` va a devolver todas las estrellas que se llamen coco. Además, se puede especificar un atributo "contains". Por ejemplo, `.../api/exoplanets?name=s&contains=true` va a devolver todas las estrellas que contengan una s en su nombre. "contains" por default es falso, pero se puede especificar `contains=false`.


Un ejemplo de request que hace uso de TODO, sería el siguiente:

`.../api/exoplanets?sort=radius&order=asc&page=2&limit=6&contains=true&name=a`

que traerá los segundos (page=2) 6 exoplanetas (exoplanets, limit=6), ordenados según su radio (sort=radius) en orden ascendente (order=asc), que contengan (contains=true) la letra a en su nombre (name=a).

ERRORES: Si se eligen valores no válidos para los parámetros, la API arrojará un error 400 (Bad Request). Por ejemplo, si order no es asc o desc (con cualquier combinación de mayúsculas y minúsculas) o si page y/o limit no son númericos, o si se pide filtrar por atributos que no existen, o si se especifican funciones no soportadas.


### GET (un elemento)

Una request GET `.../api/exoplanet/:ID` donde ":ID" es un número, dará como resultado el exoplaneta asociado a esa id. Similarmente GET `.../api/star/:ID` dará la estrella asociada a esa ID.


### POST

Para hacer una request POST, la URI será `.../api/exoplanet` o `.../api/star` y el body debe ser un JSON. 

En el caso de ser un exoplaneta, según lo estipulado en el resumen, deberá tener los atributos especificados. Por ejemplo, una request POST podría contener el siguiente body:

``{
    "name": "coco planeta",
    "mass": "2.2",
    "radius": "1.3",
    "method": "KLIP",
    "star": "AB Aurigae"
}``

donde "KLIP" es un método registrado en la lista y "AB Aurigae" también es una estrella de la lista. La lista de métodos puede consultarse en el home de la página web (o pidiendo todos los exoplanetas y viendo qué métodos hay disponibles) y las estrellas pueden obtenerse con un GET o también en las tablas de la página web. Al ser Foreign Keys, si no son valores preexistentes en las otras tablas la API arrojará error.

En el caso de ser una estrella, deberá enviarse un JSON como el del siguiente ejemplo:

``{
    "name": "coco estrella",
    "mass": "2.3",
    "radius": "1.7",
    "distance": "19.5",
    "type": "AKJ"
}``

Donde no hay restricción para ningún atributo.

### PUT
Para hacer una request POST, la URI será `.../api/exoplanet/:ID` o `.../api/star/:ID` y el body debe ser un JSON, de forma equivalente a lo que se sugirió para el método POST. Aquí ":ID" también es el número de ID del objeto de la tabla A SER REEMPLAZADO. 


### DELETE
Para hacer una request DELETE, la URI será `.../api/exoplanet/:ID` o `.../api/star/:ID`, al igual que antes.





# Sobre la página

USUARIO Y CONTRASEÑA PARA PODER EDITAR DESDE LA PÁGINA: 

`user:` invitado 
`password:` 123

O bien registrarse.

## Explicación del trabajo:

### Sobre las tablas: 

La base de datos tiene CUATRO TABLAS: exoplanets, stars, methods y users. Exoplanets es la tabla principal, que tiene dos foreign keys, que representan la id de una star y la id de un method. Users guarda usuarios y contraseñas hasheadas mediante Argon2ID.

### Sobre la página:

En total hay CUATRO MVC. Cada una de las tablas es operada por un Model y tiene su propio Controller y View, SALVO el model para la tabla methods que es operado por el NavController. NavController es el controller que se encarga únicamente de la navegación por la página y hace uso de ese model en particular porque lo necesita para renderizar cierto contenido, pero nada más: el contenido de methods no es editable de ninguna forma. MessageHelper es simplemente un ayudante que se invoca en los controllers para manejar las páginas de error (por ejemplo, al querer entrar a páginas restringidas o que no existen) y mensajes HTTP para que JavaScript los renderice en la página.

La página está armada fundamentalmente en SSR, porque encontré más cómodo traer el HTML ya armado desde el servidor, hacer el control de sesión mediante $_SESSION y mostrarlo con un JavaScript sencillo que rehacer todo el código JS para pedir o enviar los datos por la API y hacer un sistema de autorización con tokens manejados desde JS.

### Explicación de la estructura de los archivos: 

En la carpeta "src" se encuentran todos los Models, Views, Controllers y Helpers que corresponden a la página web. 
ParentView es una clase padre para todas las otras Views y el Helper. 
Model es una clase padre SÓLO para ExoplanetModel y StarModel.
Controller es una clase padre SÓLO para ExoplanetController y StarController. 
Siempre que fue posible elevar métodos y atributos repetidos o extremadamente similares a clases padres, traté de hacerlo. 
Las carpetas "data-manipulation" están para separar un poco mejor aquellos modelos y controladores que se dedican exclusivamente a la manipulación de los datos en las tablas.

En la carpeta "api" se encuentran los controller y la view para operar las tablas de Exoplanets y Stars mediante la API. Estos controllers hacen uso de los models en la carpeta src, es decir, los que hice para la página.

El método más complejo es el del GET general de la API, porque es el que se encarga de ordenar, filtrar y paginar.
