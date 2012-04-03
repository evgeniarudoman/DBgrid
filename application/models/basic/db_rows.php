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


    public function update($db_name, $table_name, $fields, $values, $old_values)
    {
        $str = '';
        $old = '';
        $i = 0;
        foreach ($fields as $field)
        {
            $j = 0;
            foreach ($values as $value)
            {
                if ($j == $i)
                    $str.="`" . $field . "` = '" . $value . "',";
                $j++;
            }

            $k = 0;
            foreach ($old_values as $old_value)
            {
                if ($k == $i)
                    $old.="`" . $table_name . "`.`" . $field . "` = '" . $old_value . "' AND ";
                $k++;
            }

            $i++;
        }
        $query = substr($str, 0, strlen($str) - 1);
        $old_query = substr($old, 0, strlen($old) - 5);
        unset($str);
        unset($old);

        $this->db->query("UPDATE `" . $db_name . "`.`" . $table_name . "` 
                            SET $query
                            WHERE $old_query
                            LIMIT 1"
        );
    }


    public function remove($db_name, $table_name, $fields, $values)
    {


//DELETE FROM `Data`.`ghgfh` WHERE `ghgfh`.`id` = 8 AND `ghgfh`.`name` = \'8\' AND `ghgfh`.`field` = \'8\' LIMIT 1

        $this->db->query('DELETE FROM `' . $db_name . '`.`' . $table_name . '` 
                            WHERE `' . $table_name . '`.`' . $field_name . '` = ' . $data);
    }


}
