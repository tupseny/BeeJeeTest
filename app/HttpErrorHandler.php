<?php

class HttpErrorHandler
{
    private static function handle(string $err_msg, int $err_code)
    {
        switch ($err_code){
            case StatusCodes::HTTP_NOT_FOUND: ErrorRoute::page404(); break;
        }
    }

    static function error(Exception $e){
        $msg = $e -> getMessage();
        $code = $e -> getCode();

        self::handle($msg, $code);
    }
}