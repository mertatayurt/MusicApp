<?php

namespace App\Helpers;

class JsonResponse
{
    public static function response($data = null, $message = null)
    {
        return [
            'data'    => $data,
            'message' => $message,
        ];
    }

    public static function errResponse($data = null, $message = null)
    {
        return [
            'error'    => $data,
            'errorMessage' => $message,
        ];
    }

    public static function errWithMessageResponse($data = null, $message = null)
    {
        return [
            'error'    => $data,
            'message' => $message,
        ];
    }
}