<?php

namespace App\Traits;

trait JsonResponseTrait {

    public function sendJsonResponse($isError = false, $data = null, $message = null, $statusCode = 200)
    {
        return response()->json([
            'error' => $isError,
            'data' => $data,
            'message' => $message,
            'status_code' => $statusCode
        ], $statusCode);
    }

    public function sendResourceNotFound()
    {
        return $this->sendJsonResponse(isError: true, statusCode: 404);
    }

}
