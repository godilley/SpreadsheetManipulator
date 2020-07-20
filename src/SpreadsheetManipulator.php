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
        $this->validateArgs($args);

        $this->excel = new Excel($args[0], $args[1]);
    }

    public function validateArgs(array $args)
    {
        if (count($args) < 2) {
            throw new \Exception('Missing path to input file.');
        }

        if (count($args) < 3) {
            throw new \Exception('Missing path to output file name.');
        }

        return true;
    }
}
