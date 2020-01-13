<?php
namespace QsExcel\Builder\CellType;

use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use QsExcel\Builder\TypeListSource;

class ListTypeBuilder extends TypeBuilderContract
{
    private $_str_option_maxlimit = 255;

    public function build(array $header_option){
        if( preg_match('#.+?!\$([A-Z]+)\$\d+:\$\1\$\d+#', $header_option['data_source'], $match) ){
            $formula = $header_option['data_source'];
        }
        else if (mb_strlen($header_option['data_source']) > $this->_str_option_maxlimit){
            $formula = TypeListSource::getInstance()->addTypeList(explode(',', $header_option['data_source']));
        }
        else{
            $formula = '"' . $header_option['data_source'] . '"';
        }

        $objValidation = $this->cell->getDataValidation();
        $objValidation->setType(DataValidation::TYPE_LIST)
            ->setAllowBlank(true)
            ->setShowDropDown(true)
            ->setShowInputMessage(true)
            ->setShowErrorMessage(true)
            ->setFormula1($formula);
    }
}