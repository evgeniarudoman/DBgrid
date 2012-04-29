<?php

if (!defined ('BASEPATH'))
    exit ('No direct script access allowed');

class Fields extends CI_Controller
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
        $this->load->model ('relations');
    }

    public function save_width ()
    {
        $user_id = $this->session->userdata ('user_id');
        $success = TRUE;
        $this->load->model ('query');

        try
        {
            $bool = db_table_exists ($user_id, $_POST['database_name'], $_POST['table_name']);

            if (isset ($bool) && $bool == 1)
            {
                $result = get_database_tree ($user_id);

                foreach ($result[$_POST['database_name'] . '_' . $_POST['table_name'] . '_field'] as $field)
                {
                    if ($field['name'] == $_POST['field_name'])
                    {
                        $this->database->db_name = "dbgrid";
                        $this->database->select (array (
                            'name' => $_POST['database_name'],
                            'user_id' => $user_id
                        ));

                        $this->table->db_name = "dbgrid";
                        $this->table->select (array (
                            'db_id' => $this->database->getId (),
                            'user_id' => $user_id,
                            'name' => $_POST['table_name']
                        ));

                        $this->field->db_name = "dbgrid";
                        $this->field->select (array (
                            'table_id' => $this->table->getId (),
                            'user_id' => $user_id,
                            'name' => $_POST['field_name']
                        ));

                        $this->field->setWidth ($_POST['field_size']);
                        $this->field->update ();
                    }
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
            $success = '* Message - ' . $e->getMessage () . "\r\n" . "* Line # - " . $e->getLine () . "\r\n" . "* File - " . $e->getFile ();
        }

        echo json_encode ($success);
    }

    public function add ()
    {
        $user_id = $this->session->userdata ('user_id');
        $success = TRUE;
        $var     = TRUE;
        $this->load->model ('query');
        $this->load->model ('basic/db_fields', 'fields');

        header ("Content-Type: text/html;charset=utf-8");

        try
        {
            $bool = db_table_exists ($user_id, $_POST['database_name'], $_POST['table_name']);

            if (isset ($bool) && $bool == 1)
            {
                $result = get_database_tree ($user_id);

                foreach ($result[$_POST['database_name'] . '_' . $_POST['table_name'] . '_field'] as $field)
                {
                    if ($field['name'] == $_POST['field_name'])
                    {
                        $var = FALSE;
                    }
                }
                if ($var == TRUE)
                {
                    $this->database->db_name = "dbgrid";
                    $this->database->select (array (
                        'name' => $_POST['database_name'],
                        'user_id' => $user_id
                    ));

                    $this->table->db_name = "dbgrid";
                    $this->table->select (array (
                        'db_id' => $this->database->getId (),
                        'user_id' => $user_id,
                        'name' => $_POST['table_name']
                    ));

                    $this->type->db_name = "dbgrid";
                    $this->type->select (array (
                        'name' => $_POST['type']
                    ));

                    $this->field->db_name = "dbgrid";
                    $this->field->load_collection ("dbgrid");

                    $this->fields->add ($_POST['database_name'], $_POST['table_name'], $_POST['field_name'], $this->type->getType (), $this->type->getSize (), $this->type->getDefault (), $after   = NULL);
                    $this->field->setName ($_POST['field_name']);
                    $this->field->setTypeId ($this->type->getId ());
                    $this->field->setTableId ($this->table->getId ());
                    $this->field->setUserId ($user_id);
                    $fieldId = $this->field->insert ();

                    if (isset ($_POST['db']) && isset ($_POST['table']) && isset ($_POST['field']))
                    {
                        $this->relations->db_name = "dbgrid";
                        $this->relations->load_collection ("dbgrid");
                        $this->relations->setField ($fieldId);

                        $this->database->db_name = "dbgrid";
                        $this->database->select (array (
                            'name' => $_POST['db'],
                            'user_id' => $user_id
                        ));

                        $this->table->db_name = "dbgrid";
                        $this->table->select (array (
                            'db_id' => $this->database->getId (),
                            'user_id' => $user_id,
                            'name' => $_POST['table']
                        ));

                        $this->field->select (array (
                            'name' => $_POST['field'],
                            'table_id' => $this->table->getId (),
                            'user_id' => $user_id
                        ));

                        $this->relations->setFieldKey ($this->field->getId ());
                        $this->relations->insert ();
                    }
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
            $success = '* Message - ' . $e->getMessage () . "\r\n" . "* Line # - " . $e->getLine () . "\r\n" . "* File - " . $e->getFile ();
        }

        $result = get_database_tree ($user_id);
        json_encode ($this->load->view (
                        'structure', array (
                    'result' => $result,
                    'success' => $success,
                    'database' => $_POST['database_name'],
                    'table' => $_POST['table_name']
                ))
        );
    }

    public function remove ()
    {
        $user_id = $this->session->userdata ('user_id');
        $success = TRUE;
        $this->load->model ('query');
        $this->load->model ('basic/db_fields', 'fields');
        header ("Content-Type: text/html;charset=utf-8");

        try
        {
            $bool = db_table_exists ($user_id, $_POST['database_name'], $_POST['table_name']);

            if (isset ($bool) && $bool == 1)
            {
                for ($i = 0; $i < $_POST['count']; $i++)
                {
                    $this->fields->remove ($_POST['database_name'], $_POST['table_name'], $_POST['value' . $i]);

                    $this->database->db_name = "dbgrid";
                    $this->database->select (array ('name' => $_POST['database_name'], 'user_id' => $user_id));

                    $this->table->db_name = "dbgrid";
                    $this->table->select (array ('name' => $_POST['table_name'], 'db_id' => $this->database->getId (), 'user_id' => $user_id));

                    $this->field->db_name = "dbgrid";
                    $this->field->delete (array ('table_id' => $this->table->getId (), 'user_id' => $user_id, 'name' => $_POST['value' . $i]));
                }
                $success   = TRUE;
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
        $result  = get_database_tree ($user_id);
        json_encode ($this->load->view (
                        'structure', array (
                    'result' => $result,
                    'success' => $success,
                    'database' => $_POST['database_name'],
                    'table' => $_POST['table_name']
                ))
        );
    }

    public function select ()
    {
        $user_id = $this->session->userdata ('user_id');

        $this->database->db_name = "dbgrid";
        $this->database->select (array ('name' => $_POST['db_name'], 'user_id' => $user_id));

        $this->table->db_name = "dbgrid";
        $this->table->select (array ('name' => $_POST['table_name'], 'db_id' => $this->database->getId (), 'user_id' => $user_id));

        $this->field->db_name = "dbgrid";
        $fields = $this->field->load_collection ("dbgrid", array ('table_id' => $this->table->getId (), 'user_id' => $user_id));

        foreach ($fields as $field)
        {
            $list_field[] = array ('key' => $field->getName ());
        }

        echo json_encode ($list_field);
    }

}