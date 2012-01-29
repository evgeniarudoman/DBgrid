<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once getenv("DOCUMENT_ROOT") . '/' . APPPATH . 'models/basic/data_row.php';

class Table extends Data_Row {

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

    public function getDbId() {
        return $this->row->db_id;
    }

    public function setDbId($value) {
        $this->row->db_id = $value;
    }
    
    public function getUserId() {
        return $this->row->user_id;
    }

    public function setUserId($value) {
        $this->row->user_id = $value;
    }
    
    public function getNumberOfFields() {
        return $this->row->number_of_fields;
    }

    public function setNumberOfFields($value) {
        $this->row->number_of_fields = $value;
    }
    
   

    public static function table_name() {
        return 'tables';
    }

}
