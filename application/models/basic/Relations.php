<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relations extends CI_Models {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->dbforge();
    }

    public function create($db_name, $table_name, $foreign_key, $another_table, $another_field, $after = NULL, $i) {

        $this->db->query('ALTER TABLE `' . $db_name . '`.`' . $table_name . '`
                            ADD CONSTRAINT ' . $db_name . '_' . $i . ' FOREIGN KEY (`' . $foreign_key . '`) 
                            REFERENCES `' . $another_table . '` (`' . $another_field . '`) 
                            ON DELETE CASCADE ON UPDATE CASCADE;');
    }

    public function remove($db_name, $table_name, $field) {
        $this->db->query('ALTER TABLE `' . $db_name . '`.`' . $table_name . '` DROP `' . $field . '`');
    }

}
