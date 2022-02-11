<?php

namespace App\Http\Traits;

trait APIResponse
{
    public function success($data, $status = 200, $msg = null)
    {
        return [
            'data' => $data,
            'success' => in_array($status, [200, 201, 202]) ? true : false,
            'message' => $msg
        ];
    }

    public function failure($status = 500, $msg = null, $data = [])
    {
        return [
            'data' => $data,
            'success' => in_array($status, [500, 422, 419]) ? true : false,
            'message' => $msg
        ];
    }

    public function error($status = false, $msg = null, $data = [])
    {
        return [
            'data' => $data,
            'success' => in_array($status, [500, 422, 419]) ? true : false,
            'message' => $msg
        ];
    }
}
