<?php

class Warranty_model extends CI_Model
{
   
        function get_products()
        {      
    //        SELECT `a`.*, DATE_ADD(a.warranty_start_date, INTERVAL a.warranty_duration MONTH) as warranty_expiry_date, case when NOW() > DATE_ADD(a.warranty_start_date, INTERVAL a.warranty_duration MONTH) then "E" when DATE_ADD(NOW(), INTERVAL 30 DAY) > DATE_ADD(a.warranty_start_date, INTERVAL a.warranty_duration MONTH) then "EX" ELSE "A" END AS status
    //FROM (`products` a)
    //WHERE `userid` =  82
    //AND `is_deleted` =  '1'
    //ORDER BY `a`.`product_id` desc
            $userid =$this->session->userdata('userid');   
            $this->db->select('a.*');
            $this->db->select('DATE_ADD(a.warranty_start_date , INTERVAL a.warranty_duration MONTH) as warranty_expiry_date',false);      
            $this->db->select('case when NOW() > DATE_ADD(a.warranty_start_date, INTERVAL a.warranty_duration MONTH) then "E"  when DATE_ADD(NOW(),INTERVAL 30 DAY) > DATE_ADD(a.warranty_start_date, INTERVAL a.warranty_duration MONTH) then "EX" ELSE "A" END AS status',false);      
            $this->db->from('products a');
            $this->db->where('userid',$userid);
            $this->db->where('is_deleted','1');
            $this->db->order_by('a.product_id','desc');
            $query=$this->db->get();                                 
            $warranty=$query->result_array();
            return $warranty;        
        }

    
//    function fetchproducts()
//    {
//        $userid=$this->session->userdata('userid');        
//        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.warranty_card,p.purchase_invoice,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
//        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry',false);
//        $this->db->from('users as u');
//        $this->db->join('products AS p', 'p.userid = u.userid');      
//        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
//        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
//        $this->db->where('is_deleted','1');
//        $query = $this->db->where('p.userid', $userid);          
//        $query = $this->db->get();  
//        
//        if($query->num_rows > 0)
//	{
//	     $array = $query->result_array();
////		foreach($array as $i => $row)
////              {
//        //		$this->db->select('max(ex.extended_id) as extended_id');
//        //		$this->db->from('extended_warranty AS ex');
//        //		$query = $this->db->where('ex.userid', $userid);
//        //		$query = $this->db->where('ex.product_id', $row['product_id']);
//        //		$query = $this->db->get();		
//        //		
//        //		$extended_arr = $query->result_array();
//        //		if($extended_arr[0]['extended_id'] != "")
//        //			$array[$i]['extended_id'] = $extended_arr[0]['extended_id'];
//        //		else
//        //			$array[$i]['extended_id'] = 0;
//        //		
//        //		$this->db->select('max(ad.amc_id) as amc_id');
//        //		$this->db->from('amc_details AS ad');
//        //		$query = $this->db->where('ad.userid', $userid);
//        //		$query = $this->db->where('ad.product_id', $row['product_id']);
//        //		$query = $this->db->get();
//        //		$extended_arr = $query->result_array();
//        //		if($extended_arr[0]['amc_id'] != "")
//        //			$array[$i]['amc_id'] = $extended_arr[0]['amc_id'];
//        //		else
//        //			$array[$i]['amc_id'] = 0;
////               }         
//	  return $array;
//	}else
//	{
//	  return "E";
//	}
//      
//    }
    
