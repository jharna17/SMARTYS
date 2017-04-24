<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_fileread extends CI_Model{
    
    
    public function articlesfromfile($content) {
        $db=$this->load->database();
        $sql1="select filename from contentinfiles where content='".$content."'";
        $result=  $this->db->query($sql1);
        return $result->row(0)->filename;
    }
    
    public function totalcat(){
        $db=$this->load->database();
        $sql1="select categoryname from categories where categoryname <> 'xxx'";
        $result= $this->db->query($sql1);
        return $result;
    }
    
    public function allsubcat($catname) {
            $db=$this->load->database();
        $sql1="select categoryid from categories where categoryname='".$catname."'";
        $result= $this->db->query($sql1);
        $catid= $result->row(0)->categoryid;
        $result=null;
        $sql2="select * from subcategories where catid=".$catid;
        $result=  $this->db->query($sql2);
        return $result;        
    }
    
    public function categorylatestarticle($catname) {
        $db=$this->load->database();
        //$catname="category1";
        $sql1="select categoryid from categories where categoryname='".$catname."'";
        $result= $this->db->query($sql1);
        $catid= $result->row(0)->categoryid;
        $sql9="SELECT MAX(datetimeposted) as time, categoryid FROM articles  group by categoryid";
        $result9=  $this->db->query($sql9);
        //echo $result9->num_rows();
        //print_r($result9->row(0));
        //print_r($result9->row(1));
        //print_r($result9->row(4));
        $aqs="";
        $data=array("a"=>"a");
        foreach($result9->result() as $row){
            if ($row->categoryid == $catid) {
                $aqs = $row->time;
                //echo $aqs;
            }
        }
        $sql2= "select * from articles where (categoryid='".$catid."' and datetimeposted='".$aqs."')";
        $result2=  $this->db->query($sql2);
        //echo $result2->num_rows();
        //print_r($result2->row(0));
        if($result2->num_rows()>0){
            $author=$result2->row(0)->authorid;
            $sql3="select fname,lname from authors where authorid=$author";
            $result3=  $this->db->query($sql3);
            $data['author']=$result3->row(0)->fname." ".$result3->row(0)->lname;
            $subcat=$result2->row(0)->subcatid;
            $sql4="select subcatname from subcategories where subcatid=$subcat";
            $result4=  $this->db->query($sql4);
            $data['subcat']=$result4->row(0)->subcatname;
            if ($result2->row(0)->filename == NULL) {
                $data['content'] = $result2->row(0)->article;
            }
            else{
                $data['content']=  file_get_contents($result2->row(0)->filename);
            }
        }
        else{
            $data['author']=" ";
            $data['subcat']=" ";
            $data['content']=" ";
        }
            return $data;
        
    }
    
    public function subcategorywiselatestarticles($subcatname) {
        $db=$this->load->database();
        $data['subcat']=$subcatname;
        $sql1="select subcatid from subcategories where subcatname='".$subcatname."'";
        $result= $this->db->query($sql1);
        $subcat= $result->row(0)->subcatid;
        $sql9="SELECT MAX(datetimeposted) as time, subcatid FROM articles  group by subcatid";
        $result9=  $this->db->query($sql9);
        //echo $result9->num_rows();
        //print_r($result9->row(0));
        //print_r($result9->row(1));
        //print_r($result9->row(4));
        $aqs="";
        $data=array("a"=>"a");
        $data['subcat']=$subcatname;
        foreach($result9->result() as $row){
            if ($row->subcatid == $subcat) {
                $aqs = $row->time;
                //echo $aqs;
            }
        }
        $sql2= "select * from articles where (subcatid='".$subcat."' and datetimeposted='".$aqs."')";
        $result2=  $this->db->query($sql2);
        //echo $result2->num_rows();
        //print_r($result2->row(0));
        if($result2->num_rows()>0){
            $author= $result2->row(0)->authorid;
            $sql3="select fname,lname from authors where authorid=".$author;
            $result3=  $this->db->query($sql3);
            $data['author']=$result3->row(0)->fname." ".$result3->row(0)->lname;
            if ($result2->row(0)->filename == NULL) {
                $data['content'] = $result2->row(0)->article;
            }
            else{
                $data['content']=  file_get_contents($result2->row(0)->filename);
            }
        }
        else{
            $data['author']="x ";
            
            $data['content']=" x";
        }
        print_r($data);
            return $data;
    }
    
    public function subcategoryallarticles($subcatname) {
      $db=$this->load->database();
        $sql1="select subcatid from subcategories where subcatname='".$subcatname."'";
        $result1=  $this->db->query($sql1);
        $subcatid=$result1->row(0)->subcatid;
        $sql2="select * from articles where subcatid=".$subcatid." order by datetimeposted desc";
        $result2=  $this->db->query($sql2);
        print_r($result2);
        return $result2;
    }
    
    public function sugartfile($filename, $category, $subcategory) {
        $db=$this->load->database();
        $temp = explode(".", $filename);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        echo $newfilename;
        
        $sql1="select categoryid from categories where categoryname='".$category."'";
        $result1=  $this->db->query($sql1);
        $sql2="select subcatid from subcategories where subcatname='".$subcategory."'";
        $result2=  $this->db->query($sql2);
        $sql3="insert into suggestedarticles(userid, categoryid, subcategoryid, filenamebytheuser, filename) values(".$this->session->userid
                .", ".$result1->row(0)->categoryid.", ".$result2->row(0)->subcatid.", '".$filename."', '".$newfilename."')";
        $result3=  $this->db->query($sql3);
        return $result3;
    }
    
    public function adminsugartfile($filename, $category, $subcategory) {
        $db=$this->load->database();
        $temp = explode(".", $filename);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        echo $newfilename;
        
        $sql1="select categoryid from categories where categoryname='".$category."'";
        $result1=  $this->db->query($sql1);
        $sql2="select subcatid from subcategories where subcatname='".$subcategory."'";
        $result2=  $this->db->query($sql2);
        $sql3="insert into suggestedarticles(userid, categoryid, subcategoryid, filenamebytheuser, filename) values(" . 9
                .", ".$result1->row(0)->categoryid.", ".$result2->row(0)->subcatid.", '".$filename."', '".$newfilename."')";
        $result3=  $this->db->query($sql3);
        return $result3;
    }
    
    public function adminsugarttext($art, $category, $subcategory) {
        $db=$this->load->database();
        $sql1="select categoryid from categories where categoryname='".$category."'";
        $result1=  $this->db->query($sql1);
        $sql2="select subcatid from subcategories where subcatname='".$subcategory."'";
        $result2=  $this->db->query($sql2);
        $sql3="insert into suggestedarticles(userid, categoryid, subcategoryid, sugart) values(". 9
                .", ".$result1->row(0)->categoryid.", ".$result2->row(0)->subcatid.", '".$art."')";
        $result3=  $this->db->query($sql3);
        return $result3;
    }
    
    
    
    public function sugarttext($art, $category, $subcategory) {
        $db=$this->load->database();
        $sql1="select categoryid from categories where categoryname='".$category."'";
        $result1=  $this->db->query($sql1);
        $sql2="select subcatid from subcategories where subcatname='".$subcategory."'";
        $result2=  $this->db->query($sql2);
        $sql3="insert into suggestedarticles(userid, categoryid, subcategoryid, sugart) values(".$this->session->userid
                .", ".$result1->row(0)->categoryid.", ".$result2->row(0)->subcatid.", '".$art."')";
        $result3=  $this->db->query($sql3);
        return $result3;
    }   
}