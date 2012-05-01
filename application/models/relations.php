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
        return $this->row->field_id_primary;
    }

    public function setField($value) {
        $this->row->field_id_primary = $value;
    }
    
    public function getFieldKey() {
        return $this->row->field_id;
    }

    public function setFieldKey($value) {
        $this->row->field_id = $value;
    }
    
    public function getTable() {
        return $this->row->table_id_primary;
    }

    public function setTable($value) {
        $this->row->table_id_primary = $value;
    }
    
    public function getTableKey() {
        return $this->row->table_id;
    }

    public function setTableKey($value) {
        $this->row->table_id = $value;
    }
    
   

    public static function table_name() {
        return 'relations';
    }

}
