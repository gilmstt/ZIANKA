<?php

require_once APPPATH."/third_party/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php"; 
 
class Excelreader extends PHPExcel { 
    public function __construct() { 
        parent::__construct(); 
    } 
}
?>