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

    protected function buildData(){
        if($this->data && array_filter($this->data)){
            $this->spread_sheet->getSheet(0)->fromArray($this->data, null, 'A2');
        }

    }

    abstract  function build();
}