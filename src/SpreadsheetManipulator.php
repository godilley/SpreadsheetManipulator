<?php

namespace App;

use App\Excel;
use App\ContentSite\Geizhals;

class SpreadsheetManipulator
{
    private $configManager;

    /**
     * SpreadsheetManipulator constructor.
     * @param array $args CLI parameters
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
        echo '// TODO';
    }
}
