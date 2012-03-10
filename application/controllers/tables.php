<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tables extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library('session');

        $this->load->model('database');
        $this->load->model('table');
        $this->load->model('field');
        $this->load->model('type');
    }


    public function add()
    {
        $user_id = $this->session->userdata('user_id');
        $success = TRUE;
        $this->load->model('query');

        try
        {
            //var_dump($_POST);
            $str = '';
            for ($i = 1; $i <= $_POST['count']; $i++)
            {
                $key = '';
                if ($_POST['radio'] == $i)
                {
                    $key = 'PRIMARY KEY';
                }

                $str.='`' . $_POST['field' . $i] . '` ' . $_POST['type' . $i] . '(' . $_POST['size' . $i] . ') ' . $key . ',';
            }
            unset($i);

            $query = substr($str, 0, strlen($str) - 1);
            unset($str);

            $this->query->create_table($_POST['database'], $_POST['table_name'], $query);

            $tables = $this->table->load_collection("dbgrid");
            foreach ($tables as $table)
            {
                if ($table->getName() == $_POST['table_name'])
                {
                    $success = FALSE;
                    break;
                }
            }

            if ($success != FALSE)
            {
                $this->database->db_name = "dbgrid";
                $this->database->select(array('name' => $_POST['database'], 'user_id' => $user_id));
                $this->database->setNumberOfTables($this->database->getNumberOfTables() + 1);
                $this->database->update();

                $this->table->db_name = "dbgrid";
                $this->table->setName($_POST['table_name']);
                $this->table->setUserId($user_id);
                $this->table->setDbId($this->database->getId());
                $this->table->setNumberOfFields($_POST['count']);
                $table_id = $this->table->insert();
                
                for ($i = 1; $i <= $_POST['count']; $i++)
                {
                    $this->field->db_name = "dbgrid";
                    $this->field->setName($_POST['field' . $i]);
                    $this->field->setSize($_POST['size' . $i]);
                    $this->field->setWidth(20);
                    if ($_POST['radio'] == $i)
                    {
                        $this->field->setPrimaryKey(1);
                    }
                    $this->field->setTableId($table_id);
                    $this->field->setUserId($user_id);
                    $this->type->db_name = "dbgrid";
                    $this->type->select(array('type' => $_POST['type' . $i]));
                    $this->field->setTypeId($this->type->getId());
                    $this->field->insert();
                }
            }
        }
        catch (Exception $e)
        {
            $success = FALSE;
        }

        echo json_encode($success);
    }


    public function get_type()
    {
        $types = $this->type->load_collection("dbgrid");

        foreach ($types as $type)
        {
            $list_type[] = array('key' => $type->getType());
        }

        echo json_encode($list_type);
    }


}