<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Db_rows extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->dbforge();
    }


    public function create($db_name)
    {
        $this->db->query('CREATE DATABASE IF NOT EXISTS ' . $db_name . ' 
                        CHARACTER SET utf8 COLLATE utf8_general_ci');
    }


    public function rename($db_name, $new_name)
    {
        $this->db->query('RENAME DATABASE ' . $db_name . ' TO ' . $new_name);
    }


    public function remove($db_name, $table_name, $field_name, $data)
    {
        $this->db->query('DELETE FROM `' . $db_name . '`.`' . $table_name . '` 
                            WHERE `' . $table_name . '`.`' . $field_name . '` = ' . $data);
    }


}
