<?php

namespace App\Http\Traits;

use App\Http\Resources\CategoryResource;

trait ApiResponses{

public function customeResponse($data, $message, $status) {
    $array = [
        'data'=>$data,
        'message'=>$message
    ];

    return response()->json($array, $status);
}

}