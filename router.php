<?php
require_once "libs/Router.php";
require_once "src/controller/NavController.php";
require_once "src/controller/UserController.php";
require_once "src/controller/MessageController.php";
require_once "src/controller/data-manipulation/ExoplanetController.php";
require_once "src/controller/data-manipulation/StarController.php";

session_start();
define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

$router = new Router();

$router->addRoute("home", "GET", "NavController", "sectionHome");

$router->addRoute("login", "GET", "NavController", "sectionLogin");
$router->addRoute("login", "POST", "UserController", "checkLogIn");
$router->addRoute("logout", "GET", "UserController", "logOut");

$router->addRoute("register", "GET", "NavController", "sectionRegister");
$router->addRoute("register", "POST", "UserController", "addUser");
$router->addRoute("terms", "GET", "NavController", "sectionTerms");

$router->addRoute("tables", "GET", "NavController", "sectionTables");
$router->addRoute("exoplanets", "GET", "ExoplanetController", "buildTable");
$router->addRoute("stars", "GET", "StarController", "buildTable");

$router->addRoute("select/stars", "GET", "NavController", "buildStarSelect");
$router->addRoute("select/methods/short", "GET", "NavController", "buildMethodSelect");
$router->addRoute("select/methods/long", "GET", "NavController", "buildMethodSelect");

$router->addRoute("tables/exoplanets", "PUT", "ExoplanetController", "replaceExoplanet");
$router->addRoute("tables/exoplanets/:ID", "DELETE", "ExoplanetController", "deleteExoplanet");

$router->addRoute("tables/stars", "PUT", "StarController", "replaceStar");
$router->addRoute("tables/stars/:ID", "DELETE", "StarController", "deleteStar");

$router->addRoute("add", "GET", "NavController", "sectionAdd");
$router->addRoute("add/exoplanets", "POST", "ExoplanetController", "addExoplanet");
$router->addRoute("add/stars", "POST", "StarController", "addStar");

$router->setDefaultRoute("MessageController", "errorPage");

$router->route($_GET['action'], $_SERVER['REQUEST_METHOD']);