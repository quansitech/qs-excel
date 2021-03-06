<?php
namespace QsExcel\Builder;

use QsExcel\Builder\CellType\DateTypeBuilder;
use QsExcel\Builder\CellType\ListTypeBuilder;
use QsExcel\Builder\CellType\MultiListTypeBuilder;

class ListBuilder extends BuilderContract {

    const LIST_TYPE = 'list';
    const DATE_TYPE = 'date';
    const MULTI_LIST_TYPE = 'multi_list';

    protected $type_map = [
        self::LIST_TYPE => ListTypeBuilder::class,
        self::DATE_TYPE => DateTypeBuilder::class,
        self::MULTI_LIST_TYPE => MultiListTypeBuilder::class
    ];

    public function __construct(array $options, array $data = [])
    {
        $this->setOptions($options);
        if(array_filter($data)){
            $this->setData($data);
        }
    }

    public function setOptions($options){
        $this->options = $options;
    }

    public function setData(array $data){
        $this->data = $data;
    }

    public function build(){
        $row_count = $this->options['row_count'] ?? 0;
        $row = 1;
        $sheet = $this->spread_sheet->createSheet(0);
        $sheet->setTitle($this->getSheetName());
        for($i = 0; $i < $row_count + 1; $i++, $row++){
            $col = 'A';
            foreach($this->options['headers'] as $header){
                //fill header
                if($row == 1){
                    $sheet ->setCellValue($col . $row, $header['title']);
                    $col++;
                    continue;
                }

                if(isset($this->type_map[$header['type']])){
                    $type_builder =  new $this->type_map[$header['type']]($sheet->getCell($col . $row));
                    $type_builder->build($header);
                }

                $col++;
            }
        }

        $this->buildData();
    }
}