<?php

namespace App\Helpers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ResponseFormatter
{
    public static function created(string $message = "Data successfully created.", mixed $data = null): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], Response::HTTP_CREATED);
    }

    public static function success(string $message, mixed $data = null, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error(string $message, mixed $errors = null, int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

    public static function redirected(string $message, string $redirect_url, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'redirect_url' => $redirect_url
        ], $code);
    }

    public static function handleError(\Exception $e, string $message = 'Internal Server Error, Please try again later.'): JsonResponse  
    {  
        $errors = config('app.debug') ? $e->getMessage() : null;
        return self::error($message, $errors, Response::HTTP_INTERNAL_SERVER_ERROR);
    }  
}