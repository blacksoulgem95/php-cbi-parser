<?php

namespace Blacksoulgem95\CbiLib\Processors;

interface BaseCBIProcessor
{
    /**
     * Processes the CBI file content and returns structured data.
     *
     * @param array $lines The file content split into lines.
     * @return array Processed data as an array.
     */
    public function process(array $lines): array;
}
