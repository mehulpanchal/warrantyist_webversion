<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Amc extends CI_Controller
{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('amc_model');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('login');
        }
    }
    
    public function index()
    {
        $this->load->view('amc/amc');                
    }  
     public function get_category() {        
        $this->load->model('category_model');
        $cat = $this->category_model->getCategory('a');
        $this->output->set_content_type('application/json')->set_output(json_encode($cat));
    }
    public function addAmcView()
    {
        $this->load->view('amc/addamc');        
    }
     public function getAmc()
    {         
        $amc=$this->amc_model->get_amc();        
        $this->output->set_content_type('application/json')->set_output(json_encode($amc));
    }
    public function addAmc()
    {
        $p=$this->amc_model->add_amc();        
        $this->output->set_content_type('application/json')->set_output(json_encode($p));        
    }
    public function editAmc()
    {
        $a=$this->amc_model->edit_amc();        
        $this->output->set_content_type('application/json')->set_output(json_encode($a));        
    }
    public function editAmcSave()
    {
        $a=$this->amc_model->edit_amc_save();        
        $this->output->set_content_type('application/json')->set_output(json_encode($a));        
    }
    public function editAmcView()
    {
        $this->load->view('amc/editamc');
    }

    public function amcviewdetails()
    {
        $this->load->view('amc/amcdetails');
    }

    public function deleteamcs()
    {
        $d=$this->amc_model->delete_amcs();
        $this->output->set_content_type('application/json')->set_output(json_encode($d));        
    }
    
    public function bindAmc()
    {
        $b=$this->amc_model->bind_amc();
        $this->output->set_content_type('application/json')->set_output(json_encode($b));                
    }
      public function getamccatwise()
    {        
        $product=$this->amc_model->get_amccatwise();        
        $this->output->set_content_type('application/json')->set_output(json_encode($product));        
    } 
     public function categoryview()
    {                
        $this->load->view('amc/amc_category');        
    }
    public function statusview()
    {                
        $this->load->view('amc/amc_status');        
    }
       public function statussort()
    {
        $data=array();
        $data['expired']=$this->amc_model->fetchamcexpired();
        $data['expiring']=$this->amc_model->fetchamcexpiring();
        $data['active']=$this->amc_model->fetchamcactive();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
     public function sortalldash()
    {        
        $data=$this->amc_model->getsortalldash();      
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    
    
    
}

