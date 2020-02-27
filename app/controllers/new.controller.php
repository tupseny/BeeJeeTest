<?php


class NewController extends Controller
{
    function __construct()
    {
        $this->view = new View();
        $this->model = new NewModel();
    }

    function index_action()
    {
        $this->view->show('new.view.php');
    }

    function add_action()
    {
        $args = $_POST;

        try {
            $this->sendNewData($args);
        } catch (Exception $e) {
            throw $e;
        }

        setcookie('feedback', 'success', ['path' => '/', 'samesite' => 'None', 'expires' => time()+60]);
        $this->redirect('/manager');
    }

    private function sendNewData($data)
    {
        $this->model->add($data);
    }
}