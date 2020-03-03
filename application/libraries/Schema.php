<?php 

/**
 * CREATED BY SHIZA DIGITAL
 * CUSTOM MIGRATION LIBRARY
 * since 2016
 */

class Schema
{
	function __construct(){	}

	function create_table($table_name)
	{
		$schemaDefinition = new SchemaDefinition($table_name);
		return $schemaDefinition;
	}	

	function drop_table($table_name)
	{
		$CI =& get_instance();

		$CI->load->dbforge();
		$CI->dbforge->drop_table($table_name, TRUE);
	}	
}

class SchemaDefinition
{
	function __construct($table_name)
	{
		$this->CI 		=& get_instance();
		$this->table 	=  $table_name;
		$this->CI->load->dbforge();

	}

	function run()
	{
		return $this->CI->dbforge->create_table($this->table, TRUE);
	}

	function increments($field_name, $config = null)
	{
		$fields = array(
				$field_name => array(
						'type' 				=> (isset($config['type'])) ? $config['type'] : 'INT',
						'constraint'		=> (isset($config['length'])) ? $config['length']: '255',
						'unsigned'			=> TRUE,
						'auto_increment'	=> TRUE,
					)
			);
		$this->CI->dbforge->add_field($fields);
		$this->CI->dbforge->add_key($field_name, TRUE);
	}

	function integer($field_name, $config = null)
	{
		$fields = array(
				$field_name => array(
						'type' 				=> (isset($config['type'])) ? $config['type'] : 'INT',
						'constraint'		=> (isset($config['length'])) ? $config['length']: '255',
						'unsigned'			=> (isset($config['unsigned'])) ? $config['unsigned'] : '',
					)
			);
		$this->CI->dbforge->add_field($fields);
	}

	function primary($field_name) 
	{
		$prefix = isset($_ENV['DB_PREFIX']) ? $_ENV['DB_PREFIX'] : '';
		$sql = "ALTER TABLE  ".$prefix.$this->table." ADD PRIMARY KEY (  ".$field_name." )";
		$this->CI->db->query($sql);
	}

	function index($field_name) 
	{
		$prefix = isset($_ENV['DB_PREFIX']) ? $_ENV['DB_PREFIX'] : '';
		$sql = "ALTER TABLE  ".$prefix.$this->table." ADD INDEX (  ".$field_name." )";
		$this->CI->db->query($sql);
	}

	function string($field_name, $config = null)
	{
		$fields = array(
				$field_name => array(
						'type' 				=> 'VARCHAR',
						'constraint'		=> (isset($config['length'])) ? $config['length']: '255',
					)
			);
		$this->CI->dbforge->add_field($fields);
	}

	function text($field_name, $config = null) 
	{
		$fields = array(
				$field_name => array(
						'type' 		=> (isset($config['type'])) ? $config['type'] : 'TEXT',
						'null'		=> (isset($config['null'])) ? $config['null'] : TRUE,
					)
			);
		$this->CI->dbforge->add_field($fields);
	}

	function time($field_name, $config = null)
	{
		$fields = array(
				$field_name => array(
						'type'		=> 'TIME',
						'null'		=> (isset($config['null'])) ? $config['null'] : TRUE,
					)
			);
		$this->CI->dbforge->add_field($fields);
	}

	function date($field_name, $config = null)
	{
		$fields = array(
				$field_name => array(
						'type'		=> 'DATE',
						'null'		=> (isset($config['null'])) ? $config['null'] : TRUE,
					)
			);
		$this->CI->dbforge->add_field($fields);
	}

	function datetime($field_name, $config = null)
	{
		$fields = array(
				$field_name => array(
						'type'		=> 'DATETIME',
						'null'		=> (isset($config['null'])) ? $config['null'] : TRUE,
					)
			);
		$this->CI->dbforge->add_field($fields);
	}

	function char($field_name, $config = null)
	{
		$fields = array(
				$field_name => array(
						'type'		 => 'CHAR',
						'constraint' => (isset($config['length'])) ? $config['length']: '255',
						'null'		 => (isset($config['null'])) ? $config['null'] : TRUE,
					)
			);
		$this->CI->dbforge->add_field($fields);
	}

	function timestamp()
	{
		$fields = array(
				'created_at' => array(
						'type'		=> 'DATETIME',
						'null'		=> TRUE
					),
				'updated_at' => array(
						'type'		=> 'DATETIME',
						'null'		=> TRUE
					)
			);
		$this->CI->dbforge->add_field($fields);
	}


	function enum($field_name, $type)
	{
		// FILTER ENUM
		if(count($type) == 1) {
			$final_types = 'ENUM("'.$type[0].'")';
		} else {
			// $count_arr_types = count($type);
			$count = 0;
			$ft = '';
			foreach($type AS $t) {
				if($count == 0) {
					$ft .= '"'.$t.'"';
				} else {
					$ft .= ',' . '"'.$t.'"';
				}
				$count++;
			}

			$final_types = 'ENUM('.$ft.')';
		}
		// END FILTER ENUM 
		$fields = array(
				$field_name => array(
						'type'		=> $final_types,
						'default'	=> $type[0]
					)
			);
		$this->CI->dbforge->add_field($fields);
	}

	function drop()
	{
		$this->CI->dbforge->drop_table($this->table,TRUE);
	}
}