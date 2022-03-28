<?php

namespace App\Http\Services;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class FileService
{

    public static function reszeImageAndSave($image, $disk, $path, $width = 900, $height = 750): void
    {

        $resize = Image::make($image)
            ->fit($width, $height, function ($constraint) {
                $constraint->upsize();
            })->encode('png', 100)->save($disk . '/' . $path);
    }


    // -----------------------------------------------------
    public static function deleteFile($path)
    {
        if(File::exists($path)){
            File::delete($path);
        }

        // return false;
    }
    // -----------------------------------------------------

    public static function checkDirectoryExistsOrCreate($path) : void
    {

            if (!File::exists($path)) {
                File::makeDirectory($path, 0775, true);
            }

    }

    // -----------------------------------------------------


    // -----------------------------------------------------

}
