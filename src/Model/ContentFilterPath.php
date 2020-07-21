<?php

namespace App\Model;

class ContentFilterPath
{
    /**
     * @var string
     */
    public const TYPE_CSS_SELECTOR = 'type_css-selector';

    /**
     * @var string
     */
    public const TYPE_XPATH_SELECTOR = 'type_xpath-selector';

    /**
     * @var array
     */
    public const TYPES = [
        self::TYPE_CSS_SELECTOR,
        self::TYPE_XPATH_SELECTOR
    ];

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $path;

    /**
     * The priority - 0 being smallest - 2,147,483,647 Being biggest for 32bit PHP and 9,223,372,036,854,775,807 for 64 bit PHP
     *
     * @var int
     */
    private $priority = 100;

    /**
     * ContentFilterPath constructor.
     * @param string $type
     * @param string $path
     * @param int|null $priority
     * @throws \Exception
     */
    public function __construct(string $type, string $path, int $priority = null)
    {
        if (!in_array($type, self::TYPES)) {
            throw new \Exception('Invalid type specified, accepted types: ' . implode(', ', self::TYPES));
        }

        $this->type = $type;
        $this->path = $path;
        $this->priority = $priority ?: $this->priority;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }
}
