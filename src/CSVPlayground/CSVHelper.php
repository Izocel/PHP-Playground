<?php

namespace App\CSVPlayground;

use Exception;
use League\Csv\Reader;
use League\Csv\Statement;


/**
 * @link https://csv.thephpleague.com/
 */
class CSVHelper
{
    private $filePath;
    private $data;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        $this->parseCsvFile();
        $this->print();
    }

    private function parseCsvFile(string $delimiter = ";", string $escape = "\\", string $enclosure = '"'): void
    {
        try {
            // Detect the file's encoding
            $fileContent = file_get_contents($this->filePath);
            $encoding = mb_detect_encoding($fileContent, mb_list_encodings(), true);

            if ($encoding && $encoding !== 'UTF-8') {
                $fileContent = mb_convert_encoding($fileContent, 'UTF-8', $encoding);
            }

            // Transcode the file into a temp file
            $tmpFilename = 'temp_file.csv';
            file_put_contents($tmpFilename, $fileContent);

            // Load the converted content into League\Csv
            $csv = Reader::createFromPath($tmpFilename, 'r');
            $csv->setEscape($escape);
            $csv->setEnclosure($enclosure);
            $csv->setDelimiter($delimiter);

            // If the CSV file has a header at row [0]
            // $fileContent->setHeaderOffset(0);

            // Parse the CSV data into an array
            $records = (new Statement())->process($csv);

            // Convert records to an array
            $data = [];
            foreach ($records as $record) {
                $data[] = $record;
            }

            // Clean up temporary file
            unlink($tmpFilename);

            $this->data = $data;
        } catch (Exception $e) {
            echo "Error parsing csv file: " . $e->getMessage();
        }
    }

    /**
     * Prints the parsed CSV data stored in the data property.
     */
    private function print()
    {
        print_r(json_encode($this->data));
    }
}
