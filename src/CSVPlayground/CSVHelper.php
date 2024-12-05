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
    private $csvRows;
    private $data;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        $this->parseCsvFile();
        $this->parseCsvRow();
        $this->print();
    }

    /**
     * Parses the CSV file specified by the file path, converting its encoding to UTF-8 if necessary.
     * Loads the CSV data using the League\Csv library and processes it into an array of records.
     * Stores the parsed records in the csvRows property and handles any exceptions that occur during parsing.
     */
    private function parseCsvFile(): void
    {
        try {
            // Detect the file's encoding
            $fileContent = file_get_contents($this->filePath);
            $encoding = mb_detect_encoding($fileContent, mb_list_encodings(), true);

            if ($encoding && $encoding !== 'UTF-8') {
                $fileContent = mb_convert_encoding($fileContent, 'UTF-8', $encoding);
            }

            // Load the converted content into League\Csv
            $tmpFilename = 'temp_file.csv';
            file_put_contents($tmpFilename, $fileContent);
            $fileContent = Reader::createFromPath($tmpFilename, 'r');

            // If the CSV file has a header at row [0]
            // $csv->setHeaderOffset(0);

            // Parse the CSV data into an array
            $records = (new Statement())->process($fileContent);

            // Convert records to an array
            $csvRows = [];
            foreach ($records as $record) {
                $csvRows[] = $record;
            }

            // Clean up temporary file
            unlink($tmpFilename);

            $this->csvRows = $csvRows;
        } catch (Exception $e) {
            echo "Error parsing csv file: " . $e->getMessage();
        }
    }


    /**
     * Copies the parsed CSV rows into the data property.
     *
     * @param string $delimiter The delimiter used in the CSV file. Default is ";".
     * @param string $escaper The escape character used in the CSV file. Default is "\\".
     */
    private function parseCsvRow(string $delimiter = ";", string $escaper = "\\")
    {
        $data = [];
        foreach ($this->csvRows as $row) {
            $data[] = $row;
        }

        $this->data = $data;
    }

    /**
     * Prints the parsed CSV data stored in the data property.
     */
    private function print()
    {
        print_r($this->data);
    }
}
