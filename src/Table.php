<?php
/**
 * User: boshurik
 * Date: 03.10.18
 * Time: 23:45
 */

namespace Sudoku;

use Assert\Assertion;

final class Table
{
    const WIDTH = 9;
    const HEIGHT = 9;

    /**
     * @var Field[][]
     */
    private $fields;

    public function __construct(array $fields)
    {
        Assertion::count($fields, self::HEIGHT);
        Assertion::allCount($fields, self::WIDTH);
        foreach ($fields as $row) {
            Assertion::allIsInstanceOf($row, Field::class);
        }

        $this->fields = $fields;
    }

    /**
     * @param int $row
     * @param int $column
     * @return Field
     */
    public function getField(int $row, int $column): Field
    {
        Assertion::between($row, 0, self::HEIGHT - 1);
        Assertion::between($column, 0, self::WIDTH - 1);

        return $this->fields[$row][$column];
    }

    /**
     * @param int $row
     * @param int $column
     * @return int|null
     */
    public function getValue(int $row, int $column): ?int
    {
        return $this->getField($row, $column)->getValue();
    }

    /**
     * @param int $row
     * @param int $column
     * @param int|null $value
     */
    public function setValue(int $row, int $column, ?int $value)
    {
        $this->getField($row, $column)->setValue($value);
    }

    /**
     * @return bool
     */
    public function isSolved(): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        for ($i = 0; $i < self::WIDTH; $i++) {
            for ($j = 0; $j < self::HEIGHT; $j++) {
                if ($this->fields[$j][$i]->getValue() === null) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        foreach ($this->fields as $row) {
            $values = array_map(function (Field $field) {
                return $field->getValue();
            }, $row);

            if (!$this->validateValues($values)) {
                return false;
            }
        }
        for ($i = 0; $i < self::HEIGHT; $i++) {
            $values = [];
            for ($j = 0; $j < self::WIDTH; $j++) {
                $values[] = $this->fields[$j][$i]->getValue();
            }

            if (!$this->validateValues($values)) {
                return false;
            }
        }

        $partSize = (int)sqrt(self::WIDTH);
        for ($part = 0; $part < self::WIDTH; $part++) {
            $id = (int)floor($part / $partSize);
            $jd = $part % $partSize;

            $values = [];
            for ($i = 0; $i < $partSize; $i++) {
                for ($j = 0; $j < $partSize; $j++) {
                    $values[] = $this->fields[$i + $partSize * $id][$j + $partSize * $jd]->getValue();
                }
            }

            if (!$this->validateValues($values)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $values
     * @return bool
     */
    private function validateValues(array $values): bool
    {
        $values = array_filter($values);
        $count = count($values);

        return $count === count(array_unique($values));
    }
}