<?php

namespace App\Model;

class SpreadsheetData {
    /**
     * @var String
     */
    protected $title;

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
     * @param String $title
     * @param array $input
     * @param array $output
     */
    public function __construct(string $title = '', array $input = [], array $output = [])
    {
        $this->title = $title;
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * Set the title of the working sreadsheet data.
     *
     * @param string $title
     */
    public function setTitle(string $title = '')
    {
        $this->title = $title;
    }

    /**
     * Set the input of the working sreadsheet data.
     *
     * @param array $input
     */
    public function setInput(array $input = [])
    {
        $this->input = $input;
    }

    /**
     * Set the output of the working sreadsheet data.
     *
     * @param array $output
     */
    public function setOutput(array $output = [])
    {
        $this->output = $output;
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle(string $title = '')
    {
        return $this->title;
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
