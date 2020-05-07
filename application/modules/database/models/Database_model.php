<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database_model extends CI_model{ 

    public function showAllTables(){
        $envdb = $this->db->query("SHOW TABLES");
        $dataresult = $envdb->result_array();
        $rslt = array();

        foreach($dataresult as $r){
            foreach($r as $d){
                $envdb = $this->db->query("SHOW TABLE STATUS WHERE Name = '{$d}'");
                $dataresult = $envdb->result_array()[0];

                $rslt[$d] = $dataresult;
            }
        }

        return $rslt;
    }

    public function getDataAllTables($query){
        $envdb = $this->db->query($query);
        return $envdb->result_array();
    }

}
