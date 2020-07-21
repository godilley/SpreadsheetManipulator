<?php

namespace App;

use App\Excel;
use App\ContentSite\ContentSiteInterface;
use App\Model\SpreadsheetData;

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
     * @throws \Exception
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
            $this->data[] = new SpreadsheetData($input['input']);
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
     * @return null|string
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

            $availableCategories = array_map('mb_strtolower', $this->getAvailableCategories());

            $syncResultValidator = function (string $searchResult) use ($searchStr, &$availableCategories) {
                $searchResult = mb_strtolower($searchResult);
                $category = $this->getCategoryFromString($searchResult);

                return $category !== null;
            };

            $contentStr = $this->siteReqManager->searchSite($site, $searchStr, $syncResultValidator);
            $category = $this->getCategoryFromString($contentStr);

            if ($searchStr === null || $category === null) {
                continue;
            }

            // dump("Searched: '$searchStr' | Content Found: '$contentStr' | Parsed Category: '$category'");
            dump("Searched: '$searchStr' | Parsed Category: '$category'");

            return $category;
        }

        return null;
    }

    /**
     * @return array|string[]
     */
    public function getAvailableCategories()
    {
        return $this->configManager->fetchConfig(ConfigManager::CONF_CATEGORIES_TO_CHECK);
    }

    /**
     * @param $string
     * @return mixed|string
     */
    public function getCategoryFromString($string)
    {
        $string = mb_strtolower($string);
        $longestMatch = null;

        foreach ($this->getAvailableCategories() as $category) {
            $categoryLower = mb_strtolower(trim($category));
            $categoryLength = strlen($categoryLower);

            if (strpos($string, $categoryLower) !== false && $categoryLength > strlen(trim($longestMatch))) {
                $longestMatch = $category;
            }
        }

        return $longestMatch;
    }
}
