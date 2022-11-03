<?php
require_once "src/model/UserModel.php";
require_once "MessageController.php";

class UserController{
    private $model;
    private $data;
    private $session;

    public function __construct(){
        $this->model = new UserModel();
        $this->data = json_decode(file_get_contents("php://input"));
        $this->session = isset($_SESSION['username']);
    }

    public function checkLogIn(){
        if($this->data != null){
            $user = $this->model->getUserData($this->data->username);

            if (!empty($user) && password_verify($this->data->password, $user->password)) {
                $_SESSION['username'] = $user->user;
                (new MessageController())->HTTPMessage(200, "Log in successful!");
            } else {
                (new MessageController())->HTTPMessage(401,'Authentication error. Username or password are incorrect.');
            }
        }
        else{
            (new MessageController())->HTTPMessage(400);
        }
    }

    public function addUser(){
        if(($this->data != null) && (!$this->session)){
            $hash = password_hash($this->data->password, PASSWORD_ARGON2ID);
            $success = $this->model->insertNewUser($this->data->username, $hash);

            if($success){
                (new MessageController())->HTTPMessage(201, 'Congratulations! New user created.');
            }
            else{
                (new MessageController())->HTTPMessage(409, 'Error. Username is already in use.');
            }
        }
        else if($this->session){
            (new MessageController('cantregister'))->errorPage();
        }
        else{
            (new MessageController())->HTTPMessage(400);
        }
        
    }

    public function logOut(){
        if($this->session){
            session_destroy();
            header('Location: home');
        }
        else{
            (new MessageController('notlogged'))->errorPage();
        }
        
    }
}