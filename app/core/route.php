<?php

//session_unset();

class Route
{
    private static function processClassName(string $val, $suffix = '')
    {
        $val = strtolower($val);
        $val = ucfirst($val);

        $val = $val . $suffix;
        if (is_numeric($val[0])) {
            array_unshift($var, '_');
        }

        return $val;
    }

    private static function processFileName(string $val, $suffix = '', $extension = '')
    {
        $val = strtolower($val);
        $extension = $extension[0] === '.' ? $extension : '.' . $extension;

        $val = $val . $suffix . $extension;

        return $val;
    }

    private static function processActionName(string $val, $suffix = '')
    {
        $val = strtolower($val);
        return $val . $suffix;
    }

    private static function clearPathFromArgs($path)
    {
        $temp = explode('?', $path);
        return $temp[0];
    }

    private static function processRoutes($URI)
    {
        $URI = self::clearPathFromArgs($URI);
        return explode('/', $URI);
    }

    static function start()
    {

//        define default values
        $controller_name = 'Main';
        $action_name = 'index';
        $args = [];

        $routes = self::processRoutes($_SERVER['REQUEST_URI']);

//        Getting requested route:
//        CONTROLLER's name
        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        }
//        ACTION's name
        if (!empty($routes[2])) {
            $action_name = $routes[2];
        }

        /*
         * Get path arguments. All after action and before GET args
         * Ex: sample.com/controller/action/arg1/arg2/arg3
         * arg1, arg2, arg3 are path arguments;
         * */
        for ($i = 3; $i < count($routes); $i++) {
            array_push($args, $routes[$i]);
        }

//        Process names to be valid
        $model_file = self::processFileName($controller_name, MODEL_FILE_SUFFIX, '.php');
        $controller_file = self::processFileName($controller_name, CONTROLLER_FILE_SUFFIX, '.php');
        $style_file = self::processFileName($controller_name, STYLE_FILE_SUFFIX, '.css');
        $script_file = self::processFileName($controller_name, SCRIPT_FILE_SUFFIX, '.php');
        $controller_name = self::processClassName($controller_name, CONTROLLER_CLASS_SUFFIX);
        $action_name = self::processActionName($action_name, ACTION_METHOD_SUFFIX);

//        Include MODEL file if exists
        $model_path = MODELS_DIR . '/' . $model_file;
        if (file_exists($model_path)) {
            include $model_path;
        }

//        Include CONTROLLER file
        $controller_path = CONTROLLERS_DIR . '/' . $controller_file;
        if (file_exists($controller_path)) {
            include $controller_path;
        } else {
//            todo: throw exception
            header('Location: /');
            exit;
//            ErrorRoute::page404();
        }

//        Create controller's instance for current request
        $controller = new $controller_name($args, $style_file, $script_file);
        $action = $action_name;

//        Invokes action (function of controller)
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            throw new Exception("no such action '${action}' for controller '${controller}'", MyExceptions::REQUEST_NO_ACTION);
        }
    }
}