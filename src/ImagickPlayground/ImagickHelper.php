<?php

namespace App\ImagickPlaygroud;

use Imagick;
use ImagickException;

class ImagickHelper
{
    private $image;

    public function __construct($filePath)
    {
        try {
            $this->image = new Imagick($filePath);
        } catch (ImagickException $e) {
            echo "Error loading image: " . $e->getMessage();
        }
    }

    public function resize($width, $height)
    {
        $this->image->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1);
    }

    public function convertTo($format)
    {
        $this->image->setFormat($format);
    }

    public function flip()
    {
        $this->image->flopImage();
    }

    public function getOrientation()
    {
        return $this->image->getImageOrientation();
    }

    public function convertPdfToImages($pdfPath, $outputPath, $format = 'jpeg', $dpi = 150)
    {
        $pages = $this->image->getNumberImages();
        for ($i = 0; $i < $pages; $i++) {
            $this->image->readImage($pdfPath . "[" . $i . "]");
            $this->image->setImageFormat($format);
            $this->image->setImageResolution($dpi, $dpi);
            $this->image->writeImage($outputPath . "page-" . str_pad($i + 1, 3, '0', STR_PAD_LEFT) . "." . $format);
        }
    }

    public function autoRotateImage()
    {
        switch ($this->getOrientation()) {
            case imagick::ORIENTATION_BOTTOMRIGHT:
                $this->image->rotateimage("#000", 180); // rotate 180 degrees
                break;

            case imagick::ORIENTATION_RIGHTTOP:
                $this->image->rotateimage("#000", 90); // rotate 90 degrees CW
                break;

            case imagick::ORIENTATION_LEFTBOTTOM:
                $this->image->rotateimage("#000", -90); // rotate 90 degrees CCW

            default:
                break;
        }

        $this->image->setImageOrientation(imagick::ORIENTATION_TOPLEFT);
    }

    public function save($filePath)
    {
        $this->image->writeImage($filePath);
    }

    public function clear()
    {
        $this->image->clear();
        $this->image->destroy();
    }

    public function display()
    {
        header("Content-Type: image/" . $this->image->getImageFormat());
        echo $this->image;
    }
}
