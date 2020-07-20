<?php

namespace App;

use Dotenv\Dotenv;
use Dotenv\Exception\ValidationException;

class ConfigManager
{
    public const REQUIRED_PARAMS = [self::CONF_SITES_TO_SEARCH];

    public const CONF_SITES_TO_SEARCH = 'sitesToSearch';

    /**
     * @var Dotenv
     */
    private $dotenv;

    public function __construct()
    {
        $this->dotenv = Dotenv::createImmutable(realpath(__DIR__ . "/../"));
        $this->dotenv->load();
    }

    /**
     * Validates the config, either returns the value or exits
     *
     * @param bool $exit Whether to exit if invalid - true = exits
     * @return bool
     */
    public function validateConfig(bool $exit = false)
    {
        try {
            $this->dotenv->required(self::REQUIRED_PARAMS);

            return true;
        } catch (ValidationException $exception) {
            if ($exit) {
                die(
                    'Invalid config - Please check you have all required params: ' . implode(
                        ', ',
                        self::REQUIRED_PARAMS
                    )
                );
            }

            return false;
        }
    }

    /**
     * Fetch a config from the .env file
     *
     * @param string $config
     * @return mixed|null The config from the .env or null
     */
    public function fetchConfig(string $config)
    {
        $value = $_ENV[$config] ?? null;

        return $this->formatConfig($config, $value);
    }

    /**
     * Formats a config into a specified format
     *
     * @param string $config
     * @param $value
     * @return mixed
     */
    private function formatConfig(string $config, $value)
    {
        switch ($config) {
            case self::CONF_SITES_TO_SEARCH:
                return array_filter(explode(',', str_replace(', ', ',', $value)));
                break;
        }
    }
}
