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
        $this->load->model('basic/db_databases', 'databases');

        try
        {
            $bool = db_table_exists($user_id, $_POST['database_name']);

            if (isset($bool) && $bool == 0)
            {
                $this->databases->create($_POST['database_name']);

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
            $success = '* Message - ' . $e->getMessage () . "\r\n" . "* Line # - " . $e->getLine () . "\r\n" . "* File - " . $e->getFile ();
        }

        echo json_encode($success);
    }


    public function delete()
    {
        $success = TRUE;
        $user_id = $this->session->userdata('user_id');
        $this->load->model('query');
        $this->load->model('basic/db_databases', 'databases');

        try
        {
            $this->databases->remove($_POST['database_name']);

            $this->database->db_name = "dbgrid";
            $this->database->delete(array('name' => $_POST['database_name'], 'user_id' => $user_id));

            $success = TRUE;
        }
        catch (Exception $e)
        {
            $success = '* Message - ' . $e->getMessage () . "\r\n" . "* Line # - " . $e->getLine () . "\r\n" . "* File - " . $e->getFile ();
        }

        echo json_encode($success);
    }


    public function rename()
    {
        $success = TRUE;
        $user_id = $this->session->userdata('user_id');
        $this->load->model('query');
        $this->load->model('basic/db_databases', 'databases');

        try
        {
            $this->databases->rename($_POST['database_name'], $_POST['new_name']);

            $this->database->db_name = "dbgrid";
            $this->database->select(array('name' => $_POST['database_name'], 'user_id' => $user_id));
            $this->database->setName($_POST['new_name']);
            $this->database->update();

            $success = TRUE;
        }
        catch (Exception $e)
        {
           $success = '* Message - ' . $e->getMessage () . "\r\n" . "* Line # - " . $e->getLine () . "\r\n" . "* File - " . $e->getFile ();
        }

        echo json_encode($success);
    }


}