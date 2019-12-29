<?php
namespace QsExcel\Builder\CellType;

use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class DateTypeBuilder extends TypeBuilderContract{

    public function build(array $header_option){
//        $objValidation = $this->cell->getDataValidation();
//        $objValidation->setType(DataValidation::TYPE_DATE)
//            ->setAllowBlank(true)
//            ->setShowDropDown(true)
//            ->setShowInputMessage(true)
//            ->setShowErrorMessage(true);
    }
}