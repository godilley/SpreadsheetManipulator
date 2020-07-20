<?php

namespace App;

use App\Excel;

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
     * SpreadsheetManipulator constructor.
     * @param array $args CLI parameters
     * @throws \Exception
     */
    public function __construct(array $args)
    {
        $this->validateArgs($args);

        $this->configManager = new ConfigManager();
        $this->configManager->validateConfig(true);

        $this->excel = new Excel($args[1], $args[2]);

        $this->searchSites();
    }

    /**
     * Validates incoming command parameters.
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

    public function searchSites()
    {
        $sitesToSearch = $this->configManager->fetchConfig(ConfigManager::CONF_SITES_TO_SEARCH);

        foreach ($sitesToSearch as $siteToSearch) {
            $class = "App\ContentSite\\$siteToSearch";
            dump($class);
            exit;
        }

        dump($sitesToSearch);
        exit;
    }
}
