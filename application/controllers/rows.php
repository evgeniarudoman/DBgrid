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

                $count = $_POST['count_input'] + $_POST['count_textarea'] + $_POST['count_select'] + $_POST['count_checkbox'] + $_POST['count_file'];
                for ($i     = 0; $i < $count; $i++)
                {
                    foreach ($result[$_POST['database_name'] . '_' . $_POST['table_name'] . '_field'] as $field)
                    {
                        if (isset ($_POST['field_textarea_' . $i]) && $field['name'] == $_POST['field_textarea_' . $i])
                        {
                            $values[] = $_POST['value_textarea_' . $i];
                            $fields[] = $_POST['field_textarea_' . $i];
                        }
                        elseif (isset ($_POST['field_input_' . $i]) && $field['name'] == $_POST['field_input_' . $i])
                        {
                            $values[] = $_POST['value_input_' . $i];
                            $fields[] = $_POST['field_input_' . $i];
                        }
                        elseif (isset ($_POST['field_select_' . $i]) && $field['name'] == $_POST['field_select_' . $i])
                        {
                            $values[] = $_POST['value_select_' . $i];
                            $fields[] = $_POST['field_select_' . $i];
                        }
                        elseif (isset ($_POST['field_checkbox_' . $i]) && $field['name'] == $_POST['field_checkbox_' . $i])
                        {
                            $values[] = 1;
                            $fields[] = $_POST['field_checkbox_' . $i];
                        }
                        elseif (isset ($_POST['field_file_' . $i]) && $field['name'] == $_POST['field_file_' . $i])
                        {
                            $values[] = $_POST['value_file_' . $i];
                            $fields[] = $_POST['field_file_' . $i];
                        }
                    }
                }
                //var_dump ($fields);
                //var_dump ($values);
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
                $count  = $_POST['count_input'] + $_POST['count_textarea'] + $_POST['count_select'] + $_POST['count_checkbox'] + $_POST['count_file'];
                for ($i      = 0; $i < $count; $i++)
                {
                    foreach ($result[$_POST['database_name'] . '_' . $_POST['table_name'] . '_field'] as $field)
                    {
                        if (isset ($_POST['field_textarea_' . $i]) && $field['name'] == $_POST['field_textarea_' . $i])
                        {
                            $values[]     = $_POST['value_textarea_' . $i];
                            $fields[]     = $_POST['field_textarea_' . $i];
                            $old_values[] = $_POST['old_textarea_' . $i];
                        }
                        elseif (isset ($_POST['field_input_' . $i]) && $field['name'] == $_POST['field_input_' . $i])
                        {
                            $values[]     = $_POST['value_input_' . $i];
                            $fields[]     = $_POST['field_input_' . $i];
                            $old_values[] = $_POST['old_input_' . $i];
                        }
                        elseif (isset ($_POST['field_select_' . $i]) && $field['name'] == $_POST['field_select_' . $i])
                        {
                            $values[]     = $_POST['value_select_' . $i];
                            $fields[]     = $_POST['field_select_' . $i];
                            $old_values[] = $_POST['old_select_' . $i];
                        }
                        elseif (isset ($_POST['field_checkbox_' . $i]) && $field['name'] == $_POST['field_checkbox_' . $i])
                        {
                            $values[]     = 1;
                            $fields[]     = $_POST['field_checkbox_' . $i];
                            $old_values[] = $_POST['old_checkbox_' . $i];
                        }
                        elseif (isset ($_POST['field_file_' . $i]) && $field['name'] == $_POST['field_file_' . $i])
                        {
                            $values[]     = $_POST['value_file_' . $i];
                            $fields[]     = $_POST['field_file_' . $i];
                            $old_values[] = $_POST['old_file_' . $i];
                        }
                    }
                }
                //var_dump ($fields);
                //var_dump ($values);
                //var_dump ($old_values);

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
                $result['result']   = mysql_query ("SELECT * FROM " . $_POST['database_name'] . '.' . $_POST['table_name'] . ' LIMIT ' . $_POST['limit'] . ' OFFSET ' . $_POST['offset']);
                $result['num_rows'] = ceil (mysql_num_rows (mysql_query ("SELECT * FROM " . $_POST['database_name'] . '.' . $_POST['table_name'])) / $_POST['limit']);
                $success            = TRUE;
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