<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public static function custom_response($code, $status, $msg, $data)
    {
      return response()->json([
        'metaData' => [
          'code' => $code,
          'status' => $status,
          'message' => $msg,
        ],
        'response' => $data,
      ], $code);
    }
}
