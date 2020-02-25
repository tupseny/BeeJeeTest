<?php

define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);

define('APP_DIR', ROOT_DIR . '/app');
define('CONTROLLERS_DIR', APP_DIR . '/controllers');
define('CORE_DIR', APP_DIR . '/core');
define('MODELS_DIR', APP_DIR . '/models');
define('VIEWS_DIR', APP_DIR . '/views');

define('HELPERS_DIR', ROOT_DIR . '/helpers');

define('CONTROLLER_FILE_SUFFIX', '.controller');
define('STYLE_FILE_SUFFIX', '.style');
define('SCRIPT_FILE_SUFFIX', '.script');
define('MODEL_FILE_SUFFIX', '.model');
define('VIEW_FILE_SUFFIX', '.view');

define('CONTROLLER_CLASS_SUFFIX', 'Controller');
define('MODEL_CLASS_SUFFIX', 'Model');
define('VIEW_CLASS_SUFFIX', 'View');

define('ACTION_METHOD_SUFFIX', '_action');

define('SECRET', 'some secret sentence');