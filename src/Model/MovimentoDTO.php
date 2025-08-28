<?php

namespace Blacksoulgem95\CbiLib\Model;

class MovimentoDTO
{
    public string $tipo = "62";
    public int $progressivo;
    public int $progressivoMovimento;
    public string $dataValuta;
    public string $dataRegistrazione;
    public string $segno;
    public float $importo;
    public string $causale;
    public string $riferimentoBanca;
    public string $riferimentoCliente;
    public string $descrizione;
}
