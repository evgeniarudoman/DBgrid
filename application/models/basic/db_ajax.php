<?php

if (!defined ('BASEPATH'))
    exit ('No direct script access allowed');

class Db_ajax extends CI_Model
{

    function __construct ()
    {
        parent::__construct ();
        $this->load->database ();
        $this->load->dbforge ();
    }

    public function search ($db_name, $table_name, $fields, $value)
    {
        $str = '';
        $i   = 0;
        foreach ($fields as $field)
        {
            $str.="`" . $field . "` LIKE '" . $value . "' OR ";
        }
        $query = substr ($str, 0, strlen ($str) - 4);
        unset ($str);


        $querys = mysql_query ("SELECT * FROM `" . $db_name . "`.`" . $table_name . "`
                            WHERE ".$query);
        
        return $querys;
    }

}
