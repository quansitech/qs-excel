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
        $row_n = 0;
        $header_n = 0;
        foreach($worksheet->getRowIterator() as $row){

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $tmp = [];
            $n = 0;
            foreach($cellIterator as $cell){
                // 表头列为空或者列数为表头数则退出
                if(($row_n == 0 && trim($cell->getValue()) == '') || ($row_n > 0 && $n === $header_n)){
                    break;
                }
                if ($row_n == 0){
                    $header_n++;
                }
                $n++;
                $tmp[$cell->getColumn()] = trim($cell->getValue());
            }

            // 行数据全部为空字符串则退出
            if(empty(array_filter($tmp, function ($ent){return trim($ent) !== '';}))){
                break;
            }

            $row_n++;
            $return_list[] = $tmp;
        }

        return $return_list;
    }
}