<?php

namespace App\Model;

class SpreadsheetData {
    /**
     * @var array
     */
    protected $input;

    /**
     * @var array
     */
    protected $output;

    /**
     * SpreadsheetData constructor.
     * Handles the working data between reading from and writing to
     * the spreadsheet itself.
     *
     * @param array $input
     * @param array $output
     */
    public function __construct(array $input = [], array $output = [])
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * Set the input of the working spreadsheet data.
     *
     * @param array $input
     */
    public function setInput(array $input = [])
    {
        $this->input = $input;
    }

    /**
     * Set the output of the working spreadsheet data.
     *
     * @param array $output
     */
    public function setOutput(array $output = [])
    {
        $this->output = $output;
    }

    /**
     * Get the input.
     *
     * @return array
     */
    public function getInput(array $input = [])
    {
        return $this->input;
    }

    /**
     * Get the output.
     *
     * @return array
     */
    public function getOutput(array $output = [])
    {
        return $this->output;
    }
}
