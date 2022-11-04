<?php
require_once "libs/Router.php";
require_once "api/controller/APIExoplanetController.php";
require_once "api/controller/APIStarController.php";

$router = new Router();

$router->addRoute("exoplanets", "GET", "APIExoplanetController", "getAll"); 
$router->addRoute("exoplanet/:ID", "GET", "APIExoplanetController", "getOne");
$router->addRoute("exoplanet", "POST", "APIExoplanetController", "addExoplanet");
$router->addRoute("exoplanet/:ID", "PUT", "APIExoplanetController", "replace");
$router->addRoute("exoplanet/:ID", "DELETE", "APIExoplanetController", "deleteEntity");

$router->addRoute("stars", "GET", "APIStarController", "getAll");
$router->addRoute("star/:ID", "GET", "APIStarController", "getOne");
$router->addRoute("star", "POST", "APIStarController", "addStar");
$router->addRoute("star/:ID", "PUT", "APIStarController", "replace");
$router->addRoute("star/:ID", "DELETE", "APIStarController", "deleteEntity");

$router->addRoute("auth/token", "GET", "APIAuthController.php", "getToken");

$router->setDefaultRoute("APIController", "returnError");

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

