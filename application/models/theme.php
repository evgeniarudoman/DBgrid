<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once getenv("DOCUMENT_ROOT") . '/' . APPPATH . 'models/basic/data_row.php';

class Theme extends Data_Row {

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
    
    public function getColor() {
        return $this->row->color;
    }

    public function setColor($value) {
        $this->row->color = $value;
    }

    public function getStyle() {
        return $this->row->style;
    }

    public function setStyle($value) {
        $this->row->style = $value;
    }
    
   

    public static function table_name() {
        return 'themes';
    }

}
