<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('apiResponse')) {
    function apiResponse(
        int $code = Response::HTTP_OK,
        ?string $message = null,
        array|JsonResource $data = [],
    ): JsonResponse {
        $data = [
            'status' => $code === Response::HTTP_OK,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($data, $code);
    }
}
