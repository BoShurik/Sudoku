<?php
/**
 * User: boshurik
 * Date: 03.10.18
 * Time: 23:50
 */

namespace Sudoku\Factory;

use Assert\Assertion;
use Sudoku\Field;
use Sudoku\Table;

class FileFactory
{
    /**
     * @param string $path
     * @return Table
     * @throws \Assert\AssertionFailedException
     */
    public function create(string $path): Table
    {
        Assertion::file($path);

        $handler = fopen($path, 'r');

        $fields = [];
        while (($buffer = fgets($handler)) !== false) {
            $buffer = trim($buffer);
            Assertion::length($buffer, Table::WIDTH);
            $row = [];
            for ($i = 0; $i < Table::WIDTH; $i++) {
                $value = $buffer{$i};
                if ($configurable = !is_numeric($value)) {
                    $value = null;
                }
                $row[] = new Field($value, $configurable);
            }
            $fields[] = $row;
        }

        Assertion::count($fields, Table::HEIGHT);

        fclose($handler);

        return new Table($fields);
    }
}