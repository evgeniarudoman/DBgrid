<?php

if (!defined ('BASEPATH'))
    exit ('No direct script access allowed');

if (!function_exists ('get_select'))
{

    function get_select ($field_id)
    {
        $grid = &get_instance ();
        $result   = array();

        $grid->load->model ('database');
        $grid->load->model ('table');
        $grid->load->model ('field');
        $grid->load->model ('type');
        $grid->load->model ('relations');

        $grid->database->db_name = "dbgrid";
        $grid->table->db_name = "dbgrid";
        $grid->field->db_name = "dbgrid";
        $grid->relations->db_name = "dbgrid";


        $relation = $grid->relations->load_collection ("dbgrid", array ('field_id_primary' => $field_id));

        foreach ($relation as $rel)
        {
            $grid->field->select ($rel->getFieldKey ());

            
            $grid->table->select ($grid->field->getTableId());
            $grid->database->select ($grid->table->getDbId());
            
            $result['mysql'] = mysql_query ("SELECT " . $grid->field->getName () . " FROM " . $grid->database->getName() . '.' . $grid->table->getName());
            $result['name'] = $grid->field->getName ();
        }
        
        return $result;
    }

}
