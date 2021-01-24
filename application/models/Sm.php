<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sm extends CI_model{

	protected $insert_id;

    /**
     * set prefix
     * 
     * @param string $table
     * @return function
     */
	private function prefixTable($table){
		return $this->db->dbprefix($table);
	}

    /**
     * get one
     * 
     * @param string $table
     * @return array|object|null
     */
    public function one($table, $params = []) {
        if(count($params) > 0) {
            $where = isset($params['where']) ? $params['where'] : null;
            $order = isset($params['order']) ? $params['order'] : null;
            if(!is_null($where)) $this->db->where($params['where']);
            if(!is_null($order)) {
                /**
                 * order => [name => asc | desc ]
                 */
                $orderBy = '';
                $index = 0;
                foreach($order AS $key => $val) {
                    if($index === 0) $orderBy .= $key . ' ' . $val;
                    else $orderBy .= ', ' . $key . ' ' . $val;
                }
                $this->db->order_by($orderBy);
            }
        }
        
        $db = $this->db->get($this->prefixTable($table));
        return $db->row();
    }

    /**
     * get all
     * 
     * @param string $table
     * @return array|object|null
     */
    public function all($table, $params = []) {
        $type = isset($params['type']) ? $params['type'] : null;
        if(count($params) > 0) {
            $where = isset($params['where']) ? $params['where'] : null;
            $order = isset($params['order']) ? $params['order'] : null;
            $limit = isset($params['limit']) ? $params['limit'] : null;

            if(!is_null($where)) $this->db->where($params['where']);
            if(!is_null($order)) {
                /**
                 * order => [name => asc | desc ]
                 */
                $orderBy = '';
                $index = 0;
                foreach($order AS $key => $val) {
                    if($index === 0) $orderBy .= $key . ' ' . $val;
                    else $orderBy .= ', ' . $key . ' ' . $val;
                }
                $this->db->order_by($orderBy);
            }
            if(!is_null($limit)) {
                $limit = $limit['limit'];
                $start = $limit['start'];

                if(isset($start) && isset($finish)) $this->db->limit($limit, $start);
                else $this->db->limit($limit);
            }
        }

        $db = $this->db->get($this->prefixTable($table));
        if($type === 'object') return $db->result_object();
		else return $db->result();
	}
	
	/**
	 * Get data in db with simple selecting
	 *
	 * @param array|string $fieldToDisplay
	 * @param array|string $table
	 * @param array $params
	 * @return object|array
	 */
	public function viewData($field='*', $table, $params=[]){
		// table
        if( is_array($table) ){
            $dttable = [];
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
		}
                
		$fieldToDisplay = is_array($field) ? implode(',', $field):$field;
		$this->db->select( $fieldToDisplay );
		$this->db->from($theTable);
		
		if(count($params) > 0) {
			// join
			$join = isset($params['join']) ? $params['join'] : null;

			// where
			$where = isset($params['where']) ? $params['where'] : null;

			// group by
			$group = isset($params['group']) ? $params['group'] : null;;

			// order by
			$order = null;
			if(isset($params['order'])){
				
				if(count($params['order']) > 0){
					$orderBy = [];
					foreach($params['order'] AS $field => $sort) {
						$orderBy[] = $field . ' ' . $sort;
					}
					$order = implode(',', $orderBy);
					
				}
			}
			
			// limit
			$limit = isset($params['limit']) ? $params['limit'] : null;

			/*
			 *implementation
			 *
			 */
			if(!is_null($join)){
				
				foreach($join as $joinData){
					$tableJoin = empty($joinData['table']) ? '':$joinData['table'];
					$on = empty($joinData['on']) ? '':$joinData['on'];
					$type = empty($joinData['type']) ? '':$joinData['type'];
					$escape = empty($joinData['escape']) ? NULL:$joinData['escape'];

					$this->db->join($tableJoin, $on, $type, $escape);
				}

			}
			if(!is_null($where)) $this->db->where($where);
			if(!is_null($group)) $this->db->group_by($group);
			if(!is_null($order)) $this->db->order_by($order);
			if(!is_null($limit)){

				if(is_array($limit)){

					$offset = isset($limit[1]) ? $limit[1] : null;
					if($offset != null){
						$this->db->limit($limit[0], $offset);
					} else {
						$this->db->limit($limit[0]);
					}

				} else {
					
					$this->db->limit($limit);
				
				}

			}
			
		}

		// data type
        $type = isset($params['type']) ? $params['type'] : null;

        $db = $this->db->get();
        if($type === 'object') return $db->result_object();
		else return $db->result_array();
	}

	/**
	 * primitive query
	 *
	 * @param string $query
	 * @return array|bool for false
	 */
	public function query( $query ){
		$query = $this->db->query( $query );
		if($query){
			return $query->result_array();
		} else {
			return false;
		}
	}

    /**
	 * Insert data
	 *
	 * @param string $table
	 * @param array $data
	 * @return int|bool for false
	 */
    public function insert($table, $data){
        $insert = $this->db->insert( $this->prefixTable($table), $data);
        if( $insert ) {
			$this->insert_id = $this->db->insert_id();
            return true;
        } else {
            return false;
        }
	}
	
	/**
	 * last insert ID from table
	 *
	 * @return int
	 */
	public function insert_id(){
		return $this->insert_id;
	}
    
    /**
	 * update data
	 *
	 * @param string $table
	 * @param array|string $data
	 * @param array $where
	 * @return bool
	 */
    public function update($table, $data, $where){
        $this->db->where( $where );
        return $this->db->update( $this->prefixTable($table), $data ); 
    }

    /**
	 * delete data
	 *
	 * @param string $table
	 * @param array|string $where
	 * @return void
	 */
    public function delete($table, $where){
        $this->db->where( $where );
        return $this->db->delete( $this->prefixTable($table));
    }


	/**
	 * get next ID form the table (ID + 1). ID must be integer
	 *
	 * @param string $idfield
	 * @param string|array $tablename
	 * @return int
	 */
    public function getNextId($idfield,$tableName){
        if( is_array($tableName) ){
            $dttable = array();
            foreach ($tableName as $key => $value) {
                $dttable[] = $this->prefixTable( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->prefixTable($tableName);
        }

        $this->db->select_max($idfield, 'latestId');
        $latestId = $this->db->get( $theTable )->row()->latestId;
        $nowId=1;
        if (!empty($latestId)){
            $nowId = $latestId+1;
        }
        return $nowId;
    }

	/**
	 * Get maximum value from the field of the table then +1
	 *
	 * @param string|array $table
	 * @param string $sortfieldname
	 * @param string|array $where
	 * @return int
	 */
    public function nextSort($table, $sortfieldname, $where=null) {
        $this->db->select_max($sortfieldname, 'maxSort');
        if(!empty($where)){
            $this->db->where($where);
        }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->prefixTable( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->prefixTable($table);
        }

        $maksimalsort = $this->db->get( $theTable )->row()->maxSort;
        $nextSort = $maksimalsort + 1;
        return $nextSort;
    }


    /**
	 * count rows from the table
	 *
	 * @param string|array $table
	 * @param array|string $whereClause
	 * @return int
	 */
    public function countData($table,$whereClause=null){
        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->prefixTable( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->prefixTable($table);
        }

        $this->db->select("count(*) AS total");
        $this->db->from( $theTable );
        if($whereClause!==null){ $this->db->where($whereClause); }
        $query = $this->db->get();
        return $query->row()->total;
    }

    /**
	 * get the value from a row 
	 *
	 * @param string|array $fieldToDisplay
	 * @param string|array $table
	 * @param mixed $fieldReference
	 * @param string $method_data
	 * @return array|object
	 */
    public function getValue($fieldToDisplay,$table,$fieldReference=null,$method_data = 'array'){
        $error=false;

        $result_ = '';
        if( $this->countData($table, $fieldReference) > 0 ){
			
			// check field to display
			if( is_array($fieldToDisplay) ){
                foreach ($table as $key => $val) {
                    $dttable[] = $this->prefixTable( $val );
                }
                $fieldToDisplay = implode(',', $dttable);
            }

            if( is_array($table) ){
                $dttable = array();
                foreach ($table as $key => $val) {
                    $dttable[] = $this->prefixTable( $val );
                }
                $theTable = implode(',', $dttable);
            } else {
                $theTable = $this->prefixTable($table);
            }

            $this->db->select( $fieldToDisplay );
            $this->db->from( $theTable );

            if( !is_null($fieldReference) ){
                $this->db->where($fieldReference);
            }

            $this->db->limit(1);

            $query = $this->db->get();

            if(!$query){
                if(!$error){
                    $error = 'Server sedang sibuk. Data tidak dapat diproses';
                }else{
                    $error .= 'Server sedang sibuk. Data tidak dapat diproses';
                }

                show_error($error,503,'Server sibuk');
                exit;
            }

            $data = $query->result_array()[0];

            $result = array();
            $countdata = count($data);
            if($countdata > 0){
                foreach($data as $key => $value){
                    if($countdata > 1){
                        $result[$key] = $value;
                    } else {
                        $result = $value; break;
                    }
                }
            }

            if($method_data == 'object'){
                $result_ = (object) $result;
            } elseif($method_data == 'array'){
                $result_ = $result;
            }
        }
        return $result_;
    }

	/**
	 * get the maximum some field form the table
	 *
	 * @param string|array $field
	 * @param string|array $table
	 * @param mixed $where
	 * @param string $fieldview
	 * @return mixed
	 */
    public function getMax($field, $table, $where = null, $fieldview = null){
		// check field to display
		if( is_array($field) ){
			foreach ($table as $key => $val) {
				$dttable[] = $this->prefixTable( $val );
			}
			$field = implode(',', $dttable);
		}

        if(!empty($fieldview)){
            $this->db->select_max($field, $fieldview);
            $fieldview = $fieldview;
        } else {
            $this->db->select_max($field);
            $fieldview = $field;
        }

        if(!empty($where)){
            $this->db->where($where);
        }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->prefixTable( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->prefixTable($table);
        }
        
        $latest = $this->db->get( $theTable )->row_array()[$fieldview];
        return $latest;
    }

	/**
	 * get the minimum some field form the table
	 *
	 * @param string|array $field
	 * @param string|array $table
	 * @param mixed $where
	 * @param string $fieldview
	 * @return mixed
	 */
    public function getMin($field, $table, $where = null, $fieldview = null){
        if(!empty($fieldview)){
            $this->db->select_min($field, $fieldview);
            $fieldview = $fieldview;
        } else {
            $this->db->select_min($field);
            $fieldview = $field;
        }

        if(!empty($where)){
            $this->db->where($where);
        }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->prefixTable( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->prefixTable($table);
        }
        
        $latest = $this->db->get( $theTable )->row_array()[$fieldview];
        return $latest;
    }

    /**
	 * Truncate some table
	 *
	 * @param string $tablename
	 * @return bool
	 */
    public function truncate($tablename = null){

        if( !empty($tablename) ){
            return $this->db->truncate($this->prefixTable($tablename));
        }

    }

	/**
	 * listing data from enum data type
	 *
	 * @param string $table
	 * @param string $field
	 * @return array
	 */
    public function enum_values( $table, $field ){
        $table = $this->prefixTable($table);
        $query = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" );
        $dataresult = $query->result_array();

		$return = array();
		if( count($dataresult[0]) >0 ){
			$type = $dataresult[0]['Type'];
		    preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
		    $enum = explode("','", $matches[1]);
		    $return = $enum;
		}

		return $return;
	}

}
