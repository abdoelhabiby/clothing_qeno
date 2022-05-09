<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class FileService
{

    public static function reszeImageAndSave($image, $folder, $path, $width = 900, $height = 750): void
    {

        $resize = Image::make($image)
            ->fit($width, $height, function ($constraint) {
                $constraint->upsize();
            })->encode('png', 100)->save($folder . '/' . $path);
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


    public static function saveImage($image,$disk,$folder,$image_name,$width = 900, $height = 750) : string
    {

         $folder_path = $disk . '/' . $folder;

        self::checkDirectoryExistsOrCreate($folder_path);
        $path_image = $folder . '/' . $image_name;
        self::reszeImageAndSave($image, public_path(), $path_image,$width,$height);

        return $path_image;

        //------------------------------------------


    }


    // -----------------------------------------------------

}
