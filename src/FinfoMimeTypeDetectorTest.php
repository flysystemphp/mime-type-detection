<?php

declare(strict_types=1);

namespace Flysystem\MimeTypeDetection;

use PHPUnit\Framework\TestCase;

class FinfoMimeTypeDetectorTest extends TestCase
{
    /**
     * @var FinfoMimeTypeDetector
     */
    private $detector;

    protected function setUp(): void
    {
        $this->detector = new FinfoMimeTypeDetector();
    }

    /**
     * @test
     */
    public function detecting_mime_type_from_a_path(): void
    {
        $mimeType = $this->detector->detectMimeTypeFromPath('something.svg');

        $this->assertEquals('image/svg+xml', $mimeType);
    }

    /**
     * @test
     */
    public function detecting_mime_type_from_contents(): void
    {
        /** @var string $contents */
        $contents = file_get_contents(__DIR__.'/../test_files/flysystem.svg');

        $mimeType = $this->detector->detectMimeType('flysystem.svg', $contents);

        $this->assertEquals('image/svg', $mimeType);
    }

    /**
     * @test
     */
    public function detecting_mime_type_from_buffer(): void
    {
        /** @var string $contents */
        $contents = file_get_contents(__DIR__.'/../test_files/flysystem.svg');

        $mimeType = $this->detector->detectMimeTypeFromBuffer($contents);

        $this->assertEquals('image/svg', $mimeType);
    }

    /**
     * @test
     */
    public function detecting_from_contents_falls_back_to_extension_detection(): void
    {
        $mimeType = $this->detector->detectMimeType('flysystem.svg', '');

        $this->assertEquals('image/svg+xml', $mimeType);
    }

    /**
     * @test
     */
    public function detecting_from_a_file_location(): void
    {
        $mimeType = $this->detector->detectMimeTypeFromFile(__DIR__.'/../test_files/flysystem.svg');

        $this->assertEquals('image/svg', $mimeType);
    }

    /**
     * @test
     */
    public function detecting_uses_extensions_when_a_resource_is_presented(): void
    {
        /** @var resource $handle */
        $handle = fopen(__DIR__.'/../test_files/flysystem.svg', 'r+');
        fclose($handle);

        $mimeType = $this->detector->detectMimeType('flysystem.svg', $handle);

        $this->assertEquals('image/svg+xml', $mimeType);
    }
}
