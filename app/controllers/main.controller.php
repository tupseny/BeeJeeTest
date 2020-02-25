<?php


class MainController extends Controller
{
    function index_action()
    {
        header('Location: /manager');
        exit;
    }
}