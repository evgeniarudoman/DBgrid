<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Db_tables extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->dbforge();
    }


    /*
     * @param fields = array( 'field' );
     * 
     */

    public function create($db_name, $table_name, $count, $fields, $primary = NULL)
    {
        $str = '';
        for ($i = 1; $i <= $count; $i++)
        {
            $key = '';
            if ($primary == $i)
            {
                $key = 'PRIMARY KEY';
            }

            $str.='`' . $fields[$i]['field'] . '` ' . $fields[$i]['type'] . '(' . $fields[$i]['size'] . ') ' . $key . ',';
        }
        unset($i);

        $query = substr($str, 0, strlen($str) - 1);

        $this->db->query('CREATE TABLE IF NOT EXISTS `' . $db_name . '`.`' . $table_name . '` (' . $query . ')
                    ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;
                    ');
    }


    public function rename($db_name, $table_name, $new_name)
    {
        $this->db->query('RENAME TABLE `' . $db_name . '`.`' . $table_name . '` TO `' . $db_name . '`.`' . $new_name . '`');
    }


    public function remove($db_name, $table_name)
    {
        $this->db->query('DROP TABLE `' . $db_name . '` . `' . $table_name . '`');
    }


}
