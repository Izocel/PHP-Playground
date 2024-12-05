<?php

namespace App\CSVPlayground;

use Exception;
use League\Csv\Reader;
use League\Csv\Statement;


/**
 * Class CSVHelper
 *
 * A utility class for parsing CSV files using the League\Csv library.
 * It reads a CSV file, detects and converts its encoding to UTF-8 if necessary,
 * and processes the CSV data into an array format. The class supports custom
 * delimiter, enclosure, and escape characters. It also handles exceptions
 * during the parsing process and outputs the parsed data in JSON format.
 *
 * @link https://csv.thephpleague.com/
 */
class CSVHelper
{
    private $filePath;
    private $delimiter;
    private $enclosure;
    private $escape;
    private $data;

    public function __construct(string $filePath, string $delimiter = ";", string $escape = "\\", string $enclosure = '"')
    {
        $this->filePath = $filePath;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escape = $escape;

        $this->parseCsvFile();
        print_r($this->toJson());
    }

    /**
     * Parses the CSV file specified by the filePath property.
     * Detects the file's encoding and converts it to UTF-8 if necessary.
     * Loads the CSV content using the League\Csv library with specified delimiter, enclosure, and escape characters.
     * Converts the CSV records into an array and stores it in the data property.
     * Cleans up the temporary file used during processing.
     * Catches and displays any exceptions that occur during parsing.
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

            // Transcode the file into a temp file
            $tmpFilename = 'temp_file.csv';
            file_put_contents($tmpFilename, $fileContent);

            // Load the converted content into League\Csv
            $csv = Reader::createFromPath($tmpFilename, 'r');
            $csv->setDelimiter($this->delimiter);
            $csv->setEnclosure($this->enclosure);
            $csv->setEscape($this->escape);

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
     * Converts the parsed CSV data stored in the data property to a JSON string.
     *
     * @return string JSON representation of the CSV data.
     */
    private function toJson()
    {
        return json_encode($this->data);
    }
}
