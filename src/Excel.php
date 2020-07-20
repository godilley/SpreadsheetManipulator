<?php 

namespace App;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel
{
    public function __construct(string $path)
    {
        echo "Excel class constructor";
    }
}
