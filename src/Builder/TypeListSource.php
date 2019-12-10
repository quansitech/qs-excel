<?php
namespace QsExcel\Builder;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class TypeListSource{

    protected $sheet_name = 'ListSource';

    protected $current_col = 'A';

    private static $_instance;

    protected $spread_sheet;

    protected $work_sheet;

    protected $source = [];

    public static function getInstance(Spreadsheet $spread_sheet = null): TypeListSource
    {
        if (static::$_instance === null) {
            static::$_instance = new static($spread_sheet);
        }
        return static::$_instance;
    }

    private function __construct(Spreadsheet $spread_sheet)
    {
        $this->spread_sheet = $spread_sheet;
    }

    public function addTypeList(array $type_list){
        if(!$this->work_sheet){
            $this->addSheet();
        }

        //the same source only set once
        $foot_print = md5(serialize($type_list));
        if(isset($this->source[$foot_print])){
            return $this->source[$foot_print];
        }

        for($row = 1; $row <= count($type_list); $row++){
            $this->work_sheet->setCellValue($this->current_col . $row, $type_list[$row - 1]);
        }

        $formula = $this->sheet_name . "!$" . $this->current_col . '$1:$' . $this->current_col .'$' . count($type_list);
        $this->source[$foot_print] = $formula;
        $this->current_col++;
        return $formula;
    }

    protected function addSheet(){
        $this->work_sheet = new Worksheet($this->spread_sheet, $this->sheet_name);
        $this->spread_sheet->addSheet($this->work_sheet);
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}