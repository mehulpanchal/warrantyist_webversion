<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service extends CI_Controller {

    public function __construct() {
        parent::__construct();
         $this->load->model('service_model');
         if (!$this->session->userdata('is_logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $this->load->view('service/service');
    }
  
     public function get_category() {
        $this->load->model('category_model');
        $cat = $this->category_model->getCategory('s');
        $this->output->set_content_type('application/json')->set_output(json_encode($cat));
    }
    public function getService()
    {         
        $ser=$this->service_model->get_service();        
        $this->output->set_content_type('application/json')->set_output(json_encode($ser));
    }
    public function editService()
    {
        $ser=$this->service_model->get_editservice();        
        $this->output->set_content_type('application/json')->set_output(json_encode($ser));
    }
    public function getserviceviewdetails()
    {
        $ser=$this->service_model->get_serviceviewdetails();           
        $ser['sdates']=explode(',',$ser['sdates']);
        sort($ser['sdates']);
        $ser['simages']=explode(',',$ser['simages']);
        $this->output->set_content_type('application/json')->set_output(json_encode($ser));
    }
    public function serviceviewdetails()
    {
         $this->load->view('service/servicedetails');
    }
    public function editServiceView()
    {
        $this->load->view('service/editService');
    }
    public function editServiceSave()
    {
       $ser=$this->service_model->edit_service_save();        
        $this->output->set_content_type('application/json')->set_output(json_encode($ser));
    }

    public function addServiceView()
    {
        $this->load->view('service/addservice');
    }
    
    public function addService()
    {        
        $ser=$this->service_model->add_service();        
        $this->output->set_content_type('application/json')->set_output(json_encode($ser));
    }
    public function uploadimage()
    {   
        print_r($_FILES);
        exit;
        $tmp=$_FILES['file']['tmp_name'];                      
        $path="C:/Users/Appetals Solutions/Desktop/Warranty images/".$_FILES['file']['name'];
        move_uploaded_file($tmp, $path);               
        $answer = array( 'answer' => 'File transfer completed' );
        $json = json_encode($answer);
        echo $json;  
    }
     public function deleteservices()
    {
        $d=$this->service_model->delete_services();
        $this->output->set_content_type('application/json')->set_output(json_encode($d));        
    }
    
    public function bindService()
    {
        $b=$this->service_model->bind_service();
        $this->output->set_content_type('application/json')->set_output(json_encode($b));
                
    }
     public function getservicecatwise()
    {        
        $product=$this->service_model->get_servicecatwise();        
        $this->output->set_content_type('application/json')->set_output(json_encode($product));        
    } 
     public function categoryview()
    {                
        $this->load->view('service/service_category');        
    }
    public function statusview()
    {                
        $this->load->view('service/service_status');        
    }
       public function statussort()
    {
        $data=array();
        $data['expired']=$this->service_model->fetchserviceexpired();
        $data['expiring']=$this->service_model->fetchserviceexpiring();
        $data['active']=$this->service_model->fetchserviceactive();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
        public function sortalldash()
    {        
        $data=$this->service_model->getsortalldash();      
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    
    
    
    
            

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */