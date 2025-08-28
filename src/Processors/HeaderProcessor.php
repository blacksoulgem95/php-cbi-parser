<?php

namespace Blacksoulgem95\CbiLib\Processors;

use Blacksoulgem95\CbiLib\Model\HeaderDTO;

class HeaderProcessor
{
    public function parse(string $line, string $type): HeaderDTO
    {
        $dto = new HeaderDTO();
        $dto->tipo = $type;
        $dto->mittente = substr($line, 3, 5);
        $dto->ricevente = substr($line, 8, 5);
        $dto->dataCreazione = substr($line, 13, 6);
        $dto->nomeSupporto = trim(substr($line, 19, 20));
        return $dto;
    }
}
