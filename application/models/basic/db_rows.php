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


    public function insert($db_name, $table_name, $fields, $values)
    {
        $str = '';
        foreach ($fields as $field)
        {
            $str.='`' . $field . '` ,';
        }
        $query = substr($str, 0, strlen($str) - 1);
        unset($str);

        $str = '';
        foreach ($values as $value)
        {
            $str.="'" . $value . "' ,";
        }
        $val = substr($str, 0, strlen($str) - 1);

        $this->db->query("INSERT INTO  `" . $db_name . "`.`" . $table_name . "` (" . $query . ")
                            VALUES (" . $val . ")");
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
