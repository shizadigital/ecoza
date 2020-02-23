<?php 

class Mc extends CI_Model
{
	// READ

	function query($q)
	{
		return $this->db->query($q)->result();
	}

	function one($table, $condition = '', $order_by = '')
	{
		if(!empty($condition)) {
			$this->db->where($condition);
		}

		if(!empty($order_by)) {
			$this->db->order_by($order_by[0], $order_by[1]);
		}

		return $this->db->get($table)->row();
	}

	function all($table, $condition = '', $order_by = '', $limit='', $opt = false)
	{
		if(!empty($condition)) {
			$this->db->where($condition);
		}

		if(!empty($limit)) {
			if(empty($limit['start'])) 
				$this->db->limit($limit);
			else 
				$this->db->limit($limit['limit'], $limit['start']);
		}

		if($opt) {
			if(!empty($opt['not_in'])) {
				$column = $opt['not_in']['column'];
				$value  = $opt['not_in']['value'];
				$this->db->where_not_in($column, $value);
			}
		}

		if(!empty($order_by)) {
			if($order_by[1] == 'random') $order_by[1] == 'rand()';
			$this->db->order_by($order_by[0], $order_by[1]);
			return $this->db->get($table)->result_object();
		}

		return $this->db->get($table)->result();
	}

	function queryDB($sql) {
		$this->db->query($sql)->result_array();
	}

	function join($table, $args, $condition = '', $order_by = '')
	{
		if(!empty($condition)) {
			$this->db->where($condition);
		}

		if(!empty($order_by)) {
			$this->db->order_by($order_by[0], $order_by[1]);
		}


		$this->db->join($args[0], $args[1]);
		return $this->db->get($table)->result();
	}

	function join_multiple($table, $args, $condition = '', $order_by = '')
	{

		if(!empty($condition)) {
			$this->db->where($condition);
		}

		if(!empty($order_by)) {
			$this->db->order_by($order_by[0], $order_by[1]);
		}

		foreach($args AS $jtable => $condition_jtable) {
			$this->db->join($jtable, $condition_jtable);
		}
		return $this->db->get($table)->result();
	}

	// CREATE
	function save($table, $data)
	{
		$this->db->insert($table, $data);
		
		return $this->db->insert_id();
	}

	// UPDATE
	function update($table, $condition, $data)
	{
		$this->db->where($condition);

		$this->db->update($table, $data);
	}

	// DELETE
	function delete($table, $condition)
	{
		// $this->db->where($condition);

		$this->db->delete($table, $condition);
	}

	/**
	 * TRUNCATE
	 * @param  string $table tablename
	 * @return truncate the table
	 */
	function truncate($table)
	{
		$this->db->truncate($table);
	}

	/**
	 * Pagination
	 * @return [type] [description]
	 */
	function pagination_fetch($table, $limit, $start, $opt='')
	{
		$fields = $this->db->list_fields($table);

		// :: UNTUK Searching agar tidak error ketika user menuliskan langsung nama url
		// :: $this->input->get('type'); bisa di ubah tergantung kebutuhan
		$access = [];
		foreach ($fields as $field)
		{
			if($field == $this->input->get('type')) {
				$access[0] = TRUE;
			}
		}

	 	// :: JOIN
	 	if(!empty($opt['join'])) {
	 		if(!empty($opt['join_select'])) {
	 			$this->db->select($opt['join_select']);
	 		}

	 		if(count($opt['join']) > 1) {
	 			foreach($opt['join'] AS $join) {
	 				$this->db->join($join['table'], $join['current'] . ' = ' . $join['with']);
	 			}
	 		} else {
	 			$this->db->join($opt['join'][0]['table'], $opt['join'][0]['current'] . ' = ' . $opt['join'][0]['with']);
	 		}
	 	}
	 	// :: SEARCH
	 	if(!empty($opt['s'])) {
	 		if(isset($access[0])) {
	 			$this->db->like($opt['type'], $opt['s']);
	 		}
	 	}

	 	if(!empty($opt['where'])) {
	 		$this->db->where($opt['where']);
	 	}

		if(!empty($opt['order'])) {
			$this->db->order_by($opt['order'][0], $opt['order'][1]);
		}

	 	// :: Untuk queris
	 	$this->db->limit($limit, $start);
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            // pre($data);
            return $data;
        }
        return false;
	}

	/**
	 * [countall]
	 * @param  [string] $table [table name]
	 * @return [int] return integer count records
	 */
	function countall($table)
	{
		return $this->db->count_all($table);
	}
}