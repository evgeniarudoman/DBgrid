<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Db extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'html', 'database_tree'));
        $this->load->library('session');

        $this->load->model('database');
        $this->load->model('table');
        $this->load->model('field');
    }


    public function add()
    {
        $success = TRUE;
        $user_id = $this->session->userdata('user_id');
        $this->load->model('query');

        try
        {
            $bool = db_table_exists($user_id, $_POST['database_name']);

            if (isset($bool) && $bool == 0)
            {
                $this->query->create_database($_POST['database_name']);

                $this->database->db_name = "dbgrid";
                $this->database->setName($_POST['database_name']);
                $this->database->setUserId($user_id);
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