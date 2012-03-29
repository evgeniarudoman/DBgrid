<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once 'data_row.php';

abstract class Data_Row_Simple extends Data_Row {

    public function getName() {
        return $this->row->name;
    }

    public function setName($value) {
        $this->row->name = $value;
    }

}
