<?php

namespace App\CSVPlayground;

class CSVPlayground
{
    public function __construct()
    {
        $outputPath = __DIR__ . "../../assets/csv/";
        $filePath = $outputPath . "FournisseurMAJ.csv";
        $helper = new CSVHelper($filePath);
    }
}
