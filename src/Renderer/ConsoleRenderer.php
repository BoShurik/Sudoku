<?php
/**
 * User: boshurik
 * Date: 04.10.18
 * Time: 0:58
 */

namespace Sudoku\Renderer;

use Sudoku\Table;

class ConsoleRenderer
{
    public function render(Table $table): string
    {
        $result = '';
        for ($row = 0; $row < Table::HEIGHT; $row++) {
            for ($column = 0; $column < Table::WIDTH; $column++) {
                if (!$value = $table->getValue($row, $column)) {
                    $result .= '_';
                } else {
                    $result .= $value;
                }
            }
            $result .= \PHP_EOL;
        }

        return $result;
    }
}