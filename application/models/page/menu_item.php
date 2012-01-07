<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once getenv("DOCUMENT_ROOT") . '/' . APPPATH . 'models/basic/data_row_simple.php';

class Menu_Item extends Data_Row_Simple {

    public function __construct() {
        parent::__construct();
        $this->_init_database();
    }

    public function getIdParentMenuItem(){
        return $this->row->id_parent_menu_item;
    }

    public function setIdParentMenuItem($value){
        $this->row->id_parent_menu_item = $value;
    }
     public function getIdAccountType() {
        return $this->row->id_permission;
    }

    public function setIdAccountType($value) {
        $this->row->id_permission = $value;
    }

    public static function table_name() {
        return 'ci_menu_items';
    }

}
