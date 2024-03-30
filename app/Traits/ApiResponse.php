<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function sendResponse($result, $message='OK', $code=200): JsonResponse
    {
        return response()->json(self::makeResponse($message, $result), $code);
    }

    public function sendError($error, $code = 400, $data = []): JsonResponse
    {
        return response()->json(self::makeError($error, $data), $code);
    }

    public function makeResponse($message, $data): array
    {
        return [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];
    }

    public function makeError($message, array $data = []): array
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }
}
