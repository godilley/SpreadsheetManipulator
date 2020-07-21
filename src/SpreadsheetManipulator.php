<?php

namespace App;

use App\Excel;
use App\ContentSite\ContentSiteInterface;
use App\SpreadsheetData;

class SpreadsheetManipulator
{
    /**
     * @var ConfigManager
     */
    private $configManager;

    /**
     * @var \App\Excel
     */
    private $excel;

    /**
     * @var ContentSiteRequestManager
     */
    private $siteReqManager;

    /**
     * @var SpreadsheetData
     */
    private $data;

    /**
     * SpreadsheetManipulator constructor.
     *
     * @param array $args CLI parameters
     * @throws \Exception
     */
    public function __construct(array $args)
    {
        $this->validateArgs($args);

        $this->configManager = new ConfigManager();
        $this->configManager->validateConfig(true);

        $this->siteReqManager = new ContentSiteRequestManager();
        $this->excel = new Excel($args[1], $args[2]);

        $this->prepareData();
        $this->search();
    }

    /**
     * Executes search on each input entry within $this->data;
     */
    public function search()
    {
        foreach ($this->data as $datum) {
            foreach ($datum->getInput() as $row) {
                $this->searchSites($row);
            }
        }
    }

    /**
     * Creates SpreadsheetData objects from the input data and stores
     * in $this->data
     */
    public function prepareData()
    {
        foreach ($this->excelData() as $input) {
            $this->data[] = new SpreadsheetData($input['title'], $input['input']);
        }
    }

    /**
     * Returns excel data to be read from the passed excel file.
     */
    public function excelData()
    {
        $columnData = $this->excel->getColumn($this->configManager->fetchConfig('inputColumn'));
        $shifted = array_shift($columnData);

        return [
            [
                'title' => $shifted,
                'input' => $columnData,
            ]
        ];
    }

    /**
     * Validates incoming command parameters.
     *
     * @param array $args CLI parameters
     *
     * @return bool
     * @throws \Exception
     */
    public function validateArgs(array $args): bool
    {
        if (count($args) < 2) {
            throw new \Exception('Missing path to input file.');
        }

        if (count($args) < 3) {
            throw new \Exception('Missing path to output file name.');
        }

        return true;
    }

    /**
     * // TODO: Load data from spreadsheet and search based on that
     *
     * @param string $searchStr
     * @throws \Exception
     */
    public function searchSites(string $searchStr)
    {
        $sitesToSearch = $this->configManager->fetchConfig(ConfigManager::CONF_SITES_TO_SEARCH);

        foreach ($sitesToSearch as $key => $siteToSearch) {
            $class = "App\ContentSite\\$siteToSearch";

            if (!class_exists($class)) {
                throw new \Exception('Invalid site to search: ' . $siteToSearch);
            }

            $site = new $class();

            if (!($site instanceof ContentSiteInterface)) {
                throw new \Exception('Invalid instanceof loading site to search: ' . $siteToSearch);
            }

            $resp = $this->siteReqManager->searchSite($site, $searchStr);
            // dump($resp);
            // exit;
        }

        // dump($sitesToSearch);
        // exit;
    }
}
