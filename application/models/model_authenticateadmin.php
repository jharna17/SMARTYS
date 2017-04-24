<?php

class Model_authenticateadmin extends CI_Model{
    
    public function _construct(){
        parent::__construct();
        
    }
    
    public function authpass($password) {
        $sql1="select * from admin where password='".$password."'";
        $query=  $this->db->query($sql1);
        if ($query->num_rows() == 1) {
            return $query;
        } else {
            return FALSE;
        }
    }
    
    public function authemail(){
        
    }
    
    public function changepass() {
        
    }
    
    public function changeemail() {
        
    }
}