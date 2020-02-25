<?php


class NewModel extends Model
{
    public function add(array $data)
    {
        if (
            isset($data['username']) and
            isset($data['email']) and
            isset($data['task'])
        ) {
            $this->insertTask($data['username'], $data['email'], $data['task']);
        } else {
            throw new Exception('no required fields', MyExceptions::REQUEST_NO_REQUIRED_FIELDS);
        }


      }

    private function insertTask($username, $email, $body)
    {
        $data = [
            'username' => trim($username),
            'email' => trim($email),
            'body' => trim($body),
            'is_completed' => false
        ];

        FakeDB::insert(FakeDB::TASK_TABLE, $data);
    }
}