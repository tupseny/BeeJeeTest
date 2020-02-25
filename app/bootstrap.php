<?php

require_once HELPERS_DIR . '/' . 'StatusCodes.php';
require_once HELPERS_DIR . '/MyExceptions.php';
require_once HELPERS_DIR . '/Authentication.php';

require_once APP_DIR . '/session.php';
require_once APP_DIR . '/fake.database.php';
FakeDB::init();

require_once CORE_DIR . '/' . 'model.php';
require_once CORE_DIR . '/' . 'view.php';
require_once CORE_DIR . '/' . 'controller.php';

require_once CORE_DIR . '/' . 'route.php';
require_once CORE_DIR . '/' . 'error-route.php';
Route::start();