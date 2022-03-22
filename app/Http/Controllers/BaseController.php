<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    public function sendResponse($data, $message,$code = 200)
    {
        $response = [
            'code' => $code,
            'status' => true,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, $code);
    }

    public function sendError($data, $message, $code = 422)
    {
        $response = [
            'code' => $code,
            'status' => false,
            'message' => $message,
            'data' => $data
        ];
        
        return response()->json($response, $code);
    }
}
