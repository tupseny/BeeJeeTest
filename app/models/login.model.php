<?php


class LoginModel extends Model
{
    function logout(){
        $id = $_COOKIE['user_id'];
        setcookie('token', '');
        setcookie('user_id', '');

        FakeDB::update(FakeDB::USER_TABLE, $id, 'token', '');
    }

    function authorise($username, $password){
        $user = $this->fetchUser($username);
        $hash = $user['password_hash'];
        $id = $user['id'];

        $token = Authentication::authoriseByCredentials($password, $hash);
        $this->saveToken($id, $token);

        setcookie('token', $token);
        setcookie('user_id', $id);
    }

    private function fetchUser($username){
        $users = FakeDB::getData(FakeDB::USER_TABLE);
        foreach ($users as $u){
            if ($u['username'] === $username){
                return $u;
            }
        }
        throw new Exception('invalid creds', MyExceptions::USER_INVALID_CRED);
    }

    private function saveToken($id, $token){
        $token_field = 'token';
        FakeDB::update(FakeDB::USER_TABLE, $id, $token_field, $token);
    }
}