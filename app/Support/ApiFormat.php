<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

class ApiFormat
{
    public static function success(mixed $data, int $status = 200, array $extra = []): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $data,
            'meta'    => array_merge([
                'student' => config('lab.slug'),
                'lesson'  => config('lab.code'),
            ], $extra),
        ], $status, [], JSON_UNESCAPED_UNICODE);
    }

    public static function error(string $message, int $status, array $fields = []): JsonResponse
    {
        $body = [
            'success' => false,
            'error'   => ['code' => $status, 'message' => $message],
        ];

        if ($fields) {
            $body['errors'] = $fields;           // только для 422
        }

        return response()->json($body, $status, [], JSON_UNESCAPED_UNICODE);
    }
}
