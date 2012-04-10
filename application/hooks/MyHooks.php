<?php
   class MyHooks {
   	function MyDatabaseFixup() {
   		$CI =& get_instance();		
		$CI->db->simple_query('SET NAMES UTF8');
   	}	
   }
?>