<?php


namespace App\Http\Traits;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
        return $folder.'/'.$image_name;
    }

    /** @noinspection PhpUnused */
    public function delete_image($path)
    {
        $image = public_path().'/'.$path;
       if (File::exists($image))
       {
           if(!Str::contains($image,'default.png'))
           {
               File::delete($image);
           }
       }

    }
}
