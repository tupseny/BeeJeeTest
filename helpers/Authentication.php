<?php


class Authentication
{
    public static function authoriseByToken($token, $id)
    {
        try {
            $user = FakeDB::findId(FakeDB::USER_TABLE, $id);
            return isset($user['token']) AND $user['token'] === $token;
        }catch (Exception $exception){
            throw $exception;
        }
    }

    public static function authoriseByCredentials($password, $hash)
    {
        if (self::verify($password, $hash)) {
            return self::generateAuthToken();
        }
        throw new Exception('invalid credentials', MyExceptions::USER_INVALID_CRED);
    }

    private static function encode($var)
    {
        return password_hash($var, PASSWORD_DEFAULT);
    }

    private static function verify($pass, $hash)
    {
        return password_verify($pass, $hash);
    }

    private static function generateAuthToken()
    {
        return bin2hex(random_bytes(64));
    }
}