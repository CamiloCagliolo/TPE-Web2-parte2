<?php
require_once "libs/Router.php";
require_once "src/controller/NavController.php";
require_once "src/controller/UserController.php";
require_once "src/helper/MessageHelper.php";
require_once "src/controller/data-manipulation/ExoplanetController.php";
require_once "src/controller/data-manipulation/StarController.php";

session_start();

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

$router = new Router();

if ($_GET['action'] == "") {
    $_GET['action'] = "home";
    $_SERVER['REQUEST_METHOD'] = "GET";
}

$router->addRoute("home", "GET", "NavController", "sectionHome"); //HOME

$router->addRoute("login", "GET", "NavController", "sectionLogin"); //TODO LO RELACIONADO AL LOGIN/LOGOUT
$router->addRoute("login", "POST", "UserController", "checkLogIn");
$router->addRoute("logout", "GET", "UserController", "logOut");

$router->addRoute("register", "GET", "NavController", "sectionRegister"); //TODO LO RELACIONADO AL REGISTRO
$router->addRoute("register", "POST", "UserController", "addUser");
$router->addRoute("terms", "GET", "NavController", "sectionTerms");

$router->addRoute("tables", "GET", "NavController", "sectionTables"); //PANTALLA DE TABLAS Y TABLAS EN SÍ
$router->addRoute("exoplanets", "GET", "ExoplanetController", "buildTable");
$router->addRoute("stars", "GET", "StarController", "buildTable");

$router->addRoute("select/stars", "GET", "NavController", "buildStarSelect"); //RUTAS PARA ACCEDER A LA CONSTRUCCIÓN DE  
$router->addRoute("select/methods/short", "GET", "NavController", "buildMethodSelect"); //SELECTS DINÁMICOS
$router->addRoute("select/methods/long", "GET", "NavController", "buildMethodSelect");

//-----RUTAS PARA LOS BOTONES DE EDITAR Y BORRAR DE LAS TABLAS, TANTO EXOPLANETAS COMO ESTRELLAS-----------
$router->addRoute("tables/exoplanets/:ID", "PUT", "ExoplanetController", "replace");
$router->addRoute("tables/exoplanets/:ID", "DELETE", "ExoplanetController", "delete");

$router->addRoute("tables/stars/:ID", "PUT", "StarController", "replace");
$router->addRoute("tables/stars/:ID", "DELETE", "StarController", "delete");
//---------------------------------------------------------------------------------------------------------

$router->addRoute("add", "GET", "NavController", "sectionAdd"); //RUTAS PARA AÑADIR ITEMS A LAS LISTAS
$router->addRoute("add/exoplanets", "POST", "ExoplanetController", "addExoplanet");
$router->addRoute("add/stars", "POST", "StarController", "addStar");

$router->setDefaultRoute("MessageHelper", "showError"); //DEFAULT: ERROR 404

$router->route($_GET['action'], $_SERVER['REQUEST_METHOD']);
