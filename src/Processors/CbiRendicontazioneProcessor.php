<?php

namespace Blacksoulgem95\CbiLib\Processors;

use Blacksoulgem95\CbiLib\Model\FooterDTO;
use Blacksoulgem95\CbiLib\Model\HeaderDTO;
use Blacksoulgem95\CbiLib\Model\InfoMovimentoDTO;
use Blacksoulgem95\CbiLib\Model\LiquiditaFuturaDTO;
use Blacksoulgem95\CbiLib\Model\MovimentoDTO;
use Blacksoulgem95\CbiLib\Model\SaldoFinaleDTO;
use Blacksoulgem95\CbiLib\Model\SaldoInizialeDTO;

class CbiRendicontazioneProcessor implements BaseCBIProcessor
{
    private HeaderProcessor $headerProcessor;

    public function __construct()
    {
        $this->headerProcessor = new HeaderProcessor();
    }

    public function process(array $lines): array
    {
        $records = [];

        foreach ($lines as $ln) {
            $line = mb_trim($ln);
            if (strlen($line) < 2) {
                continue;
            }

            $type = substr($line, 0, 2);

            error_log("parsing line ($line) of type $type");

            switch ($type) {
                case "RH":
                case "RP":
                case "EC":
                case "RA":
                case "DT":
                    $records[] = $this->headerProcessor->parse($line, $type);
                    break;

                case "61":
                    $records[] = $this->mapSaldoIniziale($line);
                    break;
                case "62":
                    $records[] = $this->mapMovimento($line);
                    break;
                case "63":
                    $records[] = $this->mapInfoMovimento($line);
                    break;
                case "64":
                    $records[] = $this->mapSaldoFinale($line);
                    break;
                case "65":
                    $records[] = $this->mapLiquiditaFutura($line);
                    break;
                case "EF":
                    $records[] = $this->mapFooter($line);
                    break;
                default:
                    // record sconosciuto
                    $records[] = $line;
            }
        }

        return $records;
    }

    private function mapHeader(string $line, string $type): HeaderDTO
    {
        $dto = new HeaderDTO();
        $dto->tipo = $type;
        $dto->mittente = substr($line, 3, 5);
        $dto->ricevente = substr($line, 8, 5);
        $dto->dataCreazione = substr($line, 13, 6);
        $dto->nomeSupporto = trim(substr($line, 19, 20));
        return $dto;
    }

    private function mapSaldoIniziale(string $line): SaldoInizialeDTO
    {
        $dto = new SaldoInizialeDTO();
        $dto->progressivo = (int) substr($line, 3, 7);
        $dto->causale = substr($line, 28, 5);
        $dto->descrizione = trim(substr($line, 33, 16));
        $dto->conto = trim(substr($line, 51, 23));
        $dto->divisa = substr($line, 74, 3);
        $dto->data = substr($line, 77, 6);
        $dto->segno = substr($line, 83, 1);
        $dto->saldo = (float) str_replace(",", ".", substr($line, 84, 15));
        return $dto;
    }

    private function mapMovimento(string $line): MovimentoDTO
    {
        $dto = new MovimentoDTO();
        $dto->progressivo = (int) substr($line, 3, 7);
        $dto->progressivoMovimento = (int) substr($line, 10, 3);
        $dto->dataValuta = substr($line, 13, 6);
        $dto->dataRegistrazione = substr($line, 19, 6);
        $dto->segno = substr($line, 25, 1);
        $dto->importo = (float) str_replace(",", ".", substr($line, 26, 15));
        $dto->causale = substr($line, 41, 2);
        $dto->riferimentoBanca = trim(substr($line, 61, 16));
        $dto->riferimentoCliente = trim(substr($line, 77, 9));
        $dto->descrizione = trim(substr($line, 86, 34));
        return $dto;
    }

    private function mapInfoMovimento(string $line): InfoMovimentoDTO
    {
        $dto = new InfoMovimentoDTO();
        $dto->progressivo = (int) substr($line, 3, 7);
        $dto->progressivoMovimento = (int) substr($line, 10, 3);
        $dto->flag = substr($line, 13, 3);
        $dto->descrizione = trim(substr($line, 16, 104));
        return $dto;
    }

    private function mapSaldoFinale(string $line): SaldoFinaleDTO
    {
        $dto = new SaldoFinaleDTO();
        $dto->progressivo = (int) substr($line, 3, 7);
        $dto->divisa = substr($line, 10, 3);
        $dto->data = substr($line, 13, 6);
        $dto->segno = substr($line, 19, 1);
        $dto->saldo = (float) str_replace(",", ".", substr($line, 20, 15));
        return $dto;
    }

    private function mapLiquiditaFutura(string $line): LiquiditaFuturaDTO
    {
        $dto = new LiquiditaFuturaDTO();
        $dto->progressivo = (int) substr($line, 3, 7);
        $dto->data1 = substr($line, 10, 6);
        $dto->saldo1 = (float) str_replace(",", ".", substr($line, 16, 15));
        return $dto;
    }

    private function mapFooter(string $line): FooterDTO
    {
        $dto = new FooterDTO();
        $dto->mittente = substr($line, 3, 5);
        $dto->ricevente = substr($line, 8, 5);
        $dto->numeroRendicontazioni = (int) substr($line, 45, 7);
        $dto->numeroRecord = (int) substr($line, 82, 7);
        return $dto;
    }
}
