<?php

class Route{
    private $url;
    private $verb;
    private $controller;
    private $method;
    private $params;

    public function __construct($url, $verb, $controller, $method){
        $this->url = $url;
        $this->verb = $verb;
        $this->controller = $controller;
        $this->method = $method;
        $this->params = [];
    }

    //Método para verificar que el objeto Route ya definido coincida con otra determinada ruta, pasada por parámetro.
    public function match($url, $verb){
        if($this->verb != $verb){                           //Verifica que coincida el verbo
            return false;
        }

        $partsURL = explode("/", trim($url, '/'));
        $partsRoute = explode("/", trim($this->url, '/'));

        if(count($partsRoute) != count($partsURL)){         //Verifica que la URL pasada por parámetro tenga la misma cantidad
            return false;                                   //de parámetros que la ruta definida para este objeto Route.
        }

        foreach($partsRoute as $key => $part){              //Una vez corroborado lo básico, pasa a chequear si cada parte
            if($part[0] != ":"){                            //individual de la Route coincide con al ruta del parámetro.
                if($part != $partsURL[$key]){               //DUDA: PARA QUÉ EL IF DONDE CORROBORA != ":". 
                    return false;
                }
            }
            else{
                $this->params[$part] = $partsURL[$key];
            }
        }

        return true;
    }

    public function run(){
        $controller = $this->controller;                    //Saca el método y los parámetros de los atributos y genera
        $method = $this->method;                            //un objeto del tipo indicado por la variable $controller
        $params = $this->params;                            //(presuntamente, un controlador) y llama al método con los
        (new $controller())->$method($params);              //parámetros correspondientes a esta Route.
    }
}

class Router{
    private $routeTable = [];
    private $defaultRoute;

    public function __construct(){
        $defaultRoute = null;
    }

    public function setDefaultRoute($controller, $method){
        $this->defaultRoute = new Route("", "", $controller, $method);
    }

    public function addRoute($url, $verb, $controller, $method){
        $this->routeTable[] = new Route($url, $verb, $controller, $method);
    }

    public function route($url, $verb){
        foreach($this->routeTable as $route){       //Le pide a sus Routes una por una que chequeen si su ruta coincide con
            if($route->match($url, $verb)){         //la pasada por parámetro. La que responde que sí es ejecutada y listo.
                $route->run();
                return;
            }
        }

        if($this->defaultRoute != null){            //Si ninguna contestó que sí entonces procede a ejecutar la ruta default,
            $this->defaultRoute->run();             //si es que está definida.
        }
    }
}