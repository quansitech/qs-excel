<?php
namespace QsExcel\Builder;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

abstract class BuilderContract
{
    protected $spread_sheet;
    protected $sheet_name;

    public function setSpreadSheet(Spreadsheet $spread_sheet){
        $this->spread_sheet = $spread_sheet;
    }

    public function setSheetName(string $sheet_name){
        $this->sheet_name = $sheet_name;
        return $this;
    }

    public function getSheetName(){
        return $this->sheet_name ? $this->sheet_name : 'sheet' . ($this->spread_sheet->getSheetCount());
    }

    abstract  function build();
}