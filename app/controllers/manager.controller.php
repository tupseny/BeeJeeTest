<?php

include_once HELPERS_DIR . '/DataSorter.php';

class ManagerController extends Controller
{
    const SORT_KEY_KEY = 'sort_key';
    const SORT_MODE_KEY = 'sort_mode';
    const DATA_KEY = 'data';
    const PAGE_KEY = 'page';
    const SORT_MODE_ASC = 'asc';
    const SORT_MODE_DESC = 'desc';

    const SORT_FIELDS = [
        ManagerModel::USERNAME_KEY,
        ManagerModel::EMAIL_KEY,
        ManagerModel::STATE_KEY,
    ];

    function __construct($args, $style, $script)
    {
        parent::__construct($args, $style, $script);
        $this->model = new ManagerModel();
    }

    function setCookie($key, $val)
    {
        setcookie($key, $val, 0, '/manager');
    }

    function index_action()
    {
        try {
            /*
         * Get PAGE to show
         * 1. Try to get the page from GET params
         * 2. Try to get the page from COOKIES
         * 3. Set default page - 1
         * */
            $page = $this->getPathArg(0) ?? $_COOKIE[self::PAGE_KEY] ?? 1;

            $page = $page <= 0 ? 1 : $page;
            $this->setCookie(self::PAGE_KEY, $page);

//        Check sort options
            $sort_key = $_COOKIE[self::SORT_KEY_KEY] ?? null;
            $sort_mode = $_COOKIE[self::SORT_MODE_KEY] ?? null;

//        Get data with options
            $data = $this->model->getData($page, $sort_key, $sort_mode);

            header("Cache-Control:no-store, no-cache, must-revalidate, max-age=0");

            $this->view->show('manager.view.php', $data);
        }catch (Exception $e){
           throw $e;
        }
    }

    function clean_action()
    {
        $this->model->deleteAll();
        $this->redirect('/manager');
    }

    function update_action()
    {
        if (isset($_POST[self::DATA_KEY])) {
            $data = json_decode($_POST[self::DATA_KEY], TRUE);

            try {
                $this->validataToken();
                $this->model->updateValues($data);
            } catch (Exception $e) {
                switch ($e->getCode()) {
                    case MyExceptions::USER_FORBIDDEN:
                        echo $e->getMessage() . '(CODE: ' . $e->getCode() . ')';
                        break;
                    default:
                        throw $e;
                }
            }
        }
    }

    private function validataToken()
    {
        if (!isset($_COOKIE[ManagerModel::TOKEN_KEY]) or !isset($_COOKIE[ManagerModel::USER_ID_KEY])) {
            throw new Exception('no-permissions', MyExceptions::USER_FORBIDDEN);
        }
    }

    function sort_action()
    {
        foreach (self::SORT_FIELDS as $item) {
            if ($this->processSortData($item)) {
                $this->redirect('/manager');
            }
        }
    }

    function processSortData($key)
    {
        if (isset($_POST[$key])) {
            $sort_mode = $_POST[$key];
            switch ($sort_mode) {
                case self::SORT_MODE_DESC:
                    $sort_mode = DataSorter::DESC_MODE;
                    break;
                case self::SORT_MODE_ASC:
                    $sort_mode = DataSorter::ASC_MODE;
                    break;
                default:
                    throw new Exception("invalid sort mode. Should be 'asc' or 'desc' but got '${sort_mode}'", MyExceptions::REQUEST_INVALID_FIELD_VALUE);
            }

            $this->setCookie(ManagerController::SORT_MODE_KEY, $sort_mode);
            $this->setCookie(ManagerController::SORT_KEY_KEY, $key);
            return true;
        }
        return false;
    }
}