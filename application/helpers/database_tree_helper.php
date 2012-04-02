<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_database_tree'))
{

    function get_database_tree($user_id)
    {
        $grid = &get_instance();

        $grid->load->model('database');
        $grid->load->model('table');
        $grid->load->model('field');
        $grid->load->model('type');

        $databases = $grid->database->load_collection("dbgrid", array('user_id' => $user_id));

        foreach ($databases as $database)
        {
            $result['databases'][$database->getId()] = $database->getName();

            $tables = $grid->table->load_collection("dbgrid", array('user_id' => $user_id, 'db_id' => $database->getId()));

            foreach ($tables as $table)
            {
                $result[$database->getName() . '_table'][$table->getId()] = $table->getName();

                $fields = $grid->field->load_collection("dbgrid", array('user_id' => $user_id, 'table_id' => $table->getId()));

                foreach ($fields as $field)
                {

                    $type_id = $field->getTypeId();
                    $grid->type->db_name = "dbgrid";

                    $result[$database->getName() .'_'.$table->getName().'_field'][$field->getId()]['name'] = $field->getName();
                    $result[$database->getName() .'_'.$table->getName(). '_field'][$field->getId()]['size'] = $field->getSize();
                    $result[$database->getName() .'_'.$table->getName(). '_field'][$field->getId()]['width'] = $field->getWidth();

                    $grid->type->select(array('id' => $type_id));
                    $result[$database->getName() .'_'.$table->getName(). '_field'][$field->getId()]['type'] = $grid->type->getType();
                }
            }
        }
        if (isset($result))
            return $result;
    }


}


if (!function_exists('db_table_exists'))
{

    function db_table_exists($user_id, $db_name, $table_name = NULL)
    {
        $grid = &get_instance();

        $grid->load->model('database');
        $grid->load->model('table');

        $databases = $grid->database->load_collection("dbgrid", array('user_id' => $user_id, 'name' => $db_name));

        if (isset($databases) && !empty($databases))
        {
            foreach ($databases as $database)
            {
                $tables = $grid->table->load_collection("dbgrid", array('user_id' => $user_id, 'name' => $table_name, 'db_id' => $database->getId()));
                $bool = 1; // database exist

                if (isset($tables) && !empty($tables))
                {
                    $bool = 1; // database and table exist
                    break;
                }
                else
                {
                    $bool = 2; // database exist, but table doesn't exist
                }
            }
        }
        else
        {
            $bool = 0; // database doesn't exist
        }

        return $bool;
    }


}
