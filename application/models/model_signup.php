<?php
class Model_signup extends CI_Model{
    
    public function checkusername(){
        
    }
    
    public function checkpassword(){
        
    }
    
    public function checkname(){
        
    }
    
    public function checkemail(){
        
    }
    
    public function adduser($username, $fname, $lname, $emailid, $pswd) {
        $sql1="insert into users(username, fname, lname, pswd, emailid) values('".$username."','".$fname."','".$lname."','".$pswd."','".$emailid."');";
        $q=$this->db->query($sql1);
        $sql3="select userid from users where username='".$username."'";
        $res=$this->db->query($sql3);
        $userid=$res->row(0)->userid;
        $userid1="user".$userid;
        $sql2="update users set userid1='".$userid1."' where userid=".$userid;
        $result=$this->db->query($sql2);
        return $result;
    }
    
    public function validateuser($username){
        $sql1="select * from users where (username='".$username."' or emailid='".$username."');";
        $result=  $this->db->query($sql1);
        return $result;
    }
    
    public function validatepass($username, $password){
        $sql1="select * from users where (username='".$username."' or emailid='".$username."') and pswd='".$password."';";
        $result=  $this->db->query($sql1);
        return $result;
    }
}