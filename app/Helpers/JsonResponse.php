<?php

namespace App\Helpers;

class JsonResponse{
    private function respond($success = true, $message = null, $errors = [], $data = null){
        return \response()->json([
            'success' => $success,
            'message' => $message,
            'errors' => $errors,
            'data' => $data,
        ]);
    }

    function success($message = null){
        return $this->respond(true, $message);
    }

    function error($error = null, $data = null){
        return $this->respond(false, $error, [], $data);
    }

    function errors($errors, $message = null, $data = null){
        return $this->respond(false, $message, $errors, $data);
    }

    function data($data, $message = null){
        return $this->respond(true, $message, [], $data);
    }
}
