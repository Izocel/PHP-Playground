<?php

namespace App\ImagickPlaygroud;

class ImagickPlaygroud
{
    public function __construct()
    {
        $outputPath = __DIR__ . "../../assets/";
        $filePath = $outputPath . "pdfToutNoir.pdf";
        $imagickHelper = new ImagickHelper($filePath);
        $imagickHelper->convertPdfToImages($filePath, $outputPath, 'jpeg', 150);
    }
}
