<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class FileHelper
{
    /**
     * Generate a formatted file name.
     *
     * @param string $slug The unique slug related to the file.
     * @param string $suffix Optional suffix for differentiation.
     * @param string $extension The file extension (e.g., jpg, png).
     * @return string The generated file name.
     */
    public static function generateFileName(string $slug, string $suffix = '', string $extension): string
    {
        return "{$slug}{$suffix}.{$extension}";
    }


    /**
     * Collect JPEG metadata in JSON array
     *
     * @param array $metadata
     * @return array  
     */

     public static function collectMetadata($exif)
     {
        $metadata = [
            'Camera' => ucfirst($exif['Make']). ' '. $exif['Model'] ?? null,
            'Lens' => $exif['UndefinedTag:0xA434'] ?? null,
            'Focal Length' => self::formatFocalLength($exif['FocalLength']),
            'F-stop' => $exif['COMPUTED']['ApertureFNumber'] ?? null,
            'Exposure Time' => $exif['ExposureTime']. ' sec.' ?? null,
            'ISO' => 'ISO-'.$exif['ISOSpeedRatings'] ?? null,
            'Exposure Bias' => self::formatExposureBias($exif['ExposureBiasValue']),
            'Dimensions' => $exif['COMPUTED']['Width']. 'x'. $exif['COMPUTED']['Height'] ?? null,
            'Software' => $exif['Software'] ?? null,
            'Size' => self::formatFilesize($exif['FileSize']),
            //'Date' => self::formatDate( $exif['DateTimeOriginal']),
        ];
 
         return json_encode($metadata);
     }

    /**
     * Format the focal length 
     *
     * @param string|null $value
     * @return string|null 
     */
    private static function formatFocalLength(?string $value): ?string
    {
        if ($value && strpos($value, '/') !== false) {
            list($numerator, $denominator) = explode('/', $value);
            return $denominator != 0 ? ($numerator / $denominator) . 'mm' : 'N/A';
        }
        return $value ? $value . ' mm' : null;
    }

    /**
     * Format the exposure bias
     *
     * @param string|null $value
     * @return string|null 
     */
    private static function formatExposureBias(?string $value): ?string
    {
        if ($value && strpos($value, '/') !== false) {
            list($numerator, $denominator) = explode('/', $value);
            return $denominator != 0 ? ($numerator / $denominator) . ' EV' : '0 EV';
        }
        return $value ? $value . ' EV' : '0 EV';
    }

    /**
     * Format file size from bytes to megabytes
     *
     * @param int|null $bytes
     * @return string|null 
     */
    private static function formatFilesize(?string $bytes): ?string
    {
        if ($bytes !== null) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }
        return null;
    }

    /**
     * Format the DateTimeOriginal for MySQL DateTime format
     *
     * @param string|null $date
     * @return string|null
     */
    public static function formatDate(?string $date): ?string
    {
        if($date === null)
            return null;
        
        $formattedDate = str_replace(':', '-', substr($date, 0, 10)) . substr($date, 10);

        return $formattedDate;
    }

}
?>