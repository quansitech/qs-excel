<?php
namespace QsExcel\Builder\CellType;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

abstract class TypeBuilderContract
{
    protected $cell;

    public function __construct(Cell $cell)
    {
        $this->cell = $cell;
    }

    abstract function build(array $header_option);
}