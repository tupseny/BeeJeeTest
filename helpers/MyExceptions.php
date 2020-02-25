<?php


class MyExceptions
{
    const INTERNAL_ERROR = 0;
    const REQUEST_NO_REQUIRED_FIELDS = 1;
    const DB_ERROR = 2;
    const DB_DUPLICATE_ID = 3;
    const SESSION_NO_KEY = 4;
    const USER_INVALID_CRED = 5;
    const USER_FORBIDDEN = 6;
    const REQUEST_NO_PATH_ARGUMENT = 7;
    const REQUEST_NO_ACTION = 8;
    const REQUEST_INVALID_FIELD_VALUE = 9;
}