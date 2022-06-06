<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return string
     */

    public function sendResponseOk($result, $message = 'Response Ok')
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
     * error response method.
     *
     * @return string
     */
    public function sendResponseError($error, $code = 500, $errorMessages = [])
    {
    	$response = [
            'success' => false,
            'data' => null,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * message response method.
     *
     * @return string
     */

    public function sendResponseMessage($key, $message, $success = true)
    {
    	$response = [
            'success' => true,
            'data' => null,
            $key => $message,
        ];
        return response()->json($response, 200);
    }




}
