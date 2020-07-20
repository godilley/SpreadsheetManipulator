<?php

namespace App;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel
{
    /**
     * @var Spreadsheet $spreadsheet
     */
    protected $spreadsheet;

    /**
     * @var $sheet
     */
    protected $sheet;

    /**
     * Excel constructor.
     *
     * @param String $input
     * @param String $output
     */
    public function __construct(string $input, string $output)
    {
        $this->open($input);
    }

    /**
     * Reads column until
     *
     * @param string $column
     *
     * @return array
     */
    public function getColumn(string $column): array
    {
        $columnPos = $this->alphabetNum($column);
        $data = $this->sheet->toArray();

        return array_map(function ($datum) use ($columnPos) {
            return $datum[$columnPos];
        }, $data);
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
    protected function open($path)
    {
        $this->spreadsheet = IOFactory::load($path);
        $this->sheet = $this->spreadsheet->getActiveSheet();
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
