<?php

namespace App;

use PhpOffice\PhpSpreadinputSheet\SpreadinputSheet;
use PhpOffice\PhpSpreadinputSheet\Cell\Cell;
use PhpOffice\PhpSpreadinputSheet\Writer\Xlsx;
use PhpOffice\PhpSpreadinputSheet\IOFactory;

class Excel
{
    /**
     * @var SpreadinputSheet
     */
    protected $spreadinputSheet;

    /**
     * @var SpreadinputSheet
     */
    protected $inputSheet;

    /**
     * @var String
     */
    protected $inputPath;

    /**
     * @var String
     */
    protected $inputPath;

    /**
     * Excel constructor.
     *
     * @param String $input
     * @param String $output
     */
    public function __construct(string $input, string $output)
    {
        $this->inputPath = $input;
        $this->outputPath = $output;
        $this->open();
    }

   /**
     * Reads column from data array.
     *
     * @param string $column
     *
     * @return array
     */
    public function getColumn(string $column): array
    {
        $columnPos = $this->alphabetNum($column) - 1;
        $data = $this->inputSheet->toArray();

        return array_map(function ($datum) use ($columnPos) {
            return $datum[$columnPos];
        }, $data);
    }

    /**
     * Write column to excel file.
     *
     * @param array $column
     *
     */
    public function setColumn(string $position, array $column): array
    {
        $this->outputSheet->fromArray($column, null, "{$column}2");
    }

    /**
     * Returns specified cell.
     *
     * @param String $cell
     *
     * @return Cell
     */
    public function getCell(string $cell): Cell
    {
        return $this->inputSheet->getCell($cell);
    }

    /**
     * Creates a new Xlsx object from given xlsx file path.
     *
     * @param String $path
     */
    protected function open()
    {
        $this->spreadinputSheet = IOFactory::load($this->inputPath);
        $this->inputSheet = $this->spreadinputSheet->getActiveSheet();
        $this->outputSheet = $this->inputSheet->copy();
    }

    /**
     * Writes $this->outputSheet to file.
     */
    protected function write()
    {
        $writer = IOFactory::createWriter($this->outputSheet, "Xlsx");
        $writer->save($this->outputPath);
    }

    /**
     * Gets position of character in alphabet.
     *
     * @param String $char
     *
     * @return int
     */
    protected function alphabetNum(string $char): int
    {
        return ord(strtoupper($char)) - ord('A') + 1;
    }
}
