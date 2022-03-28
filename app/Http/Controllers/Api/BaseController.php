<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{


    // public function sendResponse($result,$message,$status = 200)
    public function sendResponse($result,$message,$status = 200)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
            // $key => $value,

        ];

        return response()->json($response,$status);

    }



    // -------------------------------------------------


    public function sendError($error,$errors_messages = [],$status = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errors_messages)){
            $response['errros'] = $errors_messages;
        }


        return response()->json($response,$status);


    }

    // -------------------------------------------------
    // -------------------------------------------------
}
