<?php

if (!defined ('BASEPATH'))
    exit ('No direct script access allowed');

class Tables extends CI_Controller
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
        $this->load->model ('basic/db_tables', 'tables');

        try
        {
            $bool = db_table_exists ($user_id, $_POST['database'], $_POST['table_name']);

            if (isset ($bool) && $bool == 2)
            {
                for ($i = 1; $i <= $_POST['count']; $i++)
                {
                    $this->type->db_name = "dbgrid";
                    $this->type->select (array ('name' => $_POST['type' . $i]));
                    
                    $fields[$i] = array (
                        'field' => $_POST['field' . $i],
                        'type' => $this->type->getType(),
                        'size' => $this->type->getSize()
                    );
                }
                unset ($i);
                //var_dump($fields);
                
                $this->tables->create ($_POST['database'], $_POST['table_name'], $_POST['count'], $fields);

                $this->database->db_name = "dbgrid";
                $this->database->select (array ('name' => $_POST['database'], 'user_id' => $user_id));
                $this->database->setNumberOfTables ($this->database->getNumberOfTables () + 1);
                $this->database->update ();

                $this->table->db_name = "dbgrid";
                $this->table->setName ($_POST['table_name']);
                $this->table->setUserId ($user_id);
                $this->table->setDbId ($this->database->getId ());
                $this->table->setNumberOfFields ($_POST['count']);
                $table_id = $this->table->insert ();

                for ($i = 1; $i <= $_POST['count']; $i++)
                {
                    $this->field->db_name = "dbgrid";
                    $this->field->setName ($_POST['field' . $i]);
                    //$this->field->setSize ($this->type->getSize());
                    $this->field->setWidth (20);
                    /*if ($_POST['radio'] == $i)
                    {
                        $this->field->setPrimaryKey (1);
                    }*/
                    $this->field->setTableId ($table_id);
                    $this->field->setUserId ($user_id);
                    $this->type->db_name = "dbgrid";
                    $this->type->select (array ('name' => $_POST['type' . $i]));
                    $this->field->setTypeId ($this->type->getId ());
                    $this->field->insert ();
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
                        'left_menu', array (
                    'result' => $result,
                    'success' => $success,
                            'data'=>$_POST['database']
                ))
        );
        //echo json_encode ($success);
    }

    public function delete ()
    {
        $user_id = $this->session->userdata ('user_id');
        $success = TRUE;
        $this->load->model ('query');
        $this->load->model ('basic/db_tables', 'tables');

        try
        {
            $this->database->db_name = "dbgrid";
            $this->database->select (array ('name' => $_POST['database_name'], 'user_id' => $user_id));

            $this->table->db_name = "dbgrid";
            $this->table->delete (array ('db_id' => $this->database->getId (), 'name' => $_POST['table_name'], 'user_id' => $user_id));

            $this->tables->remove ($_POST['database_name'], $_POST['table_name']);

            $success = TRUE;
        }
        catch (Exception $e)
        {
            $success = '* Message - ' . $e->getMessage () . "\r\n" . "* Line # - " . $e->getLine () . "\r\n" . "* File - " . $e->getFile ();
        }

        $result = get_database_tree ($user_id);
        json_encode ($this->load->view (
                        'left_menu', array (
                    'result' => $result,
                    'success' => $success,
                            'data'=>$_POST['database_name']
                ))
        );
    }

    public function rename ()
    {
        $success = TRUE;
        $user_id = $this->session->userdata ('user_id');
        $this->load->model ('query');
        $this->load->model ('basic/db_tables', 'tables');

        try
        {
            $this->tables->rename ($_POST['database_name'], $_POST['table_name'], $_POST['new_name']);

            $this->database->db_name = "dbgrid";
            $this->database->select (array ('name' => $_POST['database_name'], 'user_id' => $user_id));

            $this->table->db_name = "dbgrid";
            $this->table->select (array ('db_id' => $this->database->getId (), 'name' => $_POST['table_name'], 'user_id' => $user_id));
            $this->table->setName ($_POST['new_name']);
            $this->table->update ();

            $success = TRUE;
        }
        catch (Exception $e)
        {
            $success = '* Message - ' . $e->getMessage () . "\r\n" . "* Line # - " . $e->getLine () . "\r\n" . "* File - " . $e->getFile ();
        }

        $result = get_database_tree ($user_id);
        json_encode ($this->load->view (
                        'left_menu', array (
                    'result' => $result,
                    'success' => $success,
                            'data'=>$_POST['database_name']
                ))
        );
    }

    public function get_type ()
    {
        $types = $this->type->load_collection ("dbgrid");

        foreach ($types as $type)
        {
            $list_type[] = array ('key' => $type->getName ());
        }

        echo json_encode ($list_type);
    }
    
    public function form ()
    {
        json_encode ($this->load->view ('templates/table-form'));
    }

}