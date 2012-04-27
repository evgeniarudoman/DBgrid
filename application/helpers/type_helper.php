<?php

if (!defined ('BASEPATH'))
    exit ('No direct script access allowed');

if (!function_exists ('get_select'))
{

    function get_select ($field_id)
    {
        $grid = &get_instance ();

        $user_id = $grid->session->userdata ('user_id');
        $query   = '';

        $grid->load->model ('database');
        $grid->load->model ('table');
        $grid->load->model ('field');
        $grid->load->model ('type');
        $grid->load->model ('relations');

        $grid->database->db_name = "dbgrid";
        $grid->table->db_name = "dbgrid";
        $grid->field->db_name = "dbgrid";
        $grid->relations->db_name = "dbgrid";


        $relation = $grid->relations->load_collection ("dbgrid", array ('field1' => $field_id));

        foreach ($relation as $rel)
        {
            $grid->field->select ($rel->getFieldKey ());

            
            $grid->table->select ($grid->field->getTableId());
            $grid->database->select ($grid->table->getDbId());
            //echo "SELECT " . $grid->field->getName () . " FROM " . $grid->database->getName() . '.' . $grid->table->getName();
            //$grid->field->select (array ('user_id' => $user_id, 'table_id' => $grid->table->getId (), 'name' => $field_name));

            
            
            //$fieldName = $grid->field->getName ();
            $result['mysql'] = mysql_query ("SELECT " . $grid->field->getName () . " FROM " . $grid->database->getName() . '.' . $grid->table->getName());
            $result['name'] = $grid->field->getName ();
        }

        //$grid->field->select(array('user_id' => $user_id, 'table_id' => $grid->table->getId(), 'name' => $grid->relations->getFieldKey()));
        return $result;
    }

}
