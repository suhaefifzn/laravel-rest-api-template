<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class RenderException extends ExceptionHandler
{
    public function render($request, Throwable $e): Response
    {
        if ($request->expectsJson()) {
            $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTrace() : null,
            ], $status);
        }

        return parent::render($request, $e);
    }
}
