<?php
namespace QsExcel;

use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use QsExcel\Builder\BuilderContract;
use QsExcel\Builder\TypeListSource;
use QsExcel\Loader\LoaderContract;

class Excel{

    protected $spread_sheet;
    protected $builder_list = [];
    protected $loader_list = [];
    protected $load_file;

    public function __construct()
    {
        if(!class_exists(Spreadsheet::class)){
            E('require phpoffice/phpspreadsheet, you should install from composer');
        }

        $this->spread_sheet = new Spreadsheet();
        $this->spread_sheet->removeSheetByIndex(0);
        TypeListSource::getInstance($this->spread_sheet);
    }

    public function addBuild(BuilderContract $builder){
        $builder->setSpreadSheet($this->spread_sheet);
        array_push($this->builder_list, $builder);
        return $this;
    }
    
    public function addLoader(LoaderContract $loader){
        array_push($this->loader_list, $loader);
        return $this;
    }

    public function load(){
        if(!$this->load_file){
            throw new Exception('load_file is empty!');
        }
        $return_list = [];
        foreach($this->loader_list as $k => $loader){
            array_push($return_list, $loader->load($this->load_file, $k));
        }
        return $return_list;
    }

    public function setLoadFile(string $file){
        $this->load_file = $file;
        return $this;
    }

    public function output(string $file_name){
        foreach(array_reverse($this->builder_list) as $builder){
            $builder->build();
        }

        $file_name = urlencode($file_name);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $file_name . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0


        $writer = IOFactory::createWriter($this->spread_sheet, "Xlsx");
        $writer->save('php://output');
    }

    public function __call($method,$args){
        if(method_exists($this->spread_sheet, $method)){
            return call_user_func_array(array($this->spread_sheet,$method), $args);
        }else{
            E(__CLASS__.':'.$method.L('_METHOD_NOT_EXIST_'));
            return;
        }
    }
}