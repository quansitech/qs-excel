<?php
namespace QsExcel\Builder\CellType;

use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use QsExcel\Builder\TypeListSource;

class MultiListTypeBuilder extends TypeBuilderContract
{
    public function build(array $header_option){
        $formula = TypeListSource::getInstance()->addTypeList(explode(',', $header_option['data_source']));
    }
}