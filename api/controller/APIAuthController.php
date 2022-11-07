<?php
require_once "src/model/UserModel.php";
require_once "api/view/APIView.php";
require_once "api/helper/APIAuthHelper.php";
require_once "api/Configuration.php";

class APIAuthController
{
    private $model;
    private $view;
    private $helper;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->view = new APIView();
        $this->helper = new APIAuthHelper();
    }

    public function getToken()
    {
        $user = $this->helper->getBasicUserAndPass();

        if ($user === 400) {
            $this->view->showMessage('Wrong headers.', 400);
            return;
        }

        $data = $this->model->getUserData($user->username);

        if (!empty($data) && password_verify($user->password, $data->password)) {
            $token = $this->helper->constructToken($user->username);
            $this->view->showData($token, 200);
        } else {
            $this->view->showMessage('Username or password are incorrect.', 401);
        }
    }
}
