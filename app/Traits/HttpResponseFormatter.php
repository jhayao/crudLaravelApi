<?php
namespace App\Traits;

trait HttpResponseFormatter {
    protected function success($message, $data = [], $status = 200)
    {
        return response([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    protected function failure($message, $status = 400)
    {
        return response([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}