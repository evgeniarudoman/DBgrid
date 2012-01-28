<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once getenv("DOCUMENT_ROOT") . '/' . APPPATH . 'models/basic/data_row.php';

class User extends Data_Row {

    public function __construct() {
        parent::__construct();
        $this->_init_database();
    }

    public function getUsername() {
        return $this->row->username;
    }

    public function setUsername($value) {
        $this->row->username = $value;
    }

    public function getPassword() {
        return $this->row->password;
    }

    public function setPassword($value) {
        $this->row->password = $value;
    }

    public function getSessionHash() {
        return $this->row->session_hash;
    }

    public function setSessionHash($value) {
        $this->row->session_hash = $value;
    }

    public function getEmail() {
        return $this->row->email;
    }

    public function setEmail($value) {
        $this->row->email = $value;
    }

    public function getThemeId() {
        return $this->row->theme_id;
    }

    public function setThemeId($value) {
        $this->row->theme_id = $value;
    }
    
    public function getNumberOfDb() {
        return $this->row->number_of_db;
    }

    public function setNumberOfDb($value) {
        $this->row->number_of_db = $value;
    }
    
   

    public static function table_name() {
        return 'users';
    }

}
