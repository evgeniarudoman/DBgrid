<?php

class Query extends CI_Model
{

    function __construct ()
    {
        parent::__construct ();
        $this->load->database ();
        $this->load->dbforge ();
    }

    public $db_name = "dbgrid";

    public function create_default_db ()
    {
        $this->db->query ('CREATE DATABASE IF NOT EXISTS dbgrid 
                        CHARACTER SET utf8 COLLATE utf8_general_ci');

        $this->db->query ('CREATE TABLE IF NOT EXISTS `' . $this->db_name . '`.`databases` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `name` varchar(100) NOT NULL,
                            `user_id` int(10) NOT NULL,
                            `number_of_tables` int(10) NOT NULL,
                            PRIMARY KEY (`id`),
                            KEY `databases_1` (`user_id`)
                        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
                    ');
        $this->db->query ("CREATE TABLE IF NOT EXISTS `" . $this->db_name . "`.`fields` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `name` varchar(100) NOT NULL,
                            `size` int(11) NOT NULL,
                            `width` int(10) NOT NULL,
                            `primary_key` tinyint(1) NOT NULL DEFAULT '0',
                            `table_id` int(10) NOT NULL,
                            `user_id` int(10) NOT NULL,
                            `type_id` int(10) NOT NULL,
                            PRIMARY KEY (`id`),
                            KEY `fields_1` (`table_id`),
                            KEY `fields_2` (`user_id`),
                            KEY `fields_3` (`type_id`)
                        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
                    ");
        $this->db->query ('CREATE TABLE IF NOT EXISTS `' . $this->db_name . '`.`tables` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `name` varchar(100) NOT NULL,
                            `db_id` int(10) NOT NULL,
                            `user_id` int(10) NOT NULL,
                            `number_of_fields` int(10) NOT NULL,
                            PRIMARY KEY (`id`),
                            KEY `tables_1` (`db_id`),
                            KEY `tables_2` (`user_id`)
                        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
                    ');
        $this->db->query ('CREATE TABLE IF NOT EXISTS `' . $this->db_name . '`.`themes` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `style` varchar(100) NOT NULL,
                            `color` varchar(100) NOT NULL,
                            PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
                    ');

        $query = $this->db->query ('SELECT * FROM `' . $this->db_name . '`.`themes`');
        if (mysql_num_rows ($query->result_id) < 2)
        {
            $this->db->query ("INSERT INTO `" . $this->db_name . "`.`themes` (`id`, `style`, `color`) VALUES
                            (1, 'голубая', ''),
                            (2, 'серая', '');
                    ");
        }
        unset ($query);

        $this->db->query ('CREATE TABLE IF NOT EXISTS `' . $this->db_name . '`.`types` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `name` varchar(100) NOT NULL,
                            `type` varchar(100) NOT NULL,
                            PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
                    ');

        $query = $this->db->query ('SELECT * FROM `' . $this->db_name . '`.`types`');
        if (mysql_num_rows ($query->result_id) < 2)
        {
            $this->db->query ("INSERT INTO `" . $this->db_name . "`.`types` (`id`, `name`, `type`) VALUES
                                (1, 'число', 'int'),
                                (2, 'текст', 'varchar'),
                                (3, 'дата', 'date'),
                                (4, 'файл', 'varchar'),
                                (5, 'чекбокс', 'tinyint'),
                                (6, 'список', 'varchar'),
                                (7, 'переключатель', 'tinyint');
                    ");
        }
        unset ($query);

        $this->db->query ('CREATE TABLE IF NOT EXISTS `' . $this->db_name . '`.`users` (
                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                `username` varchar(100) NOT NULL,
                                `password` varchar(50) NOT NULL,
                                `session_hash` varchar(100) NOT NULL,
                                `theme_id` int(10) NOT NULL,
                                `number_of_db` int(10) NOT NULL,
                                PRIMARY KEY (`id`),
                                UNIQUE KEY `username` (`username`),
                                KEY `users_1` (`theme_id`)
                        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
                    ');

        /*
          $this->db->query ('ALTER TABLE `'.$this->db_name.'`.`databases`
          ADD CONSTRAINT `databases_1` FOREIGN KEY (`user_id`) REFERENCES `'.$this->db_name.'`.`users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
          ');

          $this->db->query ('ALTER TABLE `'.$this->db_name.'`.`fields`
          ADD CONSTRAINT `fields_1` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `fields_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `fields_3` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
          ');

          $this->db->query ('ALTER TABLE `'.$this->db_name.'`.`tables`
          ADD CONSTRAINT `tables_1` FOREIGN KEY (`db_id`) REFERENCES `databases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `tables_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
          ');

          $this->db->query ('ALTER TABLE `'.$this->db_name.'`.`users`
          ADD CONSTRAINT `users_1` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
          ');
         */
    }

    public function show_tables ()
    {
        $query = $this->db->query ('SHOW TABLES FROM ' . $this->db_name);
        return $query;
    }

    public function create_database ($db_name)
    {
        $this->db->query ('CREATE DATABASE IF NOT EXISTS ' . $db_name . ' 
                        CHARACTER SET utf8 COLLATE utf8_general_ci');
    }

    public function create_table ($db_name, $table_name, $query)
    {
        $this->db->query ('CREATE TABLE IF NOT EXISTS `' . $db_name . '`.`' . $table_name . '` (' . $query . ')
                    ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;
                    ');
    }

}

?>
