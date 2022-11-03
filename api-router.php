<?php
require_once "libs/Router.php";
require_once "api/controller/APIExoplanetController.php";
require_once "api/controller/APIStarController.php";

$router = new Router();

$router->addRoute("exoplanets", "GET", "APIExoplanetController", "getAll"); //DONE
$router->addRoute("exoplanet/:ID", "GET", "APIExoplanetController", "getOne");//DONE
$router->addRoute("exoplanet", "POST", "APIExoplanetController", "addExoplanet");
$router->addRoute("exoplanet/:ID", "PUT", "APIExoplanetController", "replaceExoplanet");
$router->addRoute("exoplanet/:ID", "DELETE", "APIExoplanetController", "deleteEntity");//DONE

$router->addRoute("stars", "GET", "APIStarController", "getAll");//DONE
$router->addRoute("star/:ID", "GET", "APIStarController", "getOne");//DONE
$router->addRoute("star", "POST", "APIStarController", "addStar");
$router->addRoute("star/:ID", "PUT", "APIStarController", "replaceStar");
$router->addRoute("star/:ID", "DELETE", "APIStarController", "deleteEntity");//DONE

$router->setDefaultRoute("APIController", "returnError");
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

