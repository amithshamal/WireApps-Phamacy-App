<?php

namespace App\Http\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class Helper
{
    public static function sendError($message, $errors = [], $code = 401)
    {
        $response = ['success' => false, 'message' => $message];
        if (!empty($errors)) {
            $response['data'] = $errors;
        }

        throw new HttpResponseException(response()->json($response, $code));
    }

    public static function validatePermission($granted_permission)
    {
        $permissions = auth()->user()->roles->flatMap->permissions->pluck('name')->toArray();
        if (in_array($granted_permission, $permissions)) {
            return true;
        } else {
            return false;
        }
    }
}
