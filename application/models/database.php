<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once getenv("DOCUMENT_ROOT") . '/' . APPPATH . 'models/basic/data_row.php';

class Database extends Data_Row {

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

    public function getUserId() {
        return $this->row->user_id;
    }

    public function setUserId($value) {
        $this->row->user_id = $value;
    }
    
    public function getNumberOfTables() {
        return $this->row->number_of_tables;
    }

    public function setNumberOfTables($value) {
        $this->row->number_of_tables = $value;
    }
    
   

    public static function table_name() {
        return 'databases';
    }

}
