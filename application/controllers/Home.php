<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller{
    
    
    private $data=array("a"=>"a");
    private $allcateg;
    public function __construct() {
        //$db=  $this->load->database();
        echo "entering home cons<BR>";
        parent::__construct();
        echo "after parent_cons<BR>";
        $this->load->model('model_fileread','aaa');     
        $this->data=array("a"=>"a");
        $this->indexhelper();
        echo "exiting home cons<BR>";
    } 
    
    public function getdata($content) {
        echo "entering getdata<BR>";
        $file=  $this->aaa->articlesfromfile($content);
        $data=file_get_contents($file);
        echo "exiting getdata<BR>";
        return $data;
    }
    
    public function indexhelper(){
        echo "entering indexhelper()<BR>";
        $x=array("a"=>"a");
        $y=array("a"=>"a");
        $z=array("a"=>"a");
        $allcatresult= $this->aaa->totalcat();
        //print_r($allcatresult->row(0));
        $this->data['allcat']=$allcatresult;
        foreach ($allcatresult->result() as $row){
            $subcatofacat=  $this->aaa->allsubcat($row->categoryname);
            //echo $row->categoryname.'subcat';
             array_push($x, $row->categoryname);
             array_push($y, $subcatofacat);
            //print_r($data[$row->categoryname]->row(0));
                    
            $catwisearticles= $this->aaa->categorylatestarticle($row->categoryname);
            array_push($z, $catwisearticles);
        }
        $this->allcateg=$x;
        $this->data['cat_sub']=array_combine($x, $y);
        $this->data['cat_art']=array_combine($x, $z);
        
        echo "exiting indexhelper<br>";
    }
   
    public function index() {
        echo "entering index()<br>";
        $this->data['home_article']=$this->getdata('home_article');
        $this->load->view('view_home', $this->data);
        echo "exiting index()<br>";
    }


    public function homepage(){
        echo "entering homepage()<br>";
        $this->index();
        echo "exiting homepage()<br>";
    }
    
    public function aboutus(){
        
        echo "entering abtus()<br>";
        $this->data['aboutus_article']=$this->getdata('aboutus_article');
        $this->load->view('view_aboutus', $this->data);
        echo "exiting abtus()<br>"; 
    }
    
    public function contacts(){
        echo "entering contacts<br>";
        $this->data['contact_info']=$this->getdata('contact_info');
        $this->load->view('view_contacts', $this->data);
        echo "exiting cntacts()<br>";
    }
    
    public function adminlogin(){
            echo "entering adminlogin()<br>";
            $this->load->helper('form');
            $this->load->view('view_adminlogin',  $this->data);
            echo "exiting adminlogin() <br>";
    }
    
    public function adminlogincheck() {
            echo "entering adminlogincheck()<br>";
            $this->load->helper('form');    
            $password=$this->input->post('password');
            $this->load->model('model_authenticateadmin','bbb');
            $q=$this->bbb->authpass($password);
            if($q==TRUE){
                
                $sql1="select * from admin where password='".$password."'";
                $query=  $this->db->query($sql1);
                $this->session->set_userdata('adminlogin', TRUE);
                $this->session->set_userdata('adminfname', $query->row(0)->firstname);
                $this->session->set_userdata('adminlname', $query->row(0)->lastname);
                $this->session->set_userdata('adminemail', $query->row(0)->emailid);
                $this->session->set_userdata('error', "no error");
                redirect_location('admin');
            }        
            else{
                $this->session->set_userdata('error',"Invalid Password");
                $this->load->view('view_adminloginfail', $this->data);
            }
            
            echo "exiting adminloginchk()<br>";
    }
    
    public function signup(){
            $this->load->helper('form');
            
            $this->load->view('view_signupform', $this->data);
    }
    
    public function signupaction() {
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
            $this->form_validation->set_rules('emailid', 'Email', 'required|valid_email');
            
            if ($this->form_validation->run() == TRUE)
                {
                        $username=$this->input->post('username');
                        $fname=  $this->input->post('firstname');
                        $lname=  $this->input->post('lastname');
                        $pswd=  $this->input->post('password');
                        $emailid=  $this->input->post('emailid');
                        $this->load->model('model_signup','ccc');
                        $q=$this->ccc->adduser($username, $fname, $lname, $emailid, $pswd);
                        if($q==TRUE){
                            $sql1="select * from users where username='".$username."'";
                            $result=$this->db->query($sql1);
                            $this->session->set_userdata('userid', $result->row(0)->userid);
                            $this->session->set_userdata('userid1', $result->row(0)->userid1);
                            $this->session->set_userdata('userfname', $result->row(0)->fname);
                            $this->session->set_userdata('userlname', $result->row(0)->lname);
                            $this->session->set_userdata('username', $result->row(0)->username);
                            $this->session->set_userdata('useremailid', $result->row(0)->emailid);
                            redirect_location('home');
                        }
                        else{
                            $this->session->set_userdata('error', 'some error occured.');
                            $this->load->view('view_userregfail', $this->data);
                        }
                }
                else
                {
                    $this->signup();
                }
    }
    
    public function userlogin(){
            $this->load->helper('form');
            $this->indexhelper();
            $this->load->view('view_userlogin', $this->data);
    }
    
    public function userlogincheck() {
        $this->load->helper('form');    
        $password=$this->input->post('password');
        $username=$this->input->post('username');
            $this->load->model('model_signup','ddd');
            $q=$this->ddd->validateuser($username);
            if($q->num_rows()==1){
                $result=  $this->ddd->validatepass($username,$password);
                if($result->num_rows()==1){   
                    $this->session->set_userdata('userlogin', TRUE);
                    $this->session->set_userdata('userid', $result->row(0)->userid);
                    $this->session->set_userdata('userid1', $result->row(0)->userid1);
                    $this->session->set_userdata('userfname', $result->row(0)->fname);
                    $this->session->set_userdata('userlname', $result->row(0)->lname);
                    $this->session->set_userdata('username', $result->row(0)->username);
                    $this->session->set_userdata('useremailid', $result->row(0)->emailid);
                    redirect_location('member');
                }
                else{
                    $this->session->set_userdata('error', 'Invalid password!');
                    $this->load->view('view_userloginfail', $this->data);
                }
            }
            else{
                $this->session->set_userdata('error',"Invalid Username else not registered.");
                $this->load->view('view_userloginfail', $this->data);
            }
    }
    
    public function category($categoryname) {
        $x=array('a'=>'a');
        $y=array('a'=>'b');
        $this->data['categoryname']=$categoryname;
        foreach($this->data['cat_sub'][$categoryname]->result() as $row){
            echo $row->subcatname;
            array_push($x, $row->subcatname);
        $subcategorywiselatestarticles=  $this->aaa->subcategorywiselatestarticles($row->subcatname);
        array_push($y, $subcategorywiselatestarticles);
        }
        $this->data['subcatwiseart']=  array_combine($x, $y);
        
        $this->load->view("view_cat_home", $this->data);
    }


    public function subcategory($subcategoryname) {
        
        $this->data['subcategoryname']=$subcategoryname;
       
        $subcategorywisearticles=  $this->aaa->subcategoryallarticles($subcategoryname);
        
        $this->data['subart']=$subcategorywisearticles;
        
        $this->load->view("view_subcat_home", $this->data);
    }
}