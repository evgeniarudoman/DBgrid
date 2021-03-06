<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once getenv("DOCUMENT_ROOT") . '/' . APPPATH . 'models/basic/data_row.php';

class Type extends Data_Row {

    public function __construct() {
        parent::__construct();
        $this->_init_database();
    }

    public function getType() {
        return $this->row->type;
    }

    public function setType($value) {
        $this->row->type = $value;
    }
    
    public function getName() {
        return $this->row->name;
    }

    public function setName($value) {
        $this->row->name = $value;
    }
    
    public function getSize() {
        return $this->row->size;
    }

    public function setSize($value) {
        $this->row->size = $value;
    }
    
    public function getDefault() {
        return $this->row->default;
    }

    public function setDefault($value) {
        $this->row->default = $value;
    }
    
   

    public static function table_name() {
        return 'types';
    }

}
