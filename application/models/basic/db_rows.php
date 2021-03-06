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
                if ($k == $i && !empty($old_value))
                    $old.="`" . $table_name . "`.`" . $field . "` = '" . $old_value . "' AND ";
                $k++;
            }

            $i++;
        }
        $query = substr($str, 0, strlen($str) - 1);
        $old_query = substr($old, 0, strlen($old) - 5);
        unset($str);
        unset($old);

        $vasya = "UPDATE `" . $db_name . "`.`" . $table_name . "` 
                            SET $query
                            WHERE $old_query
                            LIMIT 1";
        
        $this->db->query("UPDATE `" . $db_name . "`.`" . $table_name . "` 
                            SET $query
                            WHERE $old_query
                            LIMIT 1"
        );
    }


    public function remove($db_name, $table_name, $fields, $values)
    {
        $str = '';
        $i = 0;
        foreach ($fields as $field)
        {
            $j = 0;
            foreach ($values as $value)
            {
                if ($j == $i)
                    $str.="`" . $table_name . "`.`" . $field . "` = '" . $value . "' AND ";
                $j++;
            }

            $i++;
        }
        $query = substr($str, 0, strlen($str) - 5);
        unset($str);
        
        $this->db->query('DELETE FROM `' . $db_name . '`.`' . $table_name . '` 
                            WHERE ' . $query . '
                            LIMIT 1'
        );
    }


}
