<?php
/**
 * Created by PhpStorm.
 * User: mihail
 * Date: 03.06.18
 * Time: 9:36
 */

namespace app\components;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class MyReadFilter implements IReadFilter
{
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
