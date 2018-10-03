<?php
/**
 * User: boshurik
 * Date: 03.10.18
 * Time: 23:45
 */

namespace Sudoku;

use Assert\Assertion;

final class Field
{
    /**
     * @var int|null
     */
    private $value;

    /**
     * @var bool
     */
    private $configurable;

    public function __construct(int $value = null, bool $configurable = true)
    {
        $this->value = $value;
        $this->configurable = $configurable;
    }

    /**
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * @param int|null $value
     */
    public function setValue(?int $value): void
    {
        Assertion::true($this->configurable);

        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isConfigurable(): bool
    {
        return $this->configurable;
    }
}