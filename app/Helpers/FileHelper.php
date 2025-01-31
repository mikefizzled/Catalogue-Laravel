<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class FileHelper
{
    /**
     * Rename a file to fit a specific pattern.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $suffix
     * @param string $slug
     * @return string
     */
    public static function generateFileName($file, $slug,  $suffix = '')
    {
        // Get the file extension
        $extension = $file->getClientOriginalExtension();
        
        $newFileName = $slug .  $suffix .  '.' .  $extension;

        return $newFileName;
    }
}
?>