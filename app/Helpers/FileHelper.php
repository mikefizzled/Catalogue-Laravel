<?php

namespace App\Helpers;

use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    /**
     * Generate the media filename
     *
     * @param string $slug - The unique animal slug
     * @param string $mediaType - The type of media (image/video/audio)
     * @param int $newTotal - The new number for the media item
     * @param string $extension - The file extension (e.g., jpg, mp4)
     * @param bool $thumb - Optional - Used for naming thumbnails of associated images and videos
     * @return string The generated file name.
     */

    public static function generateMediaFileName(string $slug, string $mediaType, int $newTotal, string $extension, bool $thumb = false): string
    {
        // If its the thumbnail of media item, include thumb in the suffix
        $suffix = $thumb ? "-{$mediaType}-thumb-{$newTotal}" : "-{$mediaType}-{$newTotal}";
    
        return "{$slug}{$suffix}.{$extension}";
    }
    
    /**
     * Generate the filename for the main bird thumbnail
     *
     * @param string $slug - The unique animal slug
     * @param string $extension - The file extension e.g jpg or webp
     * @return string The generated file name
     */
    public static function generateBirdThumbnailName(string $slug, string $extension): string
    {
        return "{$slug}-thumbnail.{$extension}";
    }

    public static function collectMetadata($fileInfo, $fileType)
    {
        switch ($fileType) {
            case 'jpg':
            case 'jpeg':
                return self::collectImageMetadata($fileInfo);
            case 'mp4':
                return self::collectVideoMetadata($fileInfo);
            case 'wav':
                return self::collectAudioMetadata($fileInfo);
            default:
                return [];
        }
    }
    


    /**
     * Collect JPEG metadata in JSON array
     *
     * @param array $metadata
     * @return array  
     */

     public static function collectImageMetadata($fileInfo)
     {
        return [
            'Camera' => ucfirst($fileInfo['jpg']['exif']['IFD0']['Make']). ' '. $fileInfo['jpg']['exif']['IFD0']['Make'] ?? null,
            'Lens' => $fileInfo['jpg']['exif']['EXIF']['UndefinedTag:0xA434'] ?? null,
            'Focal Length' => self::formatFocalLength($fileInfo['jpg']['exif']['EXIF']['FocalLength']),
            'F-stop' => $fileInfo['jpg']['exif']['COMPUTED']['ApertureFNumber'] ?? null,
            'Exposure Time' => self::formatExposureTime($fileInfo['jpg']['exif']['EXIF']['ExposureTime']) ?? null,
            'ISO' => 'ISO-'.$fileInfo['jpg']['exif']['EXIF']['ISOSpeedRatings'] ?? null,
            'Exposure Bias' => self::formatExposureBias($fileInfo['jpg']['exif']['EXIF']['ExposureBiasValue']),
            'Dimensions' => $fileInfo['jpg']['exif']['COMPUTED']['Width']. 'x'. $fileInfo['jpg']['exif']['COMPUTED']['Height'] ?? null,
            'Software' => $fileInfo['jpg']['exif']['IFD0']['Software'] ?? null,
            'Created Date' => $fileInfo['jpg']['exif']['EXIF']['DateTimeOriginal'] ?? null,
        ];
     }
        public static function collectVideoMetadata($fileInfo)
        {
            $createdDate = FileHelper::formatUnixDate($fileInfo['quicktime']['timestamps_unix']['create']['moov mvhd'] ?? null);
            $modifiedDate = FileHelper::formatUnixDate($fileInfo['quicktime']['timestamps_unix']['modify']['moov mvhd'] ?? null);

            return [
                'File Format' => $fileInfo['fileformat'] ?? null,
                'File Size' => FileHelper::formatFileSize($fileInfo['filesize']),
                'Duration' => FileHelper::formatDuration($fileInfo['playtime_seconds']),
                'Bitrate' => FileHelper::formatBitrate($fileInfo['bitrate']),
                'Sample Rate' => $fileInfo['audio']['sample_rate'] ?? null,
                'Channels' => $fileInfo['audio']['channels'] ?? null,
                'Codec' => $fileInfo['audio']['codec'] ?? null,
                'Bitrate Mode' => $fileInfo['audio']['bitrate_mode'] ?? null,
                'Bits per Sample' => $fileInfo['audio']['bits_per_sample'] ?? null,
                'Lossless' => $fileInfo['audio']['lossless'] ? 'Yes' : 'No',
                'Mime Type' => $fileInfo['mime_type'] ?? null,
                'Channel Mode' => $fileInfo['audio']['channelmode'] ?? null,
                'Compression Ratio' => $fileInfo['audio']['compression_ratio'] ?? null,
                'Created Date' => $createdDate,
            ];
        }


     public static function collectAudioMetadata($fileInfo)
     {
         return [
             'Duration' => self::formatDuration($fileInfo['playtime_seconds']),
             'Bitrate' => self::formatBitrate($fileInfo['bitrate']),
             'Sample Rate' => $fileInfo['audio']['sample_rate'] ?? null,
             'Channels' => $fileInfo['audio']['channels'] ?? null,
             'Bits per Sample' => $fileInfo['audio']['bits_per_sample'] ?? null,
             'Channel Mode' => $fileInfo['audio']['channelmode'] ?? null,
         ];
     }

     public static function formatDuration($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        return ($hours > 0 ? $hours . 'h ' : '') .
            ($minutes > 0 ? $minutes . 'm ' : '') .
            round($seconds, 2) . 's';
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
    public static function formatFilesize(?string $bytes): ?string
    {
        if ($bytes !== null) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }
        return null;
    }
 
    public static function formatUnixDate($unixTimestamp)
    {
        return date('Y-m-d H:i:s', $unixTimestamp);
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

    /**
     * Temp compressing function that also strips the metadata
     *
     * @param  
     * @return 
     */

    public static function compressAndRemoveMeta(?string $filePath, ?string $format)
    {
        switch($format){
            case "webp":
                return shell_exec("cwebp -q 95 -mt -metadata none {$filePath} -o {$filePath}");
            case "jpg":
            case "jpeg":
                return shell_exec("jpegoptim -m95 --strip-all --all-progressive {$filePath}");
                
        }
    }

    public static function formatBitrate($bitrate)
    {
        return round($bitrate / 1000) . ' kbps';
    }
    
    public static function formatExposureTime($exposureTime)
    {
        if ($exposureTime < 1) {
            $fraction = 1 / $exposureTime;
            return '1/' . round($fraction) . ' sec.';
        } else {
            return round($exposureTime, 2) . ' sec.';
        }
    }

    /**
     * Generate SHA-256 hash of the file.
     */
    public static function generateFileHash($filePath)
    {
        return hash_file('sha256', $filePath);
    }


    /**
     * Extract the Date from Merlin exported WAV files e.g., '2014-3-4 14_23.wav'
     * Return either fixed date in MySQL format, or current time
     */
    public static function extractDateFromName($filename)
    {
        $dateTime = Carbon::createFromFormat('Y-m-d H_i', $filename);

        // If extraction fails for some reason, just return current time
        if ($dateTime === false) 
            return Carbon::now()->format('Y-m-d H:i:s');
        
        
        $fixed = $dateTime->format('Y-m-d H:i:s');
        return $fixed;
    }

    // Used in media page for collecting image and organising metadata
    public static function processMediaCollection($mediaCollection)
    {
        foreach ($mediaCollection as $media) {
            $media->media_url = Storage::disk('s3')->url('media/' . $media->media_url);
            $media->metadata = json_decode($media->metadata);
        }
        return $mediaCollection;
    }

    public static function collectAnimalThumbnail($thumbnailName)
    {
        if ($thumbnailName) {
            return Storage::disk('s3')->url("thumbnails/{$thumbnailName}");
        }

        // Default placeholder for missing thumbnails
        return asset('images/default-thumbnail.jpg');
    }
}