<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once getenv("DOCUMENT_ROOT") . '/' . APPPATH . 'models/basic/data_row_simple.php';

class Account_Type extends Data_Row_Simple {

    public function __construct() {
        parent::__construct();
        $this->_init_database();
    }

    public function getEntityId(){
        return $this->row->entity_id;
    }

    public function setEntityId($value){
        $this->row->entity_id = $value;
    }

    public function getName(){
        return $this->row->name;
    }

    public function setName($value){
        $this->row->name = $value;
    }
    
    public static function table_name() {
        return 'ci_account_types';
    }

}
