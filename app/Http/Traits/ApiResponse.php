<?php


namespace App\Http\Traits;


trait ApiResponse
{
    public function response($data,$msg,$status)
    {
        return response()->json([
            'data'      =>  $data,
            'message'   =>  $msg,
            'status'    =>   $status
        ]);
    }
}
