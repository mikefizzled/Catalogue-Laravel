<?php

namespace Tests\Unit;

use App\Helpers\FileHelper;
use PHPUnit\Framework\TestCase;

class MediaHelperTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_media_filename_is_generated(): void
    {
        $filename = FileHelper::generateMediaFileName(
            'house-sparrow',
            'image',
            2,
            'webp'
        );

        $this->assertEquals(
            'house-sparrow-image-2.webp',
            $filename
        );
    }
}
