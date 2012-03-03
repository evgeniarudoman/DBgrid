<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once getenv("DOCUMENT_ROOT") . '/' . APPPATH . 'models/basic/data_row.php';

class Field extends Data_Row {

    public function __construct() {
        parent::__construct();
        $this->_init_database();
    }

    public function getName() {
        return $this->row->name;
    }

    public function setName($value) {
        $this->row->name = $value;
    }
    
    public function getWidth() {
        return $this->row->width;
    }

    public function setWidth($value) {
        $this->row->width = $value;
    }

    public function getTableId() {
        return $this->row->table_id;
    }

    public function setTableId($value) {
        $this->row->table_id = $value;
    }
    
    public function getUserId() {
        return $this->row->user_id;
    }

    public function setUserId($value) {
        $this->row->user_id = $value;
    }
    
    public function getTypeId() {
        return $this->row->type_id;
    }

    public function setTypeId($value) {
        $this->row->type_id = $value;
    }
    
   

    public static function table_name() {
        return 'fields';
    }

}
