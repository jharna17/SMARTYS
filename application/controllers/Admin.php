<?php 

class Admin extends CI_Controller{
      
    private $data=array("a"=>"a");
    private $allcateg;
    public function __construct() {
        parent::__construct();
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
        $this->load->view('admin/view_adminhome', $this->data);
    }


    public function homepage(){
        $this->index();
    }
    
    public function aboutus(){
        
        
        $this->data['aboutus_article']=$this->getdata('aboutus_article');
        
        $this->load->view('admin/view_adminaboutus', $this->data);
    }
    
    public function contacts(){
        
        $this->data['contact_info']=$this->getdata('contact_info');
        $this->load->view('admin/view_admincontacts', $this->data);
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
        
        $this->load->view("admin/view_admincat_home", $this->data);
    }


    public function subcategory($subcategoryname) {
        
        $this->data['subcategoryname']=$subcategoryname;
       
        $subcategorywisearticles=  $this->aaa->subcategoryallarticles($subcategoryname);
        
        $this->data['subart']=$subcategorywisearticles;
        
        $this->load->view("admin/view_adminsubcat_home", $this->data);
    }
        
    public function signout() {
        $this->session->sess_destroy();
        redirect_location('home');
    }
    
    public function adminfunctions(){
        $this->load->view("admin/view_adminfunc");
    }
    
    public function viewallusers() {
        //echo "dfvifhwj";
        $sql1="select userid1,fname,lname,username,emailid,status from users";
        $result=  $this->db->query($sql1);
        $display_string = "<table>";
        $display_string .= "<tr>";
        $display_string .= "<th>userid1</th>";
        $display_string .= "<th>Fname</th>";
        $display_string .= "<th>Lname</th>";
        $display_string .= "<th>Username</th>";
        $display_string .= "<th>Emailid</th>";
        $display_string .= "<th>Status</th>";
        $display_string .= "</tr>";
        //echo "sfwqhj4";
        // Insert a new row in the table for each person returned
        foreach ($result->result() as $row) {
            $display_string .= "<tr>";
            $display_string .= "<td>".$row->userid1."</td>";
            $display_string .= "<td>".$row->fname."</td>";
            $display_string .= "<td>".$row->lname."</td>";
            $display_string .= "<td>".$row->username."</td>";
            $display_string .= "<td>".$row->emailid."</td>";
            $display_string .= "<td>".$row->status."</td>";
            $display_string .= "</tr>";
        }
        $display_string .= "<br>";
        $display_string .= "</table>";

        echo $display_string;
    }
    
    public function viewallauthors() {
        //echo "dfvifhwj";
        $sql1="select authorid1,fname,lname,status from authors";
        $result=  $this->db->query($sql1);
        $display_string = "<table>";
        $display_string .= "<tr>";
        $display_string .= "<th>authorid1</th>";
        $display_string .= "<th>Fname</th>";
        $display_string .= "<th>Lname</th>";
        $display_string .= "<th>Status</th>";
        $display_string .= "<th></th>";
        $display_string .= "<th></th>";
        $display_string .= "</tr>";
        //echo "sfwqhj4";
        // Insert a new row in the table for each person returned
        foreach ($result->result() as $row) {
            $display_string .= "<tr>";
            $display_string .= "<td>".$row->authorid1."</td>";
            $display_string .= "<td>".$row->fname."</td>";
            $display_string .= "<td>".$row->lname."</td>";
            $display_string .= "<td>".$row->status."</td>";
            $display_string .= "<td>"."<button onclick='deactivateaccount()'>"."</buttton>"."</td>";
            $display_string .= "</tr>";
        }
        $display_string .= "<br>";
        $display_string .= "</table>";

        echo $display_string;
    }
    
     public function suggestarticle() {
        $this->load->helper('form');
        $this->load->view("admin/view_adminsugart", $this->data);
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
                
                if($this->aaa->adminsugartfile($userfile, $category, $subcategory)==TRUE){
                    echo 'jbv9dign93';
                    if ( ! move_uploaded_file($_FILES["userfile"]["tmp_name"], "./uploads/" . $newfilename))
                    {
                        $this->data['uploaderror'] = array('error' => $this->upload->display_errors());
                        $this->load->view('admin/view_adminsugartfail', $this->data);
                    }
                    else
                    {
                        $this->data['uploaddata'] = array('upload_data' => $this->upload->data());
                        $this->load->view('admin/view_adminuploadsuccess', $this->data);
                    }
                }
                else{
                    $this->load->view('admin/view_adminsugartfail', $this->data);
                }
            }
            else{
                if($this->aaa->adminsugarttext($art, $category, $subcategory)==TRUE){
                    $this->data['uploaddata']='';
                    $this->load->view('admin/view_adminuploadsuccess', $this->data);
                }
                else {
                    $this->load->view('admin/view_adminsugartfail', $this->data);
                }
            }
        }
}