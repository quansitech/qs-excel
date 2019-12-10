<?php
namespace QsExcel\Loader;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

abstract class LoaderContract
{
    abstract public function load(string $file, int $sheet_index);
}