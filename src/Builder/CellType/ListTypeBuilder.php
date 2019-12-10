<?php
namespace QsExcel\Builder\CellType;

use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use QsExcel\Builder\TypeListSource;

class ListTypeBuilder extends TypeBuilderContract
{
    private $_str_option_maxlimit = 565;

    public function build(array $header_option){
        if(strlen($header_option['data_source']) > $this->_str_option_maxlimit){
            $formula = TypeListSource::getInstance()->addTypeList(explode(',', $header_option['data_source']));
        }
        else{
            $formula = '"' . $header_option['data_source'] . '"';
        }

        $objValidation = $this->cell->getDataValidation();
        $objValidation->setType(DataValidation::TYPE_LIST)
            ->setAllowBlank(false)
            ->setShowDropDown(true)
            ->setShowInputMessage(true)
            ->setShowErrorMessage(true)
            ->setFormula1($formula);
    }
}