<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once getenv("DOCUMENT_ROOT") . '/' . APPPATH . 'models/basic/data_row.php';

class Menu_Item_Link extends Data_Row {

    public function __construct() {
        parent::__construct();
        $this->_init_database();
    }

    public function getIdMenuItem() {
        return $this->row->entity_id;
    }

    public function setIdMenuItem($value) {
        $this->row->entity_id = $value;
    }

    public function getIdAccountType() {
        return $this->row->id_permission;
    }

    public function setIdAccountType($value) {
        $this->row->id_permission = $value;
    }

    public function getLink() {
        return $this->row->link;
    }

    public function setLink($value) {
        $this->row->link = $value;
    }

    public static function table_name() {
        return 'ci_menu_items';
    }

}
