<?php
namespace QsExcel\Loader;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ListLoader extends LoaderContract
{
    public function load($file, $sheet_index){
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getSheet($sheet_index)->toArray(null, true, true, true);

        $return_list = [];
         foreach($sheetData as $data){
             if(array_filter(collect($data)->flatten()->all())){
                 $return_list[] = $data;
             }
         }
         return $return_list;
    }
}