<?php

if (!defined ('BASEPATH'))
    exit ('No direct script access allowed');

class Ajax extends CI_Controller
{

    public function __construct ()
    {
        parent::__construct ();
        $this->load->helper (array ('form', 'url', 'html', 'database_tree'));
        $this->load->library ('session');

        $this->load->model ('database');
        $this->load->model ('table');
        $this->load->model ('field');
    }

    public function search ()
    {
        $user_id = $this->session->userdata ('user_id');
        $success = TRUE;
        $this->load->model ('query');
        $this->load->model ('basic/db_ajax', 'ajax');
        header ("Content-Type: text/html;charset=utf-8");

        try
        {
            $bool = db_table_exists ($user_id, $_GET['database_name'], $_GET['table_name']);

            if (isset ($bool) && $bool == 1)
            {
                $result = get_database_tree ($user_id);


                foreach ($result[$_GET['database_name'] . '_' . $_GET['table_name'] . '_field'] as $field)
                {
                    $fields[] = $field['name'];
                }

                $result['result'] = $this->ajax->search ($_GET['database_name'], $_GET['table_name'], $fields, $_GET['term']);

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
        json_encode ($this->load->view (
                'data', array (
                    'result' => $result,
                    'database' => $_GET['database_name'],
                    'table' => $_GET['table_name'],
                ))
        );;
    }

}
