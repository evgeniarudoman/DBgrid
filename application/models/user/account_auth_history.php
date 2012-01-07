<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once getenv("DOCUMENT_ROOT") . '/' . APPPATH . 'models/basic/data_row.php';

class Account_Auth_History extends Data_Row {

    public function __construct() {
        parent::__construct();
        $this->_init_database();
    }

    public function getIdAccount() {
        return $this->row->id_account;
    }

    public function setIdAccount($value) {
        $this->row->id_account = $value;
    }

    public function getIP() {
        return $this->row->ip;
    }

    public function setIP($value) {
        $this->row->ip = $value;
    }

    public function getUseragent() {
        return $this->row->useragent;
    }

    public function setUseragent($value) {
        $this->row->useragent = $value = $value;
    }

    public function getLoginDate() {
        return $this->row->login_date;
    }

    public static function table_name() {
        return 'ci_accounts_auth_history';
    }

}