    function fetchwarrantyexpired()
    {
        $userid=$this->session->userdata('userid');        
        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.warranty_card,p.purchase_invoice,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry',false);
        $this->db->from('users as u');
        $this->db->join('products AS p', 'p.userid = u.userid');      
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
        $this->db->where('p.is_deleted','1');
        $query = $this->db->where('p.userid', $userid); 
        $query = $this->db->having('warranty_expiry < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null , false);            
        $query = $this->db->get();
        if($query->num_rows > 0)
        {
            $array = $query->result_array();            
            return $array;
        }
        else
        { return 'E'; }
       
    }
      function fetchwarrantyexpiring()
    {
        $userid=$this->session->userdata('userid');        
        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.warranty_card,p.purchase_invoice,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry',false);
        $this->db->from('users as u');
        $this->db->join('products AS p', 'p.userid = u.userid');      
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
        $this->db->where('p.is_deleted','1');
        $query = $this->db->where('p.userid', $userid); 
        $query = $this->db->having('warranty_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 31 DAY)', null , false);                    
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
    
      function fetchwarrantyactive()
    {
        $userid=$this->session->userdata('userid');        
        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.warranty_card,p.purchase_invoice,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry',false);
        $this->db->from('users as u');
        $this->db->join('products AS p', 'p.userid = u.userid');      
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
        $this->db->where('p.is_deleted','1');
        $query = $this->db->where('p.userid', $userid); 
        $query = $this->db->having('warranty_expiry > DATE_ADD(CURDATE(), INTERVAL 30 DAY)', null , false);                    
        $query = $this->db->get(); 
         if($query->num_rows > 0)
        {
            $array = $query->result_array();
            return $array;
        }
        else
        { return 'E'; }
    }
    function fetchproductdetails()
    {
        $pid= $this->input->post('pid');
        $userid=$this->session->userdata('userid');  
        $array=array();
        $this->db->select('p.*,no.desc');
        $this->db->from('products as p ');
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->where('p.is_deleted','1');
        $query=$this->db->where('p.product_id',$pid);
        $query=$this->db->get();
        if($query->num_rows > 0)
        {
            $array['product'] =$query->row_array();
        }
        else {
            $array['product'] ='';
        }
        $userid = $this->session->userdata('userid');
        $where="s.user_id IN (".$userid.")";
        $this->db->select('s.*,GROUP_CONCAT(DISTINCT dm.image) as images,GROUP_CONCAT(DISTINCT dm.id) as imgids,GROUP_CONCAT(DISTINCT sd.id) as dateids,GROUP_CONCAT(DISTINCT sd.service_date) as sdates');
        $this->db->from('services_shedule s');
        $this->db->join('services_dates sd', 's.service_id = sd.service_id','left');
        $this->db->join('document_image dm', 's.service_id = dm.service_id','left');
        $this->db->where('s.is_deleted','1');
        $this->db->where($where);
        $this->db->where('s.product_id',$array['product']['product_id']);
        $this->db->group_by('s.service_id');
        $this->db->order_by('s.service_id','desc');    
        
        $query_ss = $this->db->get();                               
        
        if($query_ss->num_rows > 0)
        {
             $array['services'] = $query_ss->row_array();
        }
        else {
            $array['services'] ='';
        }                        
                       
               
        $this->db->select('a.*,no.amc_desc as notedesc,c.cat_name');
        $this->db->from('amc_details as a ');
        $this->db->join('amc_notes AS no', 'no.amc_id = a.amc_id');
        $this->db->join('categories AS c', 'c.cat_id = a.catid');
        $this->db->where('a.is_deleted','1');
        $query_amc = $this->db->where('a.userid', $userid);
        $query_amc = $this->db->where('a.product_id',$array['product']['product_id']);
        $query_amc = $this->db->get();
      //  echo $this->db->last_query(); exit;
         if($query_amc->num_rows > 0)
        {
            $array['amc'] = $query_amc->row_array();
        }
        else 
            {
            $array['amc'] ='';
        }
        return $array;
             
    }      
    
    function addWarranty()
    {                       
        $userid=$this->session->userdata('userid');
        $now = date("Y-m-d H:i:s");
        $product_name = $this->input->post('product_name');
        $cat_id = $this->input->post('category');
        $user_name = $this->input->post('user_name');
        $provider_name = $this->input->post('provider_name');
        $manufacturer_name = $this->input->post('manufacturer_name');
        $support_phone = $this->input->post('support_phone');
        $support_email = $this->input->post('support_email');
        $seller_name = $this->input->post('seller_name');
        $model_number = $this->input->post('model_number');
        $serial_number = $this->input->post('serial_number');
        $invoice_number = $this->input->post('invoice_number');
        $invoice_date = $this->input->post('invoice_date');
        $reminder_time = $this->input->post('reminder_time');
        $warranty_card = $this->input->post('warranty_card');
        $purchase_invoice = $this->input->post('purchase_invoice');
        $warranty_duration = $this->input->post('warranty_duration');
        $start_date = $this->input->post('warranty_start_date');      
        $notedesc = $this->input->post('notedesc');
	$randno = substr(md5(rand()), 0, 6);
        
         $data = array(
            'product_name' => $product_name,
            'userid' => $userid,
            'catagory' => $cat_id,
            'user_name' => $user_name, 
            'provider_name' => $provider_name, //provider_name
            'manufacturer_name' => $manufacturer_name,
            'support_phone' => $support_phone,
            'support_email' => $support_email,
            'seller_name' => $seller_name,
            'model_number' => $model_number,
            'serial_number' => $serial_number,
            'invoice_number' => $invoice_number,
            'invoice_date' => strftime("%Y-%m-%d", strtotime($invoice_date)),
            'warranty_card' => $warranty_card,
            'purchase_invoice' => $purchase_invoice,
            'warranty_duration' => $warranty_duration,
            'reminder_time' => $reminder_time,
            'warranty_start_date' => strftime("%Y-%m-%d", strtotime($start_date)),
            'created_date' => $now
        );
        $this->db->insert('products', $data);
        $insert_id_pdt = $this->db->insert_id();
//add notes
        $datas = array(
            'desc' => $notedesc,
            'product_id' => $insert_id_pdt,
            'created_date'=>$now
        );
        $this->db->insert('user_notes', $datas);
        $insert_ids = $this->db->insert_id();
//end                
        return $insert_id_pdt;
    }
    
    public function edit_product()
    {
        $userid=$this->session->userdata('userid');
        $product_id = $this->input->post('product_id');
        $this->db->select('p.*,no.desc as notedesc,p.catagory as category');
        $this->db->from('products as p ');
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->where('p.is_deleted','1');
        $query=$this->db->where('p.product_id',$product_id);
        $query=$this->db->get();              
        $array = $query->row_array();     
        return $array;
    }
    
    public function edit_productsave()
    {
         $now = date("Y-m-d H:i:s");
        $product_name = $this->input->post('product_name');
        $product_id = $this->input->post('product_id');
        $catagory = $this->input->post('category');
        $user_name = $this->input->post('user_name');
        $provider_name = $this->input->post('provider_name');
        $manufacturer_name = $this->input->post('manufacturer_name');
        $support_phone = $this->input->post('support_phone');
        $support_email = $this->input->post('support_email');
        $seller_name = $this->input->post('seller_name');
        $model_number = $this->input->post('model_number');
        $serial_number = $this->input->post('serial_number');
        $invoice_number = $this->input->post('invoice_number');
        $invoice_date = $this->input->post('invoice_date');
        $warranty_card = $this->input->post('warranty_card');
        $purchase_invoice = $this->input->post('purchase_invoice');
        $warranty_duration = $this->input->post('warranty_duration');
        $start_date = $this->input->post('warranty_start_date');
        $reminder_time = $this->input->post('reminder_time');
        $userid = $this->input->post('userid');
        $notedesc = $this->input->post('notedesc');
        $clientid = $this->input->post('clientid');
        $randno = substr(md5(rand()), 0, 6);

	//return url for image        
        $this->db->select('product_id,warranty_card,purchase_invoice');
        $this->db->from('products');
        $query = $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        $userss = $query->result_array();
	$warrantyCard = $userss['0']['warranty_card'];
        $purchaseInvoice = $userss['0']['purchase_invoice'];
        
        
        $data = array(
            'product_name' => $product_name,
            'userid' => $userid,
            'catagory' => $catagory,
            'user_name' => $user_name, 
            'provider_name' => $provider_name, //provider_name
            'manufacturer_name' => $manufacturer_name,
            'support_phone' => $support_phone,
            'support_email' => $support_email,
            'seller_name' => $seller_name,
            'model_number' => $model_number,
            'serial_number' => $serial_number,
            'invoice_number' => $invoice_number,
            'invoice_date' => strftime("%Y-%m-%d", strtotime($invoice_date)), 
            'warranty_card' => $warranty_card,
            'purchase_invoice' => $purchase_invoice,
            'warranty_duration' => $warranty_duration,
            'reminder_time' => $reminder_time,
            'warranty_start_date' =>strftime("%Y-%m-%d", strtotime($start_date)),
            'modified_date' => $now
        );
        
          $this->db->where('product_id', $product_id);
          $this->db->update('products', $data);
        //add notes
        $datas = array(
            'desc' => $notedesc,
            'modified_date'=>  $now
        );
          $this->db->where('product_id', $product_id);
          $this->db->update('user_notes', $datas);                  
    }
    public function deleteproduct()
    {
        $userid=$this->session->userdata('userid');
        $ids=$this->input->post('id');          
        $query='UPDATE `products` SET `is_deleted` = 0 WHERE `product_id` IN (' .$ids.') AND `userid` = '.$userid;  
        $query1='UPDATE `services_shedule` SET `is_deleted` = 0 WHERE `product_id` IN (' .$ids.') AND `user_id` = '.$userid;  
        $query2='UPDATE `amc_details` SET `is_deleted` = 0 WHERE `product_id` IN (' .$ids.') AND `userid` = '.$userid;  
        
        if ( ( $this->db->query($query)) && ($this->db->query($query1)) && ($this->db->query($query2)) )
        {
                return "Success!";
        }
        else
        {
                return "Query failed!";
        }                       
    }
    
    public function get_productcatwise()
    {
        $userid =$this->session->userdata('userid');  
        $sql="select p.catagory,c.cat_name from products p , categories c where p.catagory = c.cat_id and c.cat_type = 'w' and p.userid=".$userid." group by p.catagory";        
        $query =  $this->db->query($sql); 
        $array=array();       
        if($query->num_rows > 0)
        {
            $array1 = $query->result_array(); 
            foreach($array1 as $i => $row)
            {                   
                    $this->db->select('a.*');
                    $this->db->select('DATE_ADD(a.warranty_start_date , INTERVAL a.warranty_duration MONTH) as warranty_expiry_date',false);      
                    $this->db->select('case when NOW() > DATE_ADD(a.warranty_start_date, INTERVAL a.warranty_duration MONTH) then "E"  when DATE_ADD(NOW(),INTERVAL 30 DAY) > DATE_ADD(a.warranty_start_date, INTERVAL a.warranty_duration MONTH) then "EX" ELSE "A" END AS status',false);      
                    $this->db->from('products a');
                    $this->db->where('userid',$userid);
                    $this->db->where('a.catagory',$row['catagory']);
                    $this->db->where('is_deleted','1');
                    $this->db->order_by('a.product_id','desc');
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

    /****** import code by mehul ****/
     public function Insert_CSV_File($FileName, $module) {
        $User_data = array(
            'filename' => $FileName,
            'module' => $module
        );
        $this->db->insert('file_upload', $User_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    public function Get_Csv_File($Fileid) {
        $this->db->select('filename');
        $this->db->where('id', $Fileid);
        $this->db->from('file_upload');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function Insert_Waaranty_Data($PostArr, $categoryid) {
        //invoice date
//        if ($PostArr['k'] == '') {
//            $invoice_date = date('Y-m-d H:i:s');
//        } else {
//            $invoice_date = $PostArr['k'];
//        }
//        //warranty start date
//        if ($PostArr['l'] == '') {
//            $warranty_start_date = date('Y-m-d H:i:s');
//        } else {
//            $warranty_start_date = $PostArr['l'];
//        }
        $now = date("Y-m-d H:i:s");
        $notedesc = $PostArr['o'];
        $User_data = array(
            'userid' => 1,
            'catagory' => $categoryid,
            'product_name' => $PostArr['a'],
            'user_name' => $PostArr['b'],
            'provider_name' => $PostArr['c'],
            'manufacturer_name' => $PostArr['d'],
            'support_phone' => $PostArr['e'],
            'support_email' => $PostArr['f'],
            'seller_name' => $PostArr['g'],
            'model_number' => $PostArr['h'],
            'serial_number' => $PostArr['i'],
            'invoice_number' => $PostArr['j'],
            'invoice_date' => $PostArr['k'],
            'warranty_start_date' => $PostArr['l'],
            'warranty_duration' => $PostArr['m'],
            'reminder_time' => $PostArr['n'],
            'created_date' => $now
        );
        $this->db->insert('products', $User_data);
        $insert_id = $this->db->insert_id();
        $expotdata[] = $insert_id;
        //add notes
        $datas = array(
            'desc' => $notedesc,
            'product_id' => $insert_id,
            'created_date' => $now
        );
        $this->db->insert('user_notes', $datas);
        $insert_ids = $this->db->insert_id();
        $expotdata[] = $insert_ids;
        return $expotdata;
    }

    public function csv_insert_warranty($row) {   // code by mehul as on 11315
        $now = date("Y-m-d H:i:s");
        $notedesc = $row['add_note'];
        $data = array(
            'userid' => 1,
            'catagory' => $row['category'],
            'product_name' => $row['product_name'],
            'user_name' => $row['user_name'],
            'provider_name' => $row['provider_name'],
            'manufacturer_name' => $row['manufacturer_name'],
            'support_phone' => $row['support_phone'],
            'support_email' => $row['support_email'],
            'seller_name' => $row['seller_name'],
            'model_number' => $row['model_number'],
            'serial_number' => $row['serial_number'],
            'invoice_number' => $row['invoice_number'],
            'invoice_date' => $row['invoice_date'],
            'warranty_start_date' => $row['warranty_start_date'],
            'warranty_duration' => $row['warranty_duration'],
            'reminder_time' => $row['reminder_time'],
            'created_date' => $now
        );
        $this->db->insert('products', $data);
        $insert_id = $this->db->insert_id();
        $expotdata[] = $insert_id;
        //add notes
        $datas = array(
            'desc' => $notedesc,
            'product_id' => $insert_id,
            'created_date' => $now
        );
        $this->db->insert('user_notes', $datas);
        $insert_ids = $this->db->insert_id();
        $expotdata[] = $insert_ids;
        //end
        return TRUE;
    }
    /********** Import code end *************/
    
     function getsortalldash()
    {
        $data=array();
        $userid=$this->session->userdata('userid');   
        $dt=date('Y-m-d',strtotime('-1 days'));              
        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.warranty_card,p.purchase_invoice,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry',false);
        $this->db->from('users as u');
        $this->db->join('products AS p', 'p.userid = u.userid');      
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
        $this->db->where('p.is_deleted','1');
        $query = $this->db->where('p.userid', $userid); 
        $query = $this->db->having('warranty_expiry > DATE_ADD(CURDATE(), INTERVAL 30 DAY)', null , false);                    
        $query = $this->db->get(); 
         if($query->num_rows > 0)         
        $data['warranty_active']=$query->num_rows;
        
      
        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.warranty_card,p.purchase_invoice,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry',false);
        $this->db->from('users as u');
        $this->db->join('products AS p', 'p.userid = u.userid');      
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
        $this->db->where('p.is_deleted','1');
        $query2 = $this->db->where('p.userid', $userid); 
        $query2 = $this->db->having('warranty_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 31 DAY)', null , false);                    
        $query2 = $this->db->get();      
        $data['warranty_expiring']=$query2->num_rows;
        
        
        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.warranty_card,p.purchase_invoice,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry',false);
        $this->db->from('users as u');
        $this->db->join('products AS p', 'p.userid = u.userid');      
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
        $this->db->where('p.is_deleted','1');
        $query3 = $this->db->where('p.userid', $userid); 
        $query3 = $this->db->having('warranty_expiry < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null , false);            
        $query3 = $this->db->get();        
        $data['warranty_expired']=$query3->num_rows;
        
        return $data;
        
    }
    

}
