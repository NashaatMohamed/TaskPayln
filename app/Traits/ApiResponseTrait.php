<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function errorResponse($msg, $code): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $msg,
        ], $code);
    }

    public function successResponse($msg, $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $msg,
        ], $code);
    }

    public function dataResponse($msg, $data, $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $msg,
            'data' => $data,
        ], $code);
    }

    public function getvalidationErrors($validator, $code = 422): \Illuminate\Http\JsonResponse
    {
        return $this->errorResponse($validator->errors()->first(), $code);
    }

    public function returnException($message, $code): \Illuminate\Http\JsonResponse
    {
        return $this->errorResponse($message, $code);
    }

}
