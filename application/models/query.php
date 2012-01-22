<?php

class Query extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create_db($db_name, $table_name, $user_data)
    {
        $this->db->query('CREATE DATABASE IF NOT EXISTS ' . $db_name . ' 
                        CHARACTER SET utf8 
                        COLLATE utf8_general_ci');

        $this->db->query('CREATE TABLE IF NOT EXISTS `' . $db_name . '`.`' . $table_name . '` 
                    (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`username` VARCHAR( 100 ) 
                    CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,`email` VARCHAR( 50 ) 
                    CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,`first_name` VARCHAR( 200 ) 
                    CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,`password` VARCHAR( 50 ) 
                    CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,`session_hash` VARCHAR( 200 ) 
                    CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,UNIQUE (`username` ,`email`))');

        $username = str_replace(' ', '_', $user_data['username']);
        $query = $this->db->query('INSERT INTO `' . $db_name . '`.`' . $table_name . '` 
                    (`id` ,`username` ,`email` ,`first_name` ,`password` ,`session_hash`) 
                    VALUES (NULL , "' . trim($username) . '", "' . trim($user_data['email']) . '", "' . trim($user_data['first_name']) . '", "' . trim(md5($user_data['password'])) . '", "NULL")');
        if ($query)
            return TRUE;
        else
            return FALSE;        
    }
    
    public function show_tables($db)
    {
        $query = $this->db->query('SHOW TABLES FROM '. $db);
        return $query;
    }

}

?>
