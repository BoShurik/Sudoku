<?php
/**
 * User: boshurik
 * Date: 04.10.18
 * Time: 0:37
 */

namespace Sudoku\Solver;

use Sudoku\Table;

class Solver
{
    /**
     * @param Table $table
     * @return bool
     */
    public function solve(Table $table): bool
    {
        return $this->doSolve($table, 0 ,0);
    }

    /**
     * @param Table $table
     * @param int $row
     * @param int $column
     * @return bool
     */
    private function doSolve(Table $table, int $row, int $column): bool
    {
        $final = false;
        $nextColumn = ($column + 1) % Table::WIDTH;
        $nextRow = $row;
        if ($column + 1 >= Table::WIDTH) {
            $nextRow++;
            if ($nextRow == Table::HEIGHT) {
                $final = true;
            }
        }

        $field = $table->getField($row, $column);
        if (!$field->isConfigurable()) {
            return $final ? $table->isSolved() : $this->doSolve($table, $nextRow, $nextColumn);
        }

        $availableNumbers = range(1, Table::WIDTH);
        foreach ($availableNumbers as $value) {
            $field->setValue($value);
            if ($table->isValid()) {
                if ($final) {
                    return true;
                } elseif ($this->doSolve($table, $nextRow, $nextColumn)) {
                    return true;
                }
            }

            $field->setValue(null);
        }

        return false;
    }
}