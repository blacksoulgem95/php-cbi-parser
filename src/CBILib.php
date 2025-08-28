<?php

namespace Blacksoulgem95\CbiLib;

class CBILib
{
    public function __construct()
    {
        // Constructor logic
        // Initialize CBIService
        $this->service = new CBIService();
    }

    private CBIService $service;

    /**
     * Processes a CBI file by identifying its type and handling it accordingly.
     *
     * @param string $filePath The path to the CBI file to be processed.
     * @return array|string Returns processed data or an error message.
     * @throws \Exception If the file cannot be read or is of an unsupported type.
     */
    public function processCBIFile(string $filePath)
    {
        // Delegate processing to CBIService
        return $this->service->processCBIFile($filePath);
    }
}
