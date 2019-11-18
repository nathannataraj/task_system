<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Model
 *
 * @author Senthil Nathan
 */
class Task_model extends CI_Model {
    
    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    /* 
            @function to insert the data 
            @condition - require (tablename and array values)
    */
    public function insertData($table,$column){
            $this->db->insert($table,$column);
    }

    /* 
            @function to select the data 
            @condition - require (tablename and condition)
    */
    public function selectData($table,$condition,$args){
            if(!empty($condition) && count($condition) > 0){
                    $this->db->where($condition);
            }
            $query = $this->db->select($args)->get($table)->result();
            return $query;
    }
    
    /* 
            @function to select the data 
            @condition - require (tablename and condition)
    */
    public function selectValue($table,$condition,$args,$selectType){
            if(!empty($condition) && count($condition) > 0){
                    $this->db->where($condition);
            }
            if($selectType == 'Max'){
                $query = $this->db->select($args)->limit(2)->order_by('created','desc')->get($table)->result();
            }else{
                $query = $this->db->select($args)->get($table)->result();
            }
            return $query;
    }

    /* 
            @function to update the data 
            @condition - require (tablename, update array and condition)
    */
    public function updateData($table,$udata,$condition){
            if(!empty($condition) && count($condition) > 0){
                    $this->db->where($condition);
            }
            $query = $this->db->update($table,$udata);
    }

    /* 
            @function to delete the data 
            @condition - require (tablename, condition)
    */
    public function deleteData($table,$condition){
            if(!empty($condition) && count($condition) > 0){
                    $this->db->where($condition);
            }
            $query = $this->db->delete($table);
    }
    
}
