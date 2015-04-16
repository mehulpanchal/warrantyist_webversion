<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Amc_model extends CI_Model
{
    
  
    function get_amc()
    {      
//        SELECT `a`.*, DATE_ADD(a.amc_start_date, INTERVAL a.warranty_duration MONTH) as warranty_expiry_date, case when NOW() > DATE_ADD(a.amc_start_date, INTERVAL a.warranty_duration MONTH) then "E" when DATE_ADD(NOW(), INTERVAL 30 DAY) > DATE_ADD(a.amc_start_date, INTERVAL a.warranty_duration MONTH) then "EX" ELSE "A" END AS status
//FROM (`products` a)
//WHERE `userid` =  82
//AND `is_deleted` =  '1'
//ORDER BY `a`.`product_id` desc
        $userid =$this->session->userdata('userid');   
        $this->db->select('a.*');
        $this->db->select('DATE_ADD(a.amc_start_date , INTERVAL a.duration MONTH) as amc_expiry_date',false);      
        $this->db->select('case when NOW() > DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) then "E"  when DATE_ADD(NOW(),INTERVAL 30 DAY) > DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) then "EX" ELSE "A" END AS status',false);      
        $this->db->from('amc_details a');
        $this->db->where('a.userid',$userid);
        $this->db->where('a.is_deleted','1');
        $this->db->order_by('a.amc_id','desc');
        $query=$this->db->get();                     
        $amcs=$query->result_array();
        return $amcs;        
    }
    function add_amc()
    {
        $userid=$this->session->userdata('userid');
        $now = date("Y-m-d H:i:s");
        $providername = $this->input->post('amc_provider_name');
        $providerphone = $this->input->post('amc_provider_phone');
        $provideremail = $this->input->post('amc_provider_email');
        $provideraddres = $this->input->post('amc_provider_address');
        $start_from = $this->input->post('amc_start_date');
        $duration = $this->input->post('duration');
        $product_name = $this->input->post('product_name');
        $catid = $this->input->post('catid');
        $reminder = $this->input->post('reminder');
        $product_id = $this->input->post('product_id');
        $notedesc = $this->input->post('notedesc');        
	//end
        $data = array(
            'product_id' => $product_id,
            'amc_provider_name' => $providername,
            'amc_provider_phone' => $providerphone,
            'amc_provider_email' => $provideremail,
            'amc_provider_address' => $provideraddres,
            'amc_start_date' => strftime("%Y-%m-%d", strtotime($start_from)),
            'duration' => $duration,
            'catid' =>$catid,
            'product_name' => $product_name,
            'reminder' => $reminder,
            'userid' => $userid,
            'created_date' => $now
        );
        $this->db->insert('amc_details', $data);
        $insert_id = $this->db->insert_id();
        //add amc notedesc
        $datas = array(
            'amc_desc' => $notedesc,
            'amc_id' => $insert_id,
            'created_date' => $now
        );
        $this->db->insert('amc_notes', $datas);
        $insertid = $this->db->insert_id();
        //return $insertid;        
    }
    public function edit_amc()
    {
        $userid=$this->session->userdata('userid');
        $amc_id = $this->input->post('amc_id');
        $this->db->select('a.*,no.amc_desc as notedesc,c.cat_name');
        $this->db->from('amc_details as a ');
        $this->db->join('amc_notes AS no', 'no.amc_id = a.amc_id');
        $this->db->join('categories AS c', 'c.cat_id = a.catid');
        $this->db->where('a.is_deleted','1');
        $query=$this->db->where('a.amc_id',$amc_id);
        $query=$this->db->get();                      
        $array = $query->row_array();       
        return $array;
    }
    public function edit_amc_save()
    {
        //$now = date("Y-m-d H:i:s");
        $userid=$this->session->userdata('userid');
        $amc_id=$this->input->post('amc_id');
        $providername = $this->input->post('amc_provider_name');
        $providerphone = $this->input->post('amc_provider_phone');
        $provideremail = $this->input->post('amc_provider_email');
        $provideraddres = $this->input->post('amc_provider_address');
        $start_from = $this->input->post('amc_start_date');
        $duration = $this->input->post('duration');
        $product_name = $this->input->post('product_name');
        $catid = $this->input->post('catid');
        $reminder = $this->input->post('reminder');
        //$product_id = $this->input->post('product_id');
        $notedesc = $this->input->post('notedesc');        
        $data = array(
           // 'product_id' => $product_id,
            'amc_provider_name' => $providername,
            'amc_provider_phone' => $providerphone,
            'amc_provider_email' => $provideremail,
            'amc_provider_address' => $provideraddres,
            'amc_start_date' => strftime("%Y-%m-%d", strtotime($start_from)),
            'duration' => $duration,
            'catid' =>$catid,
            'product_name' => $product_name,
            'reminder' => $reminder,
            'userid' => $userid,
            //'modified_date' => $now
        );
          $this->db->where('amc_id', $amc_id);
          $this->db->where('userid', $userid);
          $this->db->update('amc_details', $data);	
         
          $datas = array(
            'amc_desc' => $notedesc
            //'created_date' => $now
            );
          $this->db->where('amc_id', $amc_id);
          $this->db->update('amc_notes', $datas);
    }
    public function delete_amcs()
    {
        $userid=$this->session->userdata('userid');
        $ids=$this->input->post('id');          
        $query='UPDATE `amc_details` SET `is_deleted` = 0 WHERE `amc_id` IN (' .$ids.') AND `userid` = '.$userid;       
        if ( $this->db->query($query))
        {
                return "Success!";
        }
        else
        {
                return "Query failed!";
        }
    }
    public function bind_amc()
    {
        $userid=$this->session->userdata('userid');
        $wrty_id=$this->input->post('wrty_id');
        $this->db->select('p.catagory as catid, p.product_name, p.product_id,c.cat_name');       
        $this->db->from('products p');
        $this->db->join('categories c','c.cat_id= p.catagory');
        $this->db->where('product_id',$wrty_id);
        $this->db->where('userid',$userid);
        $query=$this->db->get();  
        $res=$query->row_array();
        return $res;        
    }
     public function get_amccatwise()
    {
        $userid =$this->session->userdata('userid');  
        $sql="select a.catid,c.cat_name from amc_details a , categories c where a.catid = c.cat_id and c.cat_type = 'w' and a.userid=".$userid." group by a.catid";        
        $query =  $this->db->query($sql); 
        $array=array();       
        if($query->num_rows > 0)
        {
            $array1 = $query->result_array(); 
            foreach($array1 as $i => $row)
            {                   
                $this->db->select('a.*');
                $this->db->select('DATE_ADD(a.amc_start_date , INTERVAL a.duration MONTH) as amc_expiry_date',false);      
                $this->db->select('case when NOW() > DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) then "E"  when DATE_ADD(NOW(),INTERVAL 30 DAY) > DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) then "EX" ELSE "A" END AS status',false);      
                $this->db->from('amc_details a');
                $this->db->where('a.userid',$userid);
                $this->db->where('a.catid',$row['catid']);
                $this->db->where('a.is_deleted','1');                           
                $this->db->order_by('a.amc_id','desc');
                $query=$this->db->get();                   
                $warranty=$query->result_array();                                       
                foreach ($warranty as $key => $value) {
                      $array[$row['cat_name']][$key] = $value;
                  }  
            }                   
            return $array;
        }
        else
        { return 'E'; }
    }
    
       function fetchamcexpired()
    {
        $userid=$this->session->userdata('userid');        
        $this->db->select('u.userid,a.amc_id,a.product_id,a.catid,a.amc_provider_name,cat.cat_name,a.product_name,a.amc_provider_phone,a.amc_provider_email,a.reminder,a.duration,a.amc_start_date,no.amc_desc');
        $this->db->select('DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) as amc_expiry',false);
        $this->db->from('users as u');
        $this->db->join('amc_details AS a', 'a.userid = u.userid');      
        $this->db->join('amc_notes AS no', 'no.amc_id = a.amc_id');
        $this->db->join('categories AS cat', 'cat.cat_id = a.catid');
        $this->db->where('a.is_deleted','1');
        $query = $this->db->where('a.userid', $userid); 
        $query = $this->db->having('amc_expiry < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null , false);            
        $query = $this->db->get();      
        if($query->num_rows > 0)
        {
            $array = $query->result_array();            
            return $array;
        }
        else
        { return 'E'; }
       
    }
      function fetchamcexpiring()
    {
        $userid=$this->session->userdata('userid');        
        $this->db->select('u.userid,a.amc_id,a.product_id,a.catid,a.amc_provider_name,cat.cat_name,a.product_name,a.amc_provider_phone,a.amc_provider_email,a.reminder,a.duration,a.amc_start_date,no.amc_desc');
        $this->db->select('DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) as amc_expiry',false);
        $this->db->from('users as u');
        $this->db->join('amc_details AS a', 'a.userid = u.userid');      
        $this->db->join('amc_notes AS no', 'no.amc_id = a.amc_id');
        $this->db->join('categories AS cat', 'cat.cat_id = a.catid');
        $this->db->where('a.is_deleted','1');
        $query = $this->db->where('a.userid', $userid); 
        $query = $this->db->having('amc_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 31 DAY)', null , false);                    
        $query = $this->db->get(); 
//        echo $this->db->last_query();
//        exit;
         if($query->num_rows > 0)
        {
            $array = $query->result_array();
            return $array;
        }
        else
        { return 'E'; }
    }
    
      function fetchamcactive()
    {
        $userid=$this->session->userdata('userid');        
        $this->db->select('u.userid,a.amc_id,a.product_id,a.catid,a.amc_provider_name,cat.cat_name,a.product_name,a.amc_provider_phone,a.amc_provider_email,a.reminder,a.duration,a.amc_start_date,no.amc_desc');
        $this->db->select('DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) as amc_expiry',false);
        $this->db->from('users as u');
        $this->db->join('amc_details AS a', 'a.userid = u.userid');      
        $this->db->join('amc_notes AS no', 'no.amc_id = a.amc_id');
        $this->db->join('categories AS cat', 'cat.cat_id = a.catid');
        $this->db->where('a.is_deleted','1');
        $query = $this->db->where('a.userid', $userid); 
        $query = $this->db->having('amc_expiry > DATE_ADD(CURDATE(), INTERVAL 30 DAY)', null , false);                    
        $query = $this->db->get(); 
         if($query->num_rows > 0)
        {
            $array = $query->result_array();
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
        $this->db->select('u.userid,a.amc_id,a.product_id,a.catid,a.amc_provider_name,cat.cat_name,a.product_name,a.amc_provider_phone,a.amc_provider_email,a.reminder,a.duration,a.amc_start_date,no.amc_desc');
        $this->db->select('DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) as amc_expiry',false);
        $this->db->from('users as u');
        $this->db->join('amc_details AS a', 'a.userid = u.userid');      
        $this->db->join('amc_notes AS no', 'no.amc_id = a.amc_id');
        $this->db->join('categories AS cat', 'cat.cat_id = a.catid');
        $this->db->where('a.is_deleted','1');
        $query = $this->db->where('a.userid', $userid); 
        $query = $this->db->having('amc_expiry > DATE_ADD(CURDATE(), INTERVAL 30 DAY)', null , false);                    
        $query = $this->db->get();       
        $data['amc_active']=$query->num_rows;
        
      
        $this->db->select('u.userid,a.amc_id,a.product_id,a.catid,a.amc_provider_name,cat.cat_name,a.product_name,a.amc_provider_phone,a.amc_provider_email,a.reminder,a.duration,a.amc_start_date,no.amc_desc');
        $this->db->select('DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) as amc_expiry',false);
        $this->db->from('users as u');
        $this->db->join('amc_details AS a', 'a.userid = u.userid');      
        $this->db->join('amc_notes AS no', 'no.amc_id = a.amc_id');
        $this->db->join('categories AS cat', 'cat.cat_id = a.catid');
        $this->db->where('a.is_deleted','1');
        $query2 = $this->db->where('a.userid', $userid); 
        $query2 = $this->db->having('amc_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 31 DAY)', null , false);                    
        $query2 = $this->db->get();      
        $data['amc_expiring']=$query2->num_rows;
        
        
        $this->db->select('u.userid,a.amc_id,a.product_id,a.catid,a.amc_provider_name,cat.cat_name,a.product_name,a.amc_provider_phone,a.amc_provider_email,a.reminder,a.duration,a.amc_start_date,no.amc_desc');
        $this->db->select('DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) as amc_expiry',false);
        $this->db->from('users as u');
        $this->db->join('amc_details AS a', 'a.userid = u.userid');      
        $this->db->join('amc_notes AS no', 'no.amc_id = a.amc_id');
        $this->db->join('categories AS cat', 'cat.cat_id = a.catid');
        $this->db->where('a.is_deleted','1');
        $query3 = $this->db->where('a.userid', $userid); 
        $query3 = $this->db->having('amc_expiry < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null , false);            
        $query3 = $this->db->get();         
        $data['amc_expired']=$query3->num_rows;
        
        return $data;
        
    }       
    
}