<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataImport implements WithHeadingRow
{
    public function model(array $row)
    {
        return $row;
    }

    public function headingRow(): int
    {
        return 3;
    }
}
