<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function apiResponse($result, $code = 200, $headers = [])
    {
        if (null === $result) $code = 204;
        $response = [
            'code' => $code,
            'data' => $result,
        ];
        return response()->json($response, $code, $headers);
    }

    public function errorResponse($errors = [], $code = 404, $exception = [])
    {
        $errors = !is_array($errors) && !optional($errors)->count() ? ['error' => $errors] : $errors;
        $response = [
            'code' => $code,
            'errors' => $errors,
            'exception' => $exception
        ];
        return response()->json($response, $code);
    }

}
