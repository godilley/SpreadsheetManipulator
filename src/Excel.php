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
     * Excel constructor.
     * @param String $input 
     * @param String $output 
     */
    public function __construct(string $input, string $output)
    {
        $this->open($input);

        $cell = $this->getCell('A1');
        var_dump($cell->getValue());
    }

    /**
     * Returns specified cell.
     *
     * $param String $cell
     */
    protected function getCell(string $cell): Cell 
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
}
