<?php

namespace App\Helpers;

class ResponseApi
{
    protected static $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }


    const NOT_FOUND = ['status' => 404, 'data' => ['error' => 'Not Found']];
    const UNAUTHORIZED = ['status' => 401, 'data' => ['error' => 'Unauthorized']];
    const OK = ['status' => 200, 'data' => 'Ok'];
    const BAD_REQUEST = ['status' => 400, 'data' => ['error' => 'Bad Request']];
    const UNPROCESSABLE_ENTITY = ['status' => 422, 'data' => ['error' => 'Unprocessable Entity']];
    const PRECONDITIONS_FAIL = ['status' => 412, 'data' => ['error' => 'Precondition Failed']];
    const FORBIDEN = ['status' => 403, 'data' => ['error' => 'Forbidden']];
    const NO_CONTENT = ['status' => 204, 'data' => 'OK'];

    private static function make(int $statusCode)
    {
        $result = null;
        switch ($statusCode) {
            case self::NOT_FOUND['status']:
                $result = self::NOT_FOUND;
                break;
            case self::OK['status']:
                $result = self::OK;
                break;
            case self::BAD_REQUEST['status']:
                $result = self::BAD_REQUEST;
                break;
            case self::UNPROCESSABLE_ENTITY['status']:
                $result = self::UNPROCESSABLE_ENTITY;
                break;
            case self::PRECONDITIONS_FAIL['status']:
                $result = self::PRECONDITIONS_FAIL;
                break;
            case self::FORBIDEN['status']:
                $result = self::FORBIDEN;
                break;
            case self::UNAUTHORIZED['status']:
                $result = self::UNAUTHORIZED;
                break;
            case self::NO_CONTENT['status']:
                $result = self::NO_CONTENT;
                break;
        }

        return $result;
    }

    public static function json(int $statusCode, $data = null)
    {
        $result = self::make($statusCode);

        return response()->json($data ? $data : $result['data'], $result['status']);
    }

    public static function getInstance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}
