<?php
/**
 * Success Response
 */

use Illuminate\Support\Arr;

if (!function_exists('successResponse')) {
    function successResponse($message = '', $data = null, $code = 200)
    {
        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => $message,
        ], $code);
    }

}

/**
 * Fail Response
 */
if (!function_exists('failResponse')) {
    function failResponse($code, $message = '', $data = null,)
    {
        return response()->json([
            'data' => $data,
            'status' => 'fail',
            'message' => $message,
        ], $code);
    }
}

/**
 * Handle Full Name
 */
if (!function_exists('handleFullName')) {
    function handleFullName($request, $user = null, $additions = [])
    {
        $data = $request;
        if (isset($data['first_name']) && isset($data['last_name'])) {
            $additions['full_name'] = ucfirst($request['first_name']) . ' ' . ucfirst($request['last_name']);
            $data = Arr::except($data, ['first_name', 'last_name']);
        } elseif ($user && isset($data['first_name']) && !isset($data['last_name'])) {
            $last_name = explode(' ', $user->full_name)[1];
            $additions['full_name'] = ucfirst($request['first_name']) . ' ' . $last_name;
            $data = Arr::except($data, ['first_name']);
        } elseif ($user && isset($data['last_name']) && !isset($data['first_name'])) {
            $first_name = explode(' ', $user->full_name)[0];
            $additions['full_name'] = $first_name . ' ' . ucfirst($request['last_name']);
            $data = Arr::except($data, ['last_name']);
        }
        return array_merge($data, $additions);
    }
}
