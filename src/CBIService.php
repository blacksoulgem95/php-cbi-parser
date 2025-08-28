<?php

namespace Blacksoulgem95\CbiLib;

use Blacksoulgem95\CbiLib\Processors\CbiRendicontazioneProcessor;

class CBIService
{
    private array $processors;

    public function __construct()
    {
        // Initialize processors for each CBI file type
        $this->processors = [
            "RH" => new CbiRendicontazioneProcessor(),
            "RP" => new CbiRendicontazioneProcessor(),
            "EC" => new CbiRendicontazioneProcessor(),
            "RA" => new CbiRendicontazioneProcessor(),
            "DT" => new CbiRendicontazioneProcessor(),
        ];
    }

    /**
     * Processes a CBI file by identifying its type and handling it accordingly.
     *
     * @param string $filePath The path to the CBI file to be processed.
     * @return array|string Returns processed data or an error message.
     * @throws \Exception If the file cannot be read or is of an unsupported type.
     */
    public function processCBIFile(string $filePath)
    {
        // Check if file exists and is readable
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new \Exception("Cannot read file: $filePath");
        }

        // Read the file content
        $content = file_get_contents($filePath);
        if ($content === false) {
            throw new \Exception("Failed to read content from file: $filePath");
        }

        // Split content into lines for analysis
        $lines = explode("\n", $content);
        if (empty($lines)) {
            throw new \Exception("Empty file content: $filePath");
        }

        // Get the first line to determine file type (assuming header record)
        $firstLine = trim($lines[0]);
        if (empty($firstLine)) {
            throw new \Exception(
                "Invalid file format: No header found in $filePath",
            );
        }

        // Extract potential record type (first few characters often indicate type)
        // CBI files typically start with a record type like 'RH', 'RI', 'EF', etc.
        $recordType = substr($firstLine, 0, 2);

        // Check if a processor exists for the identified type
        if (!isset($this->processors[$recordType])) {
            throw new \Exception(
                "Unsupported CBI file type: $recordType in $filePath",
            );
        }

        // Delegate processing to the appropriate processor
        return $this->processors[$recordType]->process($lines);
    }
}
