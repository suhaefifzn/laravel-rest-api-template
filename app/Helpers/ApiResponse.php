<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTableAbstract;

class ApiResponse
{
    public static function datatable(DataTableAbstract $dataTable): JsonResponse
    {
        $data = $dataTable->make(true);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public static function success($data = null, $message = null, int $code = 200): JsonResponse
    {
        $response = [
            'status' => 'success',
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        if (!is_null($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }

    public static function successPagination($paginator, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $paginator->items(),
            'pagination' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ]
        ], $code);
    }

    public static function fail(string $message = 'Error', $errors = null, int $code = 400): JsonResponse
    {
        $response = [
            'status' => 'fail',
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
