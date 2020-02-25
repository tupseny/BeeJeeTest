<?php


class FakeDB
{
    const TASK_TABLE = 'Task';
    const USER_TABLE = 'User';

    private static $_data = [];

    private static function save(){
        SessionManager::save('db', self::$_data);
    }

    private static function load(){
        try {
            self::$_data = SessionManager::load('db');
        }
        catch (Exception $e){
            if ($e->getCode() !== MyExceptions::SESSION_NO_KEY){
                self::$_data = [];
            }
        }

    }

    public static function deleteAll($entity){
        self::$_data[$entity] = [];
        self::save();
    }

    private static function createSequence($name)
    {
        self::$_data[$name . 'Sequence'] = 1;
    }

    private static function getNextId($name)
    {
        $id = self::$_data[$name . 'Sequence'];
        self::$_data[$name . 'Sequence']++;
        return $id;
    }

    public static function &findId($entity, $id)
    {
        if (!isset(self::$_data[$entity])){
            throw new Exception("table '$entity' not exists");
        }

        $table =& self::$_data[$entity];
        if ($table) {
            foreach ($table as &$row) {
                if (!is_array($row)) {
                    continue;
                }

                if ($row['id'] === intval($id)) {
                    return $row;
                }
            }
        }

        $result = null;
        return $result;
    }

    private static function createEntity($name)
    {
        self::$_data[$name] = array();
        self::createSequence($name);
        self::save();
    }

    public static function insert($entity_name, $assoc_array)
    {
        self::load();
        if (!isset($assoc_array['id'])) {
            $assoc_array['id'] = self::getNextId($entity_name);
        }

        if (!self::findId($entity_name, $assoc_array['id'])) {
            array_push(self::$_data[$entity_name], $assoc_array);
        } else {
            throw new Exception("id '${assoc_array['id']}' already exists in table '$entity_name'", MyExceptions::DB_DUPLICATE_ID);
        }
        self::save();
    }

    public static function getData($entity_name)
    {
        self::load();
        if (!isset(self::$_data[$entity_name])){
            return [];
        }else{
            return self::$_data[$entity_name];
        }
    }

    public static function update($entity, $id, $field, $new_value)
    {
        self::load();
        self::findId($entity, $id)[$field] = $new_value;
        self::save();
    }

    private static function countRows($entity)
    {
        if (!isset(self::$_data[$entity])){
            return 0;
        }
        return count(self::$_data[$entity]);
    }

    public static function init()
    {
        self::load();

         if (self::countRows(self::TASK_TABLE) === 0) {

            $t1 = [
                'username' => 'tupseny231',
                'email' => 'tupseny@email.ru',
                'body' => 'Complete your tasks',
                'is_completed' => false,
                'edited_by' => '',
            ];

            $t2 = [
                'username' => 'tupseny231',
                'email' => 'tupseny@email.ru',
                'body' => 'Complete your tasks',
                'is_completed' => true,
                'edited_by' => '',
            ];

            $t3 = [
                'username' => 'tupseny231',
                'email' => 'tupseny@email.ru',
                'body' => 'Complete your tasks',
                'is_completed' => false,
                'edited_by' => '',
            ];

            $t4 = [
                'username' => 'tupseny231',
                'email' => 'tupseny@email.ru',
                'body' => 'Complete your tasks',
                'is_completed' => false,
                'edited_by' => '',
            ];

            self::createEntity(self::TASK_TABLE);
//            self::insert(self::TASK_TABLE, $t1);
//            self::insert(self::TASK_TABLE, $t2);
//            self::insert(self::TASK_TABLE, $t3);
//            self::insert(self::TASK_TABLE, $t4);
        }

         if (self::countRows(self::USER_TABLE) === 0) {
             $user = [
                 'username' => 'admin',
//                 hash of '123'
                 'password_hash' => '$2y$10$8izyEcWQzBvLIcP3Qv.7Y.R4fnJ2wo3wFkjOjPht/DH6wu1.4PJe.'
             ];

             self::createEntity(self::USER_TABLE);
             self::insert(self::USER_TABLE, $user);
         }
    }
}