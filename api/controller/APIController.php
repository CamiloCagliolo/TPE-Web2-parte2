<?php
require_once "api/view/APIView.php";
require_once "api/Configuration.php";
require_once "api/Helper/APIAuthHelper.php";

class APIController
{
    protected $model;
    protected $view;
    protected $data;
    protected $authorized;

    public function __construct()
    {
        $this->view = new APIView();
        $this->data = json_decode(file_get_contents("php://input"));
        $payload = (new APIAuthHelper())->getPayload();
        $this->authorized = isset($payload->username) && isset($payload->exp) && $payload->exp > time();
    }

    protected function getAllData($validColumns)
    {
        //Chequea que todos los parámetros enviados por GET sean válidos.
        if(!$this->checkRequests($validColumns)){
            $this->view->showMessage('Bad request: some requirements are not supported or are not valid.', 400);
            return;
        }

        //Valores por defecto
        $sort = 'name';
        $order = 'ASC';
        $filter = $this->readFilter($validColumns);
        $filterValue = null;
        $contains = false;
        
        
        //Si se detectó un filtro, busca qué valor tiene y busca si el usuario definió el criterio "contains".
        if ($filter != null) {
            $filterValue = $_GET[array_keys($validColumns, $filter)[0]];

            if(isset($_GET["contains"])){
                switch(strtolower($_GET["contains"])){
                    case "true":
                        $contains = true;
                        break;
                    case "false":
                        $contains = false;
                        break;
                    default:
                        $this->view->showMessage('Bad request. "Contains" parameter has to be true or false.', 400);
                        return;
                }
            }
        }

        //Si se definió un criterio de ordenado, aquí se detecta.
        if(isset($_GET['sort'])){
            if(array_key_exists($_GET['sort'], $validColumns)){
                $sort = $_GET['sort'];
            }
            else{
                $this->view->showMessage('Bad request. Sort value has to be a valid attribute.', 400);
                return;
            }
        }

        //Si se definió un orden, aquí se detecta.
        if(isset($_GET['order'])){
            if(strtoupper($_GET['order']) == 'ASC' || strtoupper($_GET['order']) == 'DESC'){
                $order = strtoupper($_GET['order']);
            }
            else{
                $this->view->showMessage('Bad request. Order value has to be ASC or DESC.', 400);
                return;
            }
        }

        $data = $this->model->getAllData($sort, $order, $filter, $filterValue, $contains);

        //Paginación. Si no se envió nada no se pagina, si se enviaron valores de paginación se recorta el array según lo especificado por el usuario.
        $page = null;
        $limit = null;

        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        if(isset($_GET['limit'])){
            $limit = $_GET['limit'];
        }

        if (is_numeric($page) && is_numeric($limit)) {
            $page = intval($page) - 1;
            $limit = intval($limit);

            $data = array_slice($data, $page * $limit, $limit);
        }
        else if((!is_numeric($page) || !is_numeric($limit)) && ($page != null || $limit != null)){
            $this->view->showMessage('Both page and limit have to be numeric values.', 400);
            return;
        }
        else if (is_numeric($page) && $limit == null){
            $this->view->showMessage('Specify a limit value for your pagination.', 400);
            return;
        }
        if ($data != null) {
            $this->view->showData($data);
        } else {
            $this->view->showMessage('Nothing found for this request criteria.', 404);
        }
    }

    public function getOne()
    {
        $params = explode('/', $_GET['resource']);
        $id = array_pop($params);
        $data = $this->model->getDataById($id);
        if ($data != null) {
            $this->view->showData($data);
        } else {
            $this->view->showMessage('Resource not found.', 404);
        }
    }

    public function deleteEntity()
    {
        if ($this->authorized) {
            $params = explode('/', $_GET['resource']);
            $id = array_pop($params);
            $success = $this->model->delete($id);
            if ($success) {
                $this->view->showMessage('Deletion successful.');
            } else {
                $this->view->showMessage("Unable to delete the requested item. If you're trying to delete a star, make sure it has no exoplanets associated.", 400);
            }
        } else {
            $this->view->showMessage('Check your credentials and try again.', 401);
        }
    }

    protected function add($entity)
    {
        if ($this->authorized) {
            $success = $this->model->insert($entity);
            if ($success) {
                $this->view->showMessage('Addition successful.', 201);
            } else {
                $this->view->showMessage("Addition failed. If you're trying to add an exoplanet, make sure that the method and the star that you're trying to assign exist beforehand, and try again.", 400);
            }
        } else {
            $this->view->showMessage('Check your credentials and try again.', 401);
        }
    }

    public function replace()
    {
        if ($this->authorized) {
            $params = explode('/', $_GET['resource']);
            $id = array_pop($params);
            $this->data->id = $id;
            $success = $this->model->update($this->data);
            if ($success) {
                $this->view->showMessage('Edition successful.');;
            } else {
                $this->view->showMessage("Edition failed. If you're trying to add an exoplanet, make sure that the method and the star that you're trying to assign exist beforehand, and try again.", 400);
            }
        } else {
            $this->view->showMessage('Check your credentials and try again.', 401);
        }
    }

    public function returnError()
    {
        $this->view->showMessage('Resource not found. Check your syntax.', 404);
    }

    protected function readFilter($validColumns)
    {
        foreach (array_keys($validColumns) as $column) {
            if (isset($_GET[$column])) {
                return $validColumns[$column];
            }
        }
        return null;
    }

    protected function checkRequests($validColumns){
        $validRequests = array_merge(VALID_REQUESTS, array_keys($validColumns));
        foreach(array_keys($_GET) as $request){
            if(!in_array($request, $validRequests)){
                return false;
            }
        }
        return true;
    }
}
