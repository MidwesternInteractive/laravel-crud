<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * Builds a fractal response off an exeception
     *
     * @param Object $e
     * @param Int $code
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @author
     */
    public function respond($e, $code)
    {
        return response([
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'errors' => method_exists($e, 'errors') ? $e->errors() : null,
        ], $code);
    }

    /**
     * Exeception wrapper for all api calls
     *
     * @param \Closure $function
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @author
     */
    public function safeCall(\Closure $function, $code = 200)
    {
        try {
            return $function();
        } catch (\Exception $e) {
            return $this->respond($e, $code);
        }
    }
}
