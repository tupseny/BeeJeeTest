<?php


class Controller
{
    public $model;
    public $view;
    private $args;

    function __construct($args = [], $style_file=null, $script_file=null)
    {
        $this->view = new View($style_file, $script_file);
        $this->args = $args;
    }

    function getPathArg($index)
    {
        $val = $this->args[$index] ?? null;

        return $val;
    }

    function index_action()
    {
    }

    protected function redirect($path)
    {
        header('Location: ' . $path);
        exit;
    }
}