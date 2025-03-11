<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\JpegEncoder;
use getID3;
use App\Helpers\FileHelper;
use App\Models\Animal;
use App\Models\Media;

class MediaService
{
    public static function storeThumbnail($file, $animalSlug, $existingThumbnail = null)
    {
        $extension = strtolower($file->getClientOriginalExtension());
         
        $filename = FileHelper::generateBirdThumbnailName($animalSlug, $extension);
    
        // If an old thumbnail exists, delete it from S3
        if ($existingThumbnail) {
            self::deleteFromS3('thumbnails', $existingThumbnail);
        }


        // Store in temporary local storage
        $tempPath = $file->storeAs('temp', $filename, 'public');
        $path = Storage::disk('public')->path($tempPath);
    
        // Compress and strip metadata
        FileHelper::compressAndRemoveMeta($path, $extension);
    
        // Move to S3
        Storage::disk('s3')->put("thumbnails/{$filename}", file_get_contents($path));
    
        // Remove local temp file
        Storage::disk('public')->delete([$tempPath]);
    
        return $filename;
    }
    
    public static function storeMedia($request)
    {
        // Validate and extract the uploaded file
        $file = $request->file('media');

        $processedFile = self::processFile($file, $request->animal_id);

        // Extract metadata
        $metadata = self::extractMetadata($processedFile['temp_path'], $processedFile['extension']);

        // Workaround for Merlin WAV files only having date stored in filename
        if($processedFile['extension'] === 'wav')
        {
            // Drop the extension and only collect the filename to pass to extractor
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $dateTaken = FileHelper::extractDateFromName($fileName);
        }
        else{
            $dateTaken = self::getDateTaken($metadata);
        }
              
        
        // Store in S3
        self::storeInS3($processedFile);



        // Create media entry in database
        $media = Media::create([
            'animal_id'    => $request->animal_id,
            'location_id'  => $request->location_id ?? null,
            'media_url'    => $processedFile['filename'],
            'thumbnail_url'=> $processedFile['thumbnail_name'],
            'media_type'   => $processedFile['media_type'],
            'rating'       => $request->rating ?? null,
            'date_taken'   => $dateTaken,
            'caption'      => $request->caption ?? null,
            'age'          => $request->age ?? null,
            'gender'       => $request->gender ?? null,
            'metadata'     => json_encode($metadata),
            'hash'         => FileHelper::generateFileHash($processedFile['temp_path']),
        ]);
        
        // Cleanup temporary files
        Storage::disk('public')->delete([$processedFile['temp_path']]);
        return $media;
    }

    /**
     * Process the uploaded file and generate filenames.
     */
    public static function processFile($file, $animalId)
    {
        // Collecting information to generate file name
        $animalSlug = Animal::getSlug($animalId);
        $extension = strtolower($file->getClientOriginalExtension());
        $mediaType = self::determineFileType($extension);
        $newTotal = Media::nextMediaNumber($animalId, $mediaType);

        // Create filenames
        $filename = FileHelper::generateMediaFileName($animalSlug, $mediaType, $newTotal, $extension);
       
        if($mediaType === 'image' || $mediaType === 'video')
            $thumbnailName = FileHelper::generateMediaFileName($animalSlug, $mediaType, $newTotal, $extension, $thumb = true);
        else
            $thumbnailName = null;

        
        $tempPath = $file->storeAs('temp', $filename, 'public');

        return [
            'filename'       => $filename,
            'thumbnail_name' => $thumbnailName,
            'temp_path'      => Storage::disk('public')->path($tempPath),
            'extension'      => $extension,
            'media_type'     => $mediaType,
        ];
    }

    
    
    /**
     * Determine if the file is an image, video, or audio.
     * Only expand when metadata is more reliably managed
     */
    public static function determineFileType($extension)
    {
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                return 'image';
            case 'mp4':
                return 'video';
            case 'wav':
                return 'audio';
            default:
                return 'unknown';
        }
    }

    /**
     * Extract metadata using getID3 and FileHelper.
     */
    public static function extractMetadata($filePath, $extension)
    {
        $getID3 = new getID3();
        $fileInfo = $getID3->analyze($filePath);
        return FileHelper::collectMetadata($fileInfo, $extension);
    }

    /**
     * Extract the date the media was taken and prepare for MySQL Date format
     */
    public static function getDateTaken($metadata)
    {
        return FileHelper::formatDate($metadata['Created Date'] ?? null);
    }

/**
     * Store files in S3 for JPG, MP4, and WAV.
     */
    public static function storeInS3($processedFile)
    {
        switch ($processedFile['media_type']) {
            case 'image':
                self::processImage($processedFile);
                break;
            case 'video':
                //self::processVideo($processedFile);
                break;
            case 'audio':
                self::processAudio($processedFile);
                break;
            default:
                throw new \Exception("Unsupported media type: " . $processedFile['media_type']);
        }
    }

    /**
     * Process and store JPG images.
     */
    private static function processImage($processedFile)
    {
        $manager = new ImageManager(new ImagickDriver());

        // Make 16:9 thumbnail of the media
        $image = $manager->read(file_get_contents($processedFile['temp_path']))->resize(400, 225);
        
        $imageBinary = $image->encode(new JpegEncoder());

        // Store original and thumbnail
        Storage::disk('s3')->put("media/{$processedFile['filename']}", file_get_contents($processedFile['temp_path']));
        Storage::disk('s3')->put("media/{$processedFile['thumbnail_name']}", (string) $imageBinary);
    }

    /**
     * Process and store WAV files (mp3 not tested)
     */
    private static function processAudio($processedFile)
    {
        Storage::disk('s3')->put("media/{$processedFile['filename']}", file_get_contents($processedFile['temp_path']));
    }


    public static function deleteFromS3($folder, $filename)
    {
        $path = "{$folder}/{$filename}";

        // Check if file exists before deleting
        if (Storage::disk('s3')->exists($path)) {
            Storage::disk('s3')->delete($path);
            return true;
        }
        return false;
    }

    public static function saveToS3($folder, $filename, $filePath)
    {
        $path = "{$folder}/{$filename}";
    
        // Upload file to S3
        Storage::disk('s3')->put($path, file_get_contents($filePath));
    
        return $path;
    }
    

}
