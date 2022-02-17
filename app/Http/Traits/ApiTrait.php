<?php


namespace App\Http\Traits;


trait ApiTrait
{
    public function response($data,$msg,$status)
    {
        return response()->json([
            'data'      =>  $data,
            'message'   =>  $msg,
            'status'    =>   $status
        ]);
    }

    public function image($folder,$image)
    {
        $image_name = time().$image->hashName();
        $image->storeAs($folder,$image_name);
        return$image_name;

    }
}
