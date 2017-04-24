<?php 

class Member extends CI_Controller{
      
    private $data=array("a"=>"a");
    private $allcateg;
    public function __construct() {
        parent::__construct();
        cml();
        $this->load->model('model_fileread','aaa');     
        $this->data=array("a"=>"a");
        $this->indexhelper();
    }
    
    
    
    public function getdata($content) {
        $file=  $this->aaa->articlesfromfile($content);
        $data=file_get_contents($file);
        return $data;
    }
    
    public function indexhelper(){
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
        
        
    }
         
    
    public function index() {
        
        $this->data['home_article']=$this->getdata('home_article');
        $this->load->view('member/view_memberhome', $this->data);
    }


    public function homepage(){
        $this->index();
    }
    
    public function aboutus(){
        
        
        $this->data['aboutus_article']=$this->getdata('aboutus_article');
        
        $this->load->view('member/view_memberaboutus', $this->data);
    }
    
    public function contacts(){
        
        $this->data['contact_info']=$this->getdata('contact_info');
        $this->load->view('member/view_membercontacts', $data);
    }
    
    
    public function signup(){
            $this->load->helper('form');
            $this->load->view('view_signupform');
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
                        $this->load->model('model_signup','aaa');
                        $q=$this->aaa->adduser($username, $fname, $lname, $emailid, $pswd);
                        if($q==TRUE){
                            $sql1="select * from users where username='".$username."'";
                            $result=$this->db->query($sql1);
                            $this->session->set_userdata('userid', $result->row(0)->userid1);
                            $this->session->set_userdata('userfname', $result->row(0)->fname);
                            $this->session->set_userdata('userlname', $result->row(0)->lname);
                            $this->session->set_userdata('username', $result->row(0)->username);
                            $this->session->set_userdata('useremailid', $result->row(0)->emailid);
                            redirect_location('home');
                        }
                        else{
                            $this->session->set_userdata('error', 'some error occured.');
                            $this->load->view('view_userregfail');
                        }
                }
                else
                {
                    $this->signup();
                }
    }
    
    public function userlogout(){
        $this->session->sess_destroy();
        redirect_location('home');
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
        
        $this->load->view("member/view_membercat_home", $this->data);
    }


    public function subcategory($subcategoryname) {
        
        $this->data['subcategoryname']=$subcategoryname;
       
        $subcategorywisearticles=  $this->aaa->subcategoryallarticles($subcategoryname);
        
        $this->data['subart']=$subcategorywisearticles;
        
        $this->load->view("member/view_membersubcat_home", $this->data);
    }
    
    public function suggestarticle() {
        $this->load->helper('form');
        $this->load->view("member/view_sugart", $this->data);
    }
           
    public function do_upload()
        { 

            $this->load->helper('form');
            
            $category=  $this->input->post('category');
            $subcategory= $this->input->post('subcategory');
            $art=  $this->input->post('article');
            if ($category == NULL) {
                $category = 'xxx';
            }
            if($subcategory == NULL){
                $subcategory = 'xxx';
            }
            echo $art."bjc7tuvu";
            if($art=="not here"){
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'jpg|png|docx|doc|pdf';
                $config['max_size']             = 1000000000;
                $config['max_width']            = 1024000000;
                $config['max_height']           = 7680000000;

                $this->load->library('upload', $config);
                $userfile= $_FILES['userfile']['name'];
                $temp = explode(".", $_FILES["userfile"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                if($this->aaa->sugartfile($userfile, $category, $subcategory)==TRUE){
                    if ( ! move_uploaded_file($_FILES["userfile"]["tmp_name"], "./uploads/" . $newfilename))
                    {
                        $this->data['uploaderror'] = array('error' => $this->upload->display_errors());

                        $this->load->view('member/view_sugartfail', $this->data);
                    }
                    else
                    {
                        $this->data['uploaddata'] = array('upload_data' => $this->upload->data());
                        $this->load->view('member/view_uploadsuccess', $this->data);
                    }
                }
                else{
                    $this->load->view('member/view_sugartfail', $this->data);
                }
            }
            else{
                if($this->aaa->sugarttext($art, $category, $subcategory)==TRUE){
                    $this->data['uploaddata']='';
                    $this->load->view('member/view_uploadsuccess', $this->data);
                }
                else {
                    $this->load->view('member/view_sugartfail', $this->data);
                }
            }
        }
}