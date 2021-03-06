<?php
namespace QsExcel\Loader;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ListLoader extends LoaderContract
{
    public function load($file, $sheet_index){
        $spreadsheet = IOFactory::load($file);
        //$sheetData = $spreadsheet->getSheet($sheet_index)->toArray(null, true, true, true);

        $return_list = [];
        $worksheet = $spreadsheet->getSheet($sheet_index);
        foreach($worksheet->getRowIterator() as $row){

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $tmp = [];
            $break_flag = false;
            $n = 0;
            foreach($cellIterator as $cell){
                if($n == 0 && trim($cell->getValue()) == ''){
                    $break_flag = true;
                    break;
                }
                $n++;
                $tmp[$cell->getColumn()] = trim($cell->getValue());
            }

            if($break_flag){
                break;
            }

            $return_list[] = $tmp;
        }

        return $return_list;
    }
}