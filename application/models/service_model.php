<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Service_model extends CI_Model
{
    function get_service()
    {        
        $userid=$this->session->userdata('userid');   
        $dt=date('Y-m-d',strtotime('-1 days'));
        $this->db->select('ss.service_id,ss.product_name,ss.provider_name,max(sd.service_date) as expiry_date');  
        $this->db->select('case when NOW() > max(sd.service_date) then "E"  when DATE_ADD(NOW(),INTERVAL 30 DAY) > max(sd.service_date) then "EX" ELSE "A" END AS status',false);
        $this->db->from('services_shedule ss');  
        $this->db->join('services_dates sd', 'ss.service_id = sd.service_id','left');
        $this->db->where('is_deleted','1');
        $query = $this->db->where('user_id', $userid);     
        $query = $this->db->order_by('ss.service_id', 'desc');    
        $query = $this->db->group_by('sd.service_id');    
        $query = $this->db->get();              
        if($query->num_rows > 0)
        {
            $array = $query->result_array();    
            foreach ($array as $i=>$key) {                                         
                $this->db->select('service_date');      
                $this->db->from('services_dates');                      
                $query = $this->db->where('service_id', $key['service_id']);                            
                $query = $this->db->get();
                $service_date=$query->result_array();
                foreach ($service_date as $row) {    
                        if($dt <  $row['service_date'])
                        {
                            $array[$i]['next_service_date'] = $row['service_date'];                         
                            break;
                        }                  
                  }                                
            }
            return $array;
        }
        else
        { return 'E'; }
    }
    
    function get_serviceviewdetails()
    {
        $userid=$this->session->userdata('userid');
        $service_id = $this->input->post('service_id');
        $this->db->select('ss.service_id,ss.user_id,ss.category,ss.product_id,ss.product_name,ss.model_no,ss.serial_no,ss.provider_name,ss.provider_address,ss.provider_phon,ss.provider_mail,ss.notes,ss.reminder,GROUP_CONCAT(DISTINCT sd.service_date) as sdates, GROUP_CONCAT(DISTINCT dm.image) as simages');
        $this->db->select('case when NOW() > max(sd.service_date) then "E"  when DATE_ADD(NOW(),INTERVAL 30 DAY) > max(sd.service_date) then "EX" ELSE "A" END AS status',false);
        $this->db->from('services_shedule AS ss');
        $this->db->join('services_dates AS sd','sd.service_id = ss.service_id','left');
        $this->db->join('document_image dm', 'ss.service_id = dm.service_id','left');
        $this->db->where('ss.is_deleted','1');
        $query = $this->db->where('ss.user_id', $userid);     
        $query = $this->db->where('ss.service_id', $service_id);                
        $query = $this->db->get();  
        $array = $query->row_array();
        return $array;                
    }
   
    function add_service()
    {
        $now = date("Y-m-d H:i:s");
        $user_id = $this->session->userdata('userid');
        $product_id = $this->input->post('product_id');
        $category = $this->input->post('catid');
        $product_name = $this->input->post('product_name');
        $model_no = $this->input->post('model_no');
        $serial_no = $this->input->post('serial_no');
        $provider_name = $this->input->post('provider_name');
        $provider_addr = $this->input->post('provider_address');
        $provider_phon = $this->input->post('provider_phon');
        $provider_mail = $this->input->post('provider_mail');
        $notes = $this->input->post('notes');
        $reminder = $this->input->post('reminder');
        $services_dates = $this->input->post('services_dates');
        $s_images = $this->input->post('s_images');
        $data = array(
            'user_id' => $user_id,
            'category' => $category,
            'product_id' => $product_id,
            'product_name' => $product_name,
            'model_no' => $model_no,
            'serial_no' => $serial_no,
            'provider_name' => $provider_name,
            'provider_address' => $provider_addr,
            'provider_phon' => $provider_phon,
            'provider_mail' => $provider_mail,
            'notes' => $notes,
            'reminder' => $reminder,
            'created_date' => $now
        );
        $this->db->insert('services_shedule',$data);
        $insertid = $this->db->insert_id();
        if ($insertid > 0) {
            if ($services_dates != "") {
                $response = $this->adddate_service($insertid,$services_dates);
            } else {
                $response =  '';
            }
            
            if ($s_images != "") {
                $res_img = $this->addimage_service($insertid,$s_images);
            } else {
                $res_img =  '';
            }
            
            
            return 'Done';
        } else {
            return 0;
        }
    }
    function addimage_service($serviceid,$service_images){
                $imgarry = count($service_images);        
		for($i=0;$i < $imgarry;$i++)
		{
		  $data = array('service_id'=>$serviceid,'image'=>$service_images[$i],'module'=>'s');
		  $this->db->insert('document_image', $data);		  	
		}
		return 'Added';
        
    }
    function adddate_service($serviceid,$service_dates)
	{           
            $datanew=array();            
            $service_dates=array_unique($service_dates, SORT_REGULAR);
            $datearry = count($service_dates);
            for($i=0;$i< $datearry;$i++)
            {                 
                  array_push($datanew,strftime("%Y-%m-%d", strtotime($service_dates[$i])));
            }
            sort($datanew);              
            $res = array();
            for($i=0;$i< $datearry;$i++)
            {
		  $data = array('service_id'=>$serviceid,'service_date'=>$datanew[$i]);
		  $this->db->insert('services_dates', $data);		 
            }
            return $res;

	}
    public function get_editservice()
    {
        $userid=$this->session->userdata('userid');
        $service_id = $this->input->post('service_id');
        $this->db->select('s.*,GROUP_CONCAT(DISTINCT si.image) as images,GROUP_CONCAT(DISTINCT si.id) as imgids,GROUP_CONCAT(DISTINCT sd.id) as dateids,GROUP_CONCAT(DISTINCT sd.service_date) as sdates');
        $this->db->from('services_shedule as s ');
        $this->db->join('services_dates AS sd', 'sd.service_id = s.service_id','left');
        $this->db->join('document_image AS si', 'si.service_id = s.service_id','left');
        $this->db->where('s.is_deleted','1');
        $query=$this->db->where('s.service_id',$service_id);        
        $query=$this->db->get();        
        $array = $query->row_array();
        $array['sdates'] = explode(',', $array['sdates']);
        $array['dateids'] = explode(',', $array['dateids']);
        
        $array['com']= array_combine($array['dateids'], $array['sdates']);
        return $array;
    }
    public function edit_service_save()
    {        
        $now = date("Y-m-d H:i:s");
        $user_id = $this->session->userdata('userid');
        $product_id = $this->input->post('product_id');
        $category = $this->input->post('category');
        $product_name = $this->input->post('product_name');
        $model_no = $this->input->post('model_no');
        $serial_no = $this->input->post('serial_no');
        $provider_name = $this->input->post('provider_name');
        $provider_addr = $this->input->post('provider_address');
        $provider_phon = $this->input->post('provider_phon');
        $provider_mail = $this->input->post('provider_mail');
        $notes = $this->input->post('notes');
        $reminder = $this->input->post('reminder');
        $services_dates = $this->input->post('services_dates');
        $s_images = $this->input->post('s_images');
        $service_id = $this->input->post('service_id');
        $data = array(
            'user_id' => $user_id,
            'category' => $category,
            'product_id' => $product_id,
            'product_name' => $product_name,
            'model_no' => $model_no,
            'serial_no' => $serial_no,
            'provider_name' => $provider_name,
            'provider_address' => $provider_addr,
            'provider_phon' => $provider_phon,
            'provider_mail' => $provider_mail,
            'notes' => $notes,
            'reminder' => $reminder,
            'modified_date' => $now
        );           
        $this->db->where('service_id', $service_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('services_shedule', $data);
        $deleted_date_id=array();
        $deleted_date_id = $this->input->post('deletedtid');
	if(!empty($deleted_date_id[0]))
	{
	   $this->deletedate_service(implode(',',$deleted_date_id));
	}
         $deleted_date_id = $this->input->post('deletedtid');
         
	 if ($services_dates != "") {
                $response = $this->adddate_service($service_id,$services_dates);
            } else {
                $response =  '';
            }
        
        if ($s_images != "") {
                $res_img = $this->addimage_service($service_id,$s_images);
        } else {
                $res_img =  '';
            }
    }
   public function deletedate_service($deleted_date_id)
    {
            // delete from tables				
              $query = $this->db->query("DELETE FROM services_dates WHERE id IN ($deleted_date_id)");
              if($this->db->affected_rows()>0) 
               {
                     return true;
               } 
               else 
               {	
                     return false;
               }
    }
     public function delete_services()
    {
        $userid=$this->session->userdata('userid');
        $ids=$this->input->post('id');          
        $query='UPDATE `services_shedule` SET `is_deleted` = 0 WHERE `service_id` IN (' .$ids.') AND `user_id` = '.$userid;   
        //echo $query; exit;
        if ( $this->db->query($query))
        {
                return "Success!";
        }
        else
        {
                return "Query failed!";
        }
    }
    public function bind_service()
    {
        $userid=$this->session->userdata('userid');
        $wrty_id=$this->input->post('wrty_id');
        $this->db->select('p.catagory as catid, p.product_name, p.product_id,c.cat_name,p.model_number as model_no,p.serial_number as serial_no');       
        $this->db->from('products p');
        $this->db->join('categories c','c.cat_id= p.catagory');
        $this->db->where('product_id',$wrty_id);
        $this->db->where('userid',$userid);
        $query=$this->db->get();  
        $res=$query->row_array();
        return $res;        
    }
    
    public function get_servicecatwise()
    {
        $userid =$this->session->userdata('userid');  
        $dt=date('Y-m-d',strtotime('-1 days'));
        $sql="select ss.category,c.cat_name from services_shedule ss , categories c where ss.category = c.cat_id  and ss.user_id=".$userid." group by ss.category";   
        $query =  $this->db->query($sql); 
        $array=array();            
        
        if($query->num_rows > 0)
        {
            $array1 = $query->result_array(); 
            foreach($array1 as $i => $row)
            {                   
                $this->db->select('s.service_id,s.product_name,min(sd.service_date) as start_date,max(sd.service_date) as end_date');                             
                $this->db->select('case when NOW() > max(sd.service_date) then "E"  when DATE_ADD(NOW(),INTERVAL 30 DAY) > max(sd.service_date) then "EX" ELSE "A" END AS status',false);
                $this->db->from('services_shedule AS s');
                $this->db->join('services_dates AS sd','sd.service_id = s.service_id','left');        
                $this->db->where('s.user_id',$userid);
                $this->db->where('s.category',$row['category']);
                $this->db->where('s.is_deleted','1');                           
                $this->db->group_by('sd.service_id');
                $this->db->order_by('s.service_id','desc');
                $query=$this->db->get();                   
                $warranty=$query->result_array();                   
                foreach ($warranty as $key => $value) {
                    $array[$row['cat_name']][$key] = $value;                                                                   
                    $this->db->select('service_date');      
                    $this->db->from('services_dates');                      
                    $query = $this->db->where('service_id', $value['service_id']);                            
                    $query = $this->db->get();
                    $service_date=$query->result_array();
                    foreach ($service_date as $row2) {    
                            if($dt <  $row2['service_date'])
                            {
                                 $array[$row['cat_name']][$key]['next_service_date'] = $row2['service_date'];                         
                                break;
                            }                  
                      } 
                  }   
            }    
             
            return $array;
        }
        else
        { return 'E'; }
    }
    
       function fetchserviceexpired()
    {
        $userid=$this->session->userdata('userid');   
        $dt=date('Y-m-d',strtotime('-1 days'));
        $this->db->select('ss.service_id,ss.product_name,ss.provider_name,max(sd.service_date) as service_expiry');        
        $this->db->from('services_shedule ss');  
        $this->db->join('services_dates sd', 'ss.service_id = sd.service_id','left');
        $this->db->where('is_deleted','1');
        $query = $this->db->where('user_id', $userid);   
        $query = $this->db->having('service_expiry < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null , false);        
        $query = $this->db->order_by('ss.service_id', 'desc');    
        $query = $this->db->group_by('sd.service_id');    
        $query = $this->db->get();         
         if($query->num_rows > 0)
        {
            $array = $query->result_array();          
                foreach ($array as $i=>$key) {                                         
                $this->db->select('service_date');      
                $this->db->from('services_dates');                      
                $query = $this->db->where('service_id', $key['service_id']);                            
                $query = $this->db->get();
                $service_date=$query->result_array();
                foreach ($service_date as $row) {    
                        if($dt <  $row['service_date'])
                        {
                            $array[$i]['next_service_date'] = $row['service_date'];                         
                            break;
                        }                  
                  }                                
            }
            return $array;           
        }
        else
        { return 'E'; }
       
    }
      function fetchserviceexpiring()
    {
        $userid=$this->session->userdata('userid');   
        $dt=date('Y-m-d',strtotime('-1 days'));
        $this->db->select('ss.service_id,ss.product_name,ss.provider_name,max(sd.service_date) as service_expiry');        
        $this->db->from('services_shedule ss');  
        $this->db->join('services_dates sd', 'ss.service_id = sd.service_id','left');
        $this->db->where('is_deleted','1');
        $query = $this->db->where('user_id', $userid);   
        //$query = $this->db->having('service_expiry < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null , false);     
        $query = $this->db->having('service_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 31 DAY)', null , false);             
        $query = $this->db->order_by('ss.service_id', 'desc');    
        $query = $this->db->group_by('sd.service_id');    
        $query = $this->db->get();         
         if($query->num_rows > 0)
        {
             $array = $query->result_array();    
                foreach ($array as $i=>$key) {                                         
                $this->db->select('service_date');      
                $this->db->from('services_dates');                      
                $query = $this->db->where('service_id', $key['service_id']);                            
                $query = $this->db->get();
                $service_date=$query->result_array();
                foreach ($service_date as $row) {    
                        if($dt <  $row['service_date'])
                        {
                            $array[$i]['next_service_date'] = $row['service_date'];                         
                            break;
                        }                  
                  }                                
            }
            return $array;
        }
        else
        { return 'E'; }
       
    }
    
      function fetchserviceactive()
    {
        $userid=$this->session->userdata('userid');   
        $dt=date('Y-m-d',strtotime('-1 days'));
        $this->db->select('ss.service_id,ss.product_name,ss.provider_name,max(sd.service_date) as service_expiry');        
        $this->db->from('services_shedule ss');  
        $this->db->join('services_dates sd', 'ss.service_id = sd.service_id','left');
        $this->db->where('is_deleted','1');
        $query = $this->db->where('user_id', $userid);   
        //$query = $this->db->having('service_expiry < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null , false);     
        $query = $this->db->having('service_expiry > DATE_ADD(CURDATE(), INTERVAL 30 DAY)', null , false);     
        $query = $this->db->order_by('ss.service_id', 'desc');    
        $query = $this->db->group_by('sd.service_id');    
        $query = $this->db->get();         
         if($query->num_rows > 0)
        {
           $array = $query->result_array();    
                foreach ($array as $i=>$key) {                                         
                $this->db->select('service_date');      
                $this->db->from('services_dates');                      
                $query = $this->db->where('service_id', $key['service_id']);                            
                $query = $this->db->get();
                $service_date=$query->result_array();
                foreach ($service_date as $row) {    
                        if($dt <  $row['service_date'])
                        {
                            $array[$i]['next_service_date'] = $row['service_date'];                         
                            break;
                        }                  
                  }                                
            }
            return $array;
        }
        else
        { return 'E'; }
    }
    
    function getsortalldash()
    {
        $data=array();
        $userid=$this->session->userdata('userid');   
        $dt=date('Y-m-d',strtotime('-1 days'));
        $this->db->select('ss.service_id,ss.product_name,ss.provider_name,max(sd.service_date) as service_expiry');        
        $this->db->from('services_shedule ss');  
        $this->db->join('services_dates sd', 'ss.service_id = sd.service_id','left');
        $this->db->where('is_deleted','1');
        $query = $this->db->where('user_id', $userid);   
        //$query = $this->db->having('service_expiry < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null , false);     
        $query = $this->db->having('service_expiry > DATE_ADD(CURDATE(), INTERVAL 30 DAY)', null , false);     
        $query = $this->db->order_by('ss.service_id', 'desc');    
        $query = $this->db->group_by('sd.service_id');    
        $query = $this->db->get();         
        $data['service_active']=$query->num_rows;
        
      

        $this->db->select('ss.service_id,ss.product_name,ss.provider_name,max(sd.service_date) as service_expiry');        
        $this->db->from('services_shedule ss');  
        $this->db->join('services_dates sd', 'ss.service_id = sd.service_id','left');
        $this->db->where('is_deleted','1');
        $query2 = $this->db->where('user_id', $userid);               
        $query2 = $this->db->having('service_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 31 DAY)', null , false);             
        $query2 = $this->db->order_by('ss.service_id', 'desc');    
        $query2 = $this->db->group_by('sd.service_id');    
        $query2 = $this->db->get();         
        $data['service_expiring']=$query2->num_rows;
        
        
        $this->db->select('ss.service_id,ss.product_name,ss.provider_name,max(sd.service_date) as service_expiry');        
        $this->db->from('services_shedule ss');  
        $this->db->join('services_dates sd', 'ss.service_id = sd.service_id','left');
        $this->db->where('is_deleted','1');
        $query3 = $this->db->where('user_id', $userid);   
        $query3= $this->db->having('service_expiry < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null , false);        
        $query3 = $this->db->order_by('ss.service_id', 'desc');    
        $query3 = $this->db->group_by('sd.service_id');    
        $query3 = $this->db->get();         
        $data['service_expired']=$query3->num_rows;
        
        return $data;
        
    }
    
}