<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fields extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'html', 'database_tree'));
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
        $this->load->model('basic/db_rows', 'rows');

        try
        {
            $bool = db_table_exists($user_id, $_POST['database_name'], $_POST['table_name']);

            if (isset($bool) && $bool == 2)
            {
                $this->rows->insert($_POST['database_name'], $_POST['table_name']);
                
                
                
                
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

                $success = TRUE;
            }
            else
            {
                $success = FALSE;
            }
        }
        catch (Exception $e)
        {
            $success = FALSE;
        }

        echo json_encode($success);
    }


}