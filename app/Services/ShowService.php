<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class ShowService
{
    /**
     * @param UploadedFile $file
     *
     * @return bool
     */
    public static function saveImage(UploadedFile $file)
    {
        $image = "";
        //store image on server
        $storePath = public_path() .
                DIRECTORY_SEPARATOR .
                'img' . DIRECTORY_SEPARATOR .
                $file->getClientOriginalName();

        try {
            $image = Image::make($file->getRealPath());
            $image->resize(620, 840)->save($storePath);
        } catch (\Exception $exception) {
            Log::error("Cannot save image: {$exception->getMessage()}");
        }

        return $image != "";
    }
}
