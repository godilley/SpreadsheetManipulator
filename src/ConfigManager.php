<?php

namespace App;

use Dotenv\Dotenv;
use Dotenv\Exception\ValidationException;

class ConfigManager
{
    public const REQUIRED_PARAMS = ['sitesToSearch'];

    /**
     * @var Dotenv
     */
    private $dotenv;

    public function __construct()
    {
        $this->dotenv = Dotenv::createImmutable(realpath(__DIR__ . "/../"));
        $this->dotenv->load();
    }

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
}
