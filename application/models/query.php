<?php

class Query extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create_default_db()
    {
        $this->db->query('CREATE DATABASE IF NOT EXISTS dbgrid 
                        CHARACTER SET utf8 COLLATE utf8_general_ci');

        $this->db->query('CREATE TABLE IF NOT EXISTS `dbgrid`.`users` (
                    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                    `username` VARCHAR( 100 ) NOT NULL ,
                    `email` VARCHAR( 100 ) NOT NULL ,
                    `password` VARCHAR( 50 ) NOT NULL ,
                    `session_hash` VARCHAR( 100 ) NOT NULL ,
                    `theme_id` INT( 10 ) NOT NULL ,
                    `number_of_db` INT( 10 ) NOT NULL ,
                    UNIQUE (`username` , `email`)) 
                    ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;
                    ');
        $this->db->query('CREATE TABLE IF NOT EXISTS `dbgrid`.`databases` (
                    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR( 100 ) NOT NULL ,
                    `user_id` INT( 10 ) NOT NULL ,
                    `number_of_tables` INT( 10 ) NOT NULL)
                    ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;
                    ');
        $this->db->query('CREATE TABLE IF NOT EXISTS `dbgrid`.`tables` (
                    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR( 100 ) NOT NULL ,
                    `db_id` INT( 10 ) NOT NULL ,
                    `user_id` INT( 10 ) NOT NULL ,
                    `number_of_fields` INT( 10 ) NOT NULL)
                    ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;
                    ');
        $this->db->query('CREATE TABLE IF NOT EXISTS `dbgrid`.`fields` (
                    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR( 100 ) NOT NULL ,
                    `width` INT( 10 ) NOT NULL ,
                    `table_id` INT( 10 ) NOT NULL ,
                    `user_id` INT( 10 ) NOT NULL ,
                    `type_id` INT( 10 ) NOT NULL)
                    ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;
                    ');
        $this->db->query('CREATE TABLE IF NOT EXISTS `dbgrid`.`types` (
                    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `type` VARCHAR( 100 ) NOT NULL )
                    ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;
                    ');
        $this->db->query('CREATE TABLE IF NOT EXISTS `dbgrid`.`themes` (
                    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `style` VARCHAR( 100 ) NOT NULL ,
                    `color` VARCHAR( 100 ) NOT NULL )
                    ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;
                    ');
        
        $query = $this->db->query('SELECT * FROM `dbgrid`.`types`');
        if (mysql_num_rows($query->result_id) < 6)
        {
            $this->db->query('INSERT INTO `dbgrid`.`types` (`id` ,`type`)
                    VALUES (NULL ,  "text"), (NULL ,  "textarea"),
                    (NULL, "file"), (NULL, "radio"), 
                    (NULL, "checkbox"), (NULL, "select");
                    ');
        }
        unset($query);
        $query = $this->db->query('SELECT * FROM `dbgrid`.`themes`');
        if (mysql_num_rows($query->result_id) < 1)
        {
            $this->db->query('INSERT INTO `dbgrid`.`themes` (`id`,`style` ,`color`)
                    VALUES (NULL ,  "dark","#002F32");
                    ');
        }
    }

    public function show_tables($db)
    {
        $query = $this->db->query('SHOW TABLES FROM ' . $db);
        return $query;
    }

}

?>
