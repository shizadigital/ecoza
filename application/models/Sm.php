<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sm extends CI_model{

	private function prefixTbl($table){
		return $this->db->dbprefix($table);
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
        $insert = $this->db->insert( $this->prefixTbl($table), $data);
        if( $insert ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
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
        return $this->db->update( $this->prefixTbl($table), $data ); 
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
        return $this->db->delete( $this->prefixTbl($table));
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
                $dttable[] = $this->prefixTbl( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->prefixTbl($tableName);
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
                $dttable[] = $this->prefixTbl( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->prefixTbl($table);
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
                $dttable[] = $this->prefixTbl( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->prefixTbl($table);
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
    public function getval($fieldToDisplay,$table,$fieldReference=null,$method_data = 'array'){
        $error=false;

        $result_ = '';
        if( $this->countData($table, $fieldReference) > 0 ){
			
			// check field to display
			if( is_array($fieldToDisplay) ){
                foreach ($table as $key => $val) {
                    $dttable[] = $this->prefixTbl( $val );
                }
                $fieldToDisplay = implode(',', $dttable);
            }

            if( is_array($table) ){
                $dttable = array();
                foreach ($table as $key => $val) {
                    $dttable[] = $this->prefixTbl( $val );
                }
                $theTable = implode(',', $dttable);
            } else {
                $theTable = $this->prefixTbl($table);
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
				$dttable[] = $this->prefixTbl( $val );
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
                $dttable[] = $this->prefixTbl( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->prefixTbl($table);
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
                $dttable[] = $this->prefixTbl( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->prefixTbl($table);
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
            return $this->db->truncate($this->prefixTbl($tablename));
        }

    }

	/**
	 * listing data form enum data type
	 *
	 * @param string $table
	 * @param string $field
	 * @return array
	 */
    public function enum_values( $table, $field ){
        $table = $this->prefixTbl($table);
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
