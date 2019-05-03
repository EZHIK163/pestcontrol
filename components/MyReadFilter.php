<?php

namespace app\components;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

/**
 * Фильтр для построения отчета по дез. средствам
 */
class MyReadFilter implements IReadFilter
{
    /**
     * @inheritDoc
     */
    public function readCell($column, $row, $worksheetName = '')
    {
        if ($row >= 1 && $row <= 5) {
            if (in_array($column, range('A', 'J'))) {
                return true;
            }
        }

        return false;
    }
}
