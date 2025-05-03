<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function success($data, $message=null, $code=200) {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error($message=null, $code) {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }
}
