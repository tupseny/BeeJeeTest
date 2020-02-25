<?php


class LoginController extends Controller
{
    function __construct()
    {
        $this->model = new LoginModel();
        $this->view = new View();
    }

    private function setErrorCookie($val){
        setcookie('error', $val, time()+60, '/login');
    }

    function index_action()
    {
        $data = [];
        if (
            isset($_POST['username']) and
            isset($_POST['password'])
        ){
            try{
                $this->login();
            }catch (Exception $e){
                switch ($e->getCode()){
                    case MyExceptions::USER_INVALID_CRED:
                        $this->setErrorCookie('invalid_credentials');
                        break;

                }

                $this->redirect('/login');
            }

        }

        if (isset($_POST['logout'])) {
            $this->logout();
        } else {
            $this->view->show('login.view.php');
        }
    }

    function logout()
    {
        $this->model->logout();
        $this->redirect('/');
    }

    function login()
    {
        $args = $_POST;

        try {
            $this->authorise($args);
        } catch (Exception $e) {
            throw $e;
        }

        $this->redirect('/');
    }

    private function authorise($args)
    {
        $username = $args['username'];
        $pass = $args['password'];

        $this->model->authorise($username, $pass);
    }
}