<?php

namespace app\components;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

/**
 * Class MyReadFilter
 * @package app\components
 */
class MyReadFilter implements IReadFilter
{
    /**
     * @param string $column
     * @param int $row
     * @param string $worksheetName
     * @return bool
     */
    public function readCell($column, $row, $worksheetName = '')
    {
        //  Read rows 1 to 7 and columns A to E only
        if ($row >= 1 && $row <= 5) {
            if (in_array($column, range('A', 'J'))) {
                return true;
            }
        }

        return false;
    }
}
