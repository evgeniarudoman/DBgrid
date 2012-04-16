<?php

if (!defined ('BASEPATH'))
    exit ('No direct script access allowed');

class Rows extends CI_Controller
{

    public function __construct ()
    {
        parent::__construct ();
        $this->load->helper (array ('form', 'url', 'html', 'database_tree'));
        $this->load->library ('session');

        $this->load->model ('database');
        $this->load->model ('table');
        $this->load->model ('field');
        $this->load->model ('type');
    }

    public function add ()
    {
        $user_id = $this->session->userdata ('user_id');
        $success = TRUE;
        $this->load->model ('query');
        $this->load->model ('basic/db_rows', 'rows');
        header ("Content-Type: text/html;charset=utf-8");

        try
        {
            $bool = db_table_exists ($user_id, $_POST['database_name'], $_POST['table_name']);

            if (isset ($bool) && $bool == 1)
            {
                $result = get_database_tree ($user_id);

                for ($i = 0; $i < $_POST['count']; $i++)
                {
                    foreach ($result[$_POST['database_name'] . '_' . $_POST['table_name'] . '_field'] as $field)
                    {
                        if ($field['name'] == $_POST['field' . $i])
                        {
                            $values[] = $_POST['value' . $i];
                            $fields[] = $_POST['field' . $i];
                        }
                    }
                }

                $this->rows->insert ($_POST['database_name'], $_POST['table_name'], $fields, $values);

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

        $result           = get_database_tree ($user_id);
        $result['result'] = mysql_query ("SELECT * FROM " . $_POST['database_name'] . '.' . $_POST['table_name'] . ' LIMIT 8');

        json_encode ($this->load->view (
                        'data', array (
                    'result' => $result,
                    'database' => $_POST['database_name'],
                    'table' => $_POST['table_name'],
                ))
        );
    }

    public function edit ()
    {
        $user_id = $this->session->userdata ('user_id');
        $success = TRUE;
        $this->load->model ('query');
        $this->load->model ('basic/db_rows', 'rows');
        header ("Content-Type: text/html;charset=utf-8");

        try
        {
            $bool = db_table_exists ($user_id, $_POST['database_name'], $_POST['table_name']);

            if (isset ($bool) && $bool == 1)
            {
                $result = get_database_tree ($user_id);

                for ($i = 0; $i < $_POST['count']; $i++)
                {
                    foreach ($result[$_POST['database_name'] . '_' . $_POST['table_name'] . '_field'] as $field)
                    {
                        if ($field['name'] == $_POST['field' . $i])
                        {
                            $values[]     = $_POST['value' . $i];
                            $fields[]     = $_POST['field' . $i];
                            $old_values[] = $_POST['old' . $i];
                        }
                    }
                }

                var_dump ($fields, $values);
                $this->rows->update ($_POST['database_name'], $_POST['table_name'], $fields, $values, $old_values);

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
        echo json_encode ($success);
    }

    public function remove ()
    {
        $user_id = $this->session->userdata ('user_id');
        $success = TRUE;
        $this->load->model ('query');
        $this->load->model ('basic/db_rows', 'rows');
        header ("Content-Type: text/html;charset=utf-8");

        try
        {
            $bool = db_table_exists ($user_id, $_POST['database_name'], $_POST['table_name']);

            if (isset ($bool) && $bool == 1)
            {
                $result = get_database_tree ($user_id);

                for ($i = 0; $i < $_POST['count']; $i++)
                {
                    foreach ($result[$_POST['database_name'] . '_' . $_POST['table_name'] . '_field'] as $field)
                    {
                        if ($field['name'] == $_POST['field' . $i])
                        {
                            $values[] = $_POST['value' . $i];
                            $fields[] = $_POST['field' . $i];
                        }
                    }
                }
                $this->rows->remove ($_POST['database_name'], $_POST['table_name'], $fields, $values);

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
        echo json_encode ($success);
    }

    public function select ()
    {
        $user_id = $this->session->userdata ('user_id');
        $success = TRUE;
        $this->load->model ('query');
        $this->load->model ('basic/db_rows', 'rows');
        header ("Content-Type: text/html;charset=utf-8");

        $result = get_database_tree ($user_id);
        try
        {
            $bool = db_table_exists ($user_id, $_POST['database_name'], $_POST['table_name']);

            if (isset ($bool) && $bool == 1)
            {
                $result['result'] = mysql_query ("SELECT * FROM " . $_POST['database_name'] . '.' . $_POST['table_name'] . ' LIMIT 8 OFFSET ' . $_POST['offset']);
                $success          = TRUE;
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
                    'database' => $_POST['database_name'],
                    'table' => $_POST['table_name'],
                ))
        );
    }

    public function get_table ()
    {
        header ("Content-Type: text/html;charset=utf-8");
        $user_id = $this->session->userdata ('user_id');

        $bool = db_table_exists ($user_id, $_POST['database_name'], $_POST['table_name']);

        if (isset ($bool) && $bool == 1)
        {
            $result           = get_database_tree ($user_id);
            $result['result'] = mysql_query ("SELECT * FROM " . $_POST['database_name'] . '.' . $_POST['table_name'] . ' LIMIT 8');

            json_encode ($this->load->view (
                            'data', array (
                        'result' => $result,
                        'database' => $_POST['database_name'],
                        'table' => $_POST['table_name'],
                    ))
            );
        }
    }

}