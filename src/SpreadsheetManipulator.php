<?php

namespace App;

use App\Excel;

class SpreadsheetManipulator
{
    /**
     * SpreadsheetManipulator constructor.
     * @param array $args CLI parameters
     */
    public function __construct(array $args)
    {
        $this->excel = new Excel();
    }
}
