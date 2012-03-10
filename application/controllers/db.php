<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Db extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library('session');

        $this->load->model('database');
        $this->load->model('table');
        $this->load->model('field');
    }


    public function add()
    {
        $this->load->model('query');

        try
        {
            $this->query->create_database($_POST['database_name']);

            $this->database->db_name = "dbgrid";
            $database = $this->database->select(array('database_name' => $_POST['database_name']));
            $id = $database->getId();
            if (!empty($id))
            {
                $this->database->setName($_POST['database_name']);
                $this->database->setUserId($this->session->userdata('user_id'));
                $this->database->insert();
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