<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once 'i_data_row.php';

abstract class Data_Row extends CI_Model implements I_Data_Row
{

    protected $row;
    public $db_name = "";

    public function getId()
    {
        return $this->row->id;
    }


    public function getSessionHash()
    {
        return $this->row->session_hash;
    }


    public function setRow($row)
    {
        $this->row = $row;
    }


    public function select($where)
    {
        $class_name = get_called_class();

        if (is_array($where))
        {
            $this->db->where($where);
        }
        else
        {
            $this->db->where('id', $where);
        }

        $query = $this->db->get($this->db_name . '.' . $class_name::table_name());      //  $die = die(var_dump($query));
        if ($query->num_rows() == 1)
            $this->row = $query->row();
        else
        {
            $message = <<<_EXC_MESSAGE
Count of rows are less or more than 1. Please use $class_name::load_collection(); to get collection or check params.
_EXC_MESSAGE;
            throw new Exception($message);
        }
    }


    public function get_unique($where, $or_where)
    {
        $class_name = get_called_class();

        $this->db->where($where);
        $this->db->or_where($or_where);

        $query = $this->db->get($this->db_name . '.' . $class_name::table_name());      //  $die = die(var_dump($query));

        if ($query->num_rows() > 0)
            $this->row = $query->result();
        else
        {
            $message = <<<_EXC_MESSAGE
Count of rows are less or more than 1. Please use $class_name::load_collection(); to get collection or check params.
_EXC_MESSAGE;
            throw new Exception($message);
        }
    }


    public function delete($where)
    {
        $class_name = get_called_class();
        if (is_array($where))
        {
            $this->db->delete($class_name::table_name(), (array) $where);
        }
        else
        {
            $this->db->delete($class_name::table_name(), array('entity_id' => $where));
        }
    }


    public function insert()
    {
        $class_name = get_called_class();
        $this->db->insert($this->db_name . '.' . $class_name::table_name(), (array) $this->row);
        $id = $this->db->insert_id();
        return $id;
    }


    public function update()
    {
        $class_name = get_called_class();
        $data = (array) $this->row;
        //$data['session_hash']=0;
        $this->db->where('id', $data['id']);
        //unset($data['entity_id']);
        $this->db->update($this->db_name . '.' . $class_name::table_name(), $data);
        //$id = $this->db->insert_id();
        return $data['entity_id'];
    }


    public function update_id($id)
    {
        $class_name = get_called_class();
        $data = (array) $this->row;
        $this->db->where('username', $data['username']);
        unset($data['username']);
        $data['username'] = $id;
        $this->db->update($class_name::table_name(), $data);
    }


    public function save()
    {
        if (property_exists($this->row, "entity_id"))
            $this->update();
        else
            $this->insert();
    }


    public function alter_table($alter_type, $table_name, $column_name, $column_definition = '', $after_field = '')
    {
        $sql = 'ALTER TABLE ' . $this->db->_protect_identifiers($table) . " $alter_type " . $this->db->_protect_identifiers($column_name);

        // DROP has everything it needs now.
        if ($alter_type == 'DROP')
        {
            return $sql;
        }

        $sql .= " $column_definition";

        if ($default_value != '')
        {
            $sql .= " DEFAULT \"$default_value\"";
        }

        if ($null === NULL)
        {
            $sql .= ' NULL';
        }
        else
        {
            $sql .= ' NOT NULL';
        }

        if ($after_field != '')
        {
            $sql .= ' AFTER ' . $this->db->_protect_identifiers($after_field);
        }

        return $sql;



        if ($alter_type = 'ADD')
        {
            //ALTER TABLE  `databases` ADD  `ollolo` INT NOT NULL AFTER  `number_of_tables`
            //ALTER TABLE table_name ADD preferences TEXT
            
            $fields = array(
                $column_name => array('type' => $column_definition)
            );
            $this->dbforge->add_column($table_name, $fields);
        }
    }


    protected function _init_database()
    {
        if (!property_exists($this, "db"))
            $this->load->database();
    }


    public static function load_collection($db_name, $where = NULL, $order_by = NULL)
    {
        $result = array();
        $db = &get_instance()->db;
        $class_name = get_called_class();
        if ($where != NULL)
            $db->where($where);
        if ($order_by != NULL)
            $db->order_by($order_by);

        $query = $db->get($db_name . '.' . $class_name::table_name());

        $i = 0;
        foreach ($query->result() as $row)
        {
            $result[] = new $class_name();
            $result[$i]->setRow($row);
            $i++;
        }

        return $result;
    }


}
