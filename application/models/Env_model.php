<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Env_model extends CI_model{
    // insert data
    public function insert($table, $data){
        return $this->db->insert( $this->db->dbprefix($table), $data);
    }
    
    // update data
    public function update($table, $data, $where){
        $this->db->where( $where );
        return $this->db->update( $this->db->dbprefix($table), $data ); 
    }

    // delete data
    public function delete($table, $where){
        $this->db->where( $where );
        return $this->db->delete( $this->db->dbprefix($table));
    }

    // view data with "where" syntax
    public function view_where($fieldToDisplay='*', $table, $fieldReference){

        if($fieldToDisplay!='*'){ $fieldToDisplay = preg_replace('/\s*/m', "", $fieldToDisplay); }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        $this->db->select( $fieldToDisplay );
        $this->db->where($fieldReference);
        return $this->db->get( $theTable )->result_array();
    }

    // view data with "where and limit" syntax
    public function view_where_limit($fieldToDisplay='*', $table, $fieldReference, $limit, $offset=null){

        if($fieldToDisplay!='*'){ $fieldToDisplay = preg_replace('/\s*/m', "", $fieldToDisplay); }

        $this->db->select( $fieldToDisplay );
        $this->db->where($fieldReference);
        if($offset != null){
            $this->db->limit($limit, $offset);
        } else {
            $this->db->limit($limit);            
        }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        return $this->db->get( $theTable )->result_array();
    }

    // view data with "order and limit" syntax
    public function view_order_limit($fieldToDisplay='*', $table, $order, $ordering, $limit, $offset=null){

        if($fieldToDisplay!='*'){ $fieldToDisplay = preg_replace('/\s*/m', "", $fieldToDisplay); }

        $this->db->select( $fieldToDisplay );
        $this->db->order_by($order,$ordering);

        if($offset != null){
            $this->db->limit($limit, $offset);
        } else {
            $this->db->limit($limit);            
        }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        return $this->db->get( $theTable )->result_array();
    }

    // view data with "where, order and limit" syntax
    public function view_where_order_limit($fieldToDisplay='*', $table, $fieldReference, $order, $ordering, $limit, $offset=null){

        if($fieldToDisplay!='*'){ $fieldToDisplay = preg_replace('/\s*/m', "", $fieldToDisplay); }

        $this->db->select( $fieldToDisplay );
        $this->db->where($fieldReference);
        $this->db->order_by($order,$ordering);

        if($offset != null){
            $this->db->limit($limit, $offset);
        } else {
            $this->db->limit($limit);            
        }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        return $this->db->get( $theTable )->result_array();
    }
    
    // view data with "order" syntax
    public function view_order($fieldToDisplay='*', $table, $order, $ordering){

        if($fieldToDisplay!='*'){ $fieldToDisplay = preg_replace('/\s*/m', "", $fieldToDisplay); }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        $this->db->select( $fieldToDisplay );
        $this->db->from( $theTable );
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }

    // view data with "where and order" syntax
    public function view_where_order($fieldToDisplay='*', $table, $fieldReference, $order, $ordering){

        if($fieldToDisplay!='*'){ $fieldToDisplay = preg_replace('/\s*/m', "", $fieldToDisplay); }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        $this->db->select( $fieldToDisplay );
        $this->db->where($fieldReference);
        $this->db->order_by($order,$ordering);
        $query = $this->db->get( $theTable );
        return $query->result_array();
    }

    // baca ID berikutnya yang akan dibuat, patokan adalah ID pada data terakhir +1
    public function getNextId($idfield,$tablename){
        if( is_array($tablename) ){
            $dttable = array();
            foreach ($tablename as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($tablename);
        }

        $this->db->select_max($idfield, 'latestId');
        $latestId = $this->db->get( $theTable )->row()->latestId;
        $nowId=1;
        if (!empty($latestId)){
            $nowId = $latestId+1;
        }
        return $nowId;
    }

    public function nextSort($table, $sortfieldname, $where=null) {
        $this->db->select_max($sortfieldname, 'maksimalsort');
        if(!empty($where)){
            $this->db->where($where);
        }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        $maksimalsort = $this->db->get( $theTable )->row()->maksimalsort;
        $nextSort = $maksimalsort + 1;
        return $nextSort;
    }


    // hitung total baris data
    public function countdata($table,$whereClause=null){
        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        $this->db->select("count(*) AS total");
        $this->db->from( $theTable );
        if($whereClause!==null){ $this->db->where($whereClause); }
        $query = $this->db->get();
        return $query->row()->total;
    }

    // getval hanya mengambil 1 baris data dari tabel
    public function getval($fieldToDisplay,$table,$fieldReference=null,$method_data = 'array'){
        $error=false;

        $result_ = '';
        if( Self::countdata($table, $fieldReference) > 0 ){

            if($fieldToDisplay!='*'){ $fieldToDisplay = preg_replace('/\s*/m', "", $fieldToDisplay); }

            if( is_array($table) ){
                $dttable = array();
                foreach ($table as $key => $val) {
                    $dttable[] = $this->db->dbprefix( $val );
                }
                $theTable = implode(',', $dttable);
            } else {
                $theTable = $this->db->dbprefix($table);
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
            if($fieldToDisplay!='*'){
                $fields=explode(',',$fieldToDisplay);

                if(count($fields)!=1){
                    foreach($fields as $key){
                        if(strpos($key, ".")){
                            $key = explode(".",$key)[1];
                        }
                        
                        $result[$key] = $data[$key];
                    }
                }
                else{
                    $result = $data[$fieldToDisplay];
                }
            } else {
                foreach($data as $key => $value){
                    $result[$key] = $value;
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
}