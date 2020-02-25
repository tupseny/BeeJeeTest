<?php

include_once HELPERS_DIR . '/DataPagination.php';
include_once HELPERS_DIR . '/DataSorter.php';

class ManagerModel extends Model
{
    const USERNAME_KEY = 'username';
    const EMAIL_KEY = 'email';
    const STATE_KEY = 'is_completed';
    const TOKEN_KEY = 'token';
    const USER_ID_KEY = 'user_id';
    const ID_KEY = 'id';
    const IS_COMPLETED_KEY = 'is_completed';
    const BODY_KEY = 'body';
    const EDITED_BY_KEY = 'edited_by';

    public function updateValues($data)
    {
        if (!Authentication::authoriseByToken($_COOKIE[self::TOKEN_KEY], $_COOKIE[self::USER_ID_KEY])) {
            throw new Exception('no permissions', MyExceptions::USER_FORBIDDEN);
        }

        function updateIfNew($item, $key)
        {
            if (isset($item[$key])) {
                FakeDB::update(FakeDB::TASK_TABLE, $item[ManagerModel::ID_KEY], $key, $item[$key]);
                FakeDB::update(FakeDB::TASK_TABLE, $item[ManagerModel::ID_KEY], ManagerModel::EDITED_BY_KEY, 'Admin');
            }
        }

        foreach ($data as $item) {
            updateIfNew($item, self::IS_COMPLETED_KEY);
            updateIfNew($item, self::BODY_KEY);
        }
    }

    public function getData($page = 1, $sort_key = null, $sort_mode = DataSorter::ASC_MODE)
    {
        $data = $this->fetchAllTasks();

        if ($sort_key) {
            $data = $this->sortData($data, $sort_key, $sort_mode);
        }

        return $this->processData($data, (int)$page);
    }

    public function deleteAll(){
        FakeDB::deleteAll(FakeDB::TASK_TABLE);
    }

    private function sortData($data, $key, $mode)
    {
        $sorter = new DataSorter($data);
        return $sorter->sort($key, $mode);
    }

    private function fetchAllTasks()
    {
        return FakeDB::getData(FakeDB::TASK_TABLE);
    }

    private function isLogged()
    {
        return isset($_COOKIE[self::TOKEN_KEY]) and $_COOKIE[self::TOKEN_KEY] and
            isset($_COOKIE[self::USER_ID_KEY]) and is_numeric($_COOKIE[self::USER_ID_KEY]);
    }

    private function processData($data, int $page)
    {
        $paginator = new DataPagination($data, DataPagination::DEFAULT_DATA_PER_PAGE);

//        If given page is more than their count then set it as max
        $page = $page <= $paginator->getPageCount() ? $page : $paginator->getPageCount();

        return [
            'tasks' => $paginator->getSplittedData()[$page],
//            'tasks' => $data,
            'page_count' => $paginator->getPageCount(),
            'page' => $page,
        ];
    }
}