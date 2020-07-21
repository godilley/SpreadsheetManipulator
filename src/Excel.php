<?php

namespace App;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel
{
    /**
     * @var Spreadsheet
     */
    protected $spreadsheet;

    /**
     * @var Worksheet
     */
    protected $sheet;

    /**
     * @var String
     */
    protected $inputPath;

    /**
     * @var String
     */
    protected $outputPath;

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
        $data = $this->sheet->toArray();

        return array_map(function ($datum) use ($columnPos) {
            return $datum[$columnPos];
        }, $data);
    }

    /**
     * Write column to excel file.
     *
     * @param array $column
     */
    public function setColumn(string $position, array $column)
    {
        $this->sheet->fromArray([$column], null, "{$position}2");
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
        return $this->sheet->getCell($cell);
    }

    /**
     * Creates a new Xlsx object from given xlsx file path.
     *
     * @param String $path
     */
    protected function open()
    {
        $this->spreadsheet = IOFactory::load($this->inputPath);
        $this->sheet = $this->spreadsheet->getActiveSheet();
    }

    /**
     * Writes $this->outputSheet to file.
     */
    public function write()
    {
        // $writer = IOFactory::createWriter($this->spreadsheet, "Xlsx");
        $writer = new Xlsx($this->spreadsheet);
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
