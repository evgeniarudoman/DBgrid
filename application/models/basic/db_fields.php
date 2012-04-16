<?php

if (!defined ('BASEPATH'))
    exit ('No direct script access allowed');

class Db_fields extends CI_Model
{

    function __construct ()
    {
        parent::__construct ();
        $this->load->database ();
        $this->load->dbforge ();
    }

    /*
     * ALTER TABLE `tab` ADD `asdas` INT NOT NULL AFTER `id` 
     * 
     */

    public function add ($db_name, $table_name, $field, $type, $size = NULL, $default = NUll, $after = NULL)
    {
        if (!empty ($default))
            $default = 'DEFAULT "' . $default.'"';
        else
            $default = '';
        
        $this->db->query ('ALTER TABLE `' . $db_name . '`.`' . $table_name . '` ADD 
                        `' . $field . '` ' . $type . ' (' . $size . ') NOT NULL ' . $default);
    }

    public function remove ($db_name, $table_name, $field)
    {
        $this->db->query ('ALTER TABLE `' . $db_name . '`.`' . $table_name . '` DROP `' . $field . '`');
    }

    public function edit ($db_name, $table_name, $field, $new_field, $new_type, $new_size)
    {
        $this->db->query ('ALTER TABLE `' . $db_name . '` . `' . $table_name . '`
                        CHANGE `' . $field . '` `' . $new_field . '` ' . $new_type . '(' . $new_size . ') 
                        NOT NULL');
    }

}
