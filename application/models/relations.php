<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once getenv("DOCUMENT_ROOT") . '/' . APPPATH . 'models/basic/data_row.php';

class Relations extends Data_Row {

    public function __construct() {
        parent::__construct();
        $this->_init_database();
    }

    public function getField() {
        return $this->row->field1;
    }

    public function setField($value) {
        $this->row->field1 = $value;
    }
    
    public function getFieldKey() {
        return $this->row->field2;
    }

    public function setFieldKey($value) {
        $this->row->field2 = $value;
    }
    
   

    public static function table_name() {
        return 'relations';
    }

}
