<?php

class document_model extends CI_Model
{
   
   
    function fetchDocData()
    {
        $sql = "select d.category,c.cat_name from document d , categories c where  d.category = c.cat_id and c.cat_type = 'd' group by d.category  " ;
        $query =  $this->db->query($sql); 
        $array=array();
        // $userid='1';
        $userid =$this->session->userdata('userid');  
       /*  echo $this->db->last_query();
            exit;*/
        if($query->num_rows > 0)
        {
            $array1 = $query->result_array(); 
            foreach($array1 as $i => $row)
            {
                    $sql = "select d.category,d.doc_name,d.doc_id,d.start_date,d.expiry_date,c.cat_id,c.cat_name,c.cat_type , case when now() > d.expiry_date then 'E'  when DATE_ADD(now(),INTERVAL 30 DAY) >  d.expiry_date then 'EX' else 'A' end as status 
                    from document d , categories c where d.user_id = '$userid' and d.category = c.cat_id and d.is_deleted = 1 and c.cat_id = ? " ;
                    $query =  $this->db->query($sql, array($row['category']));                     
                    $extended_arr = $query->result_array();   
                    
                      foreach ($extended_arr as $key => $value) {
                            $array[$row['cat_name']][$key] = $value;
                        }  
            }       
            
            return $array;
        }
        else
        { return 'E'; }

        /* $array = $query->result_array();
     foreach($array as $i => $row)
             {
             $this->db->select('max(ex.extended_id) as extended_id');
             $this->db->from('extended_warranty AS ex');
             $query = $this->db->where('ex.userid', $userid);
             $query = $this->db->where('ex.product_id', $row['product_id']);
             $query = $this->db->get();      
             
             $extended_arr = $query->result_array();
             if($extended_arr[0]['extended_id'] != "")
                 $array[$i]['extended_id'] = $extended_arr[0]['extended_id'];
             else
                 $array[$i]['extended_id'] = 0;
             
             $this->db->select('max(ad.amc_id) as amc_id');
             $this->db->from('amc_details AS ad');
             $query = $this->db->where('ad.userid', $userid);
             $query = $this->db->where('ad.product_id', $row['product_id']);
             $query = $this->db->get();
             $extended_arr = $query->result_array();
             if($extended_arr[0]['amc_id'] != "")
                 $array[$i]['amc_id'] = $extended_arr[0]['amc_id'];
             else
                 $array[$i]['amc_id'] = 0;
              }  */
       
    }
    public function edit_doc()
    {
        //$userid='1';
        $userid =$this->session->userdata('userid');  
        $doc_id = $this->input->post('doc_id');
        $sql = "select * from document where user_id = '$userid' and doc_id = ? " ;
        $query =  $this->db->query($sql, $doc_id);       
        $array = $query->result_array();            
        return $array;
    }

    public function editproductview()
    {
        //$userid='1';
        $userid =$this->session->userdata('userid');  
        $doc_id = $this->input->post('id');
        $sql = "select * from document where user_id = '$userid' and doc_id = ? " ;
        $query =  $this->db->query($sql, $doc_id);       
     /* echo $this->db->last_query();
        exit;*/
        $array = $query->row_array();            
        

        return $array;
    }

    public function edit_docsave()
    {
        $now = date("Y-m-d H:i:s");
        //$userid='1';
        $userid =$this->session->userdata('userid');  
        $category =$this->input->post('category');
        $doc_id = $this->input->post('doc_id');
        $doc_name = $this->input->post('doc_name');
        $doc_number = $this->input->post('doc_number');
        $start_date = $this->input->post('start_date');
        $expiry_date = $this->input->post('expiry_date');
        $upload_doc = $this->input->post('upload_doc');
        $notes = $this->input->post('notes');

      //return url
        $data = array(
           'category' => $category,
            'user_id' => $userid,
            'doc_name' => $doc_name,
            'doc_number' => $doc_number, 
            'start_date' => strftime("%Y-%m-%d", strtotime($start_date)),
            'expiry_date' => strftime("%Y-%m-%d", strtotime($expiry_date)),
            'notes' => $notes,
            'modified_date' => $now
        );
        
          $this->db->where('doc_id', $doc_id);
          $this->db->update('document', $data);
        //add notes
       /* $datas = array(
            'desc' => $notedesc,
            'modified_date'=>  $now
        );
          $this->db->where('product_id', $product_id);
          $this->db->update('user_notes', $datas);  */                
    }

    function addDocuments()
    {                       
        //$userid=1;
        $userid =$this->session->userdata('userid');  
        $now = date("Y-m-d H:i:s");
        $category =$this->input->post('category');
        $doc_name = $this->input->post('doc_name');
        $doc_number = $this->input->post('doc_number');
        $start_date = $this->input->post('start_date');
        $expiry_date = $this->input->post('expiry_date');
        $upload_doc = $this->input->post('upload_doc');
        $notes = $this->input->post('notes');
        //$reminder =$this->input->post('reminder');

        //$randno = substr(md5(rand()), 0, 6);
        
         $data = array(
            'category' => $category,
            'user_id' => $userid,
            'doc_name' => $doc_name,
            'doc_number' => $doc_number, 
            'start_date' => strftime("%Y-%m-%d", strtotime($start_date)),
            'expiry_date' => strftime("%Y-%m-%d", strtotime($expiry_date)),
            'notes' => $notes,
            'created_date' => $now
        );
        $this->db->insert('document', $data);
        $insert_id = $this->db->insert_id();
//add notes
      /*  $datas = array(
            'notes' => $notes,
            'product_id' => $insert_id,
            'created_date'=>now()
        );
        $this->db->insert('user_notes', $datas);
        $insert_ids = $this->db->insert_id();*/
//end                
        return 'Done';
    }

    function get_document_category()
    {
        //$userid='1';
        $userid =$this->session->userdata('userid');  
        $sql = "select c.cat_name,c.cat_id from document d , categories c where d.user_id = '$userid' and d.category = c.cat_id and c.cat_type = 'd' group by d.category " ;
        $query =  $this->db->query($sql); 
        $cat=$query->result_array();                
        return $cat;
    }

    public function deleteDocdata()
    {
       /*$userid = 1;
       $doc_id = $this->input->post('doc_id');
        $data=array('is_deleted'=>0);
            if ($userid > 0) {
           // $query = $this->db->where('user_id', $userid);
            $query = $this->db->where('doc_id', $doc_id);            
            $query = $this->db->update('document',$data);
           
        }*/

        //$userid='1';
        $userid =$this->session->userdata('userid');  
        $ids=$this->input->post('doc_id'); 

        //$query='UPDATE `document` SET `is_deleted` = 0 WHERE `doc_id` IN (' .$ids.') AND `userid` = '.$userid;       
        $sql= "UPDATE document SET is_deleted = 0 WHERE doc_id IN ($ids) ";     
         $query =  $this->db->query($sql);  
       /*echo $this->db->last_query();
        exit;*/
        return 'Done';
    }
    public function getAllDocumentsByCategory()
    {
       //$userid='1';
        $userid =$this->session->userdata('userid');  
       // $doc_id = $this->input->post('doc_id');
        $sql = "select d.*,c.cat_name, case when now() > d.expiry_date then 'E'  when DATE_ADD(now(),INTERVAL 30 DAY) >  d.expiry_date then 'EX' else 'A' end as status 
                    from document d , categories c where  d.category = c.cat_id and d.is_deleted = 1 order by d.expiry_date asc " ;
        $query = $this->db->query($sql);       
        $array = $query->result_array();            
        return $array;
    }
    public function getAllDocumentsExpired()
    {
        //$userid='1';
        $userid =$this->session->userdata('userid');  
       
        $sql = "select d.*,c.cat_id,c.cat_name, case when now() > d.expiry_date then 'E'  when DATE_ADD(now(),INTERVAL 30 DAY) >  d.expiry_date then 'EX' else 'A' end as status 
                    from document d , categories c where now() > d.expiry_date  and c.cat_type = 'D' and d.category = c.cat_id and d.is_deleted = 1 order by d.expiry_date asc" ;
        $query = $this->db->query($sql);       
        $array = $query->result_array();            
        return $array;
    }
     public function getAllDocumentsExpiring()
    {
        //$userid='1';
        $userid =$this->session->userdata('userid');  
        $sql = "select d.*,c.cat_id,c.cat_name, case when now() > d.expiry_date then 'E'  when DATE_ADD(now(),INTERVAL 30 DAY) >  d.expiry_date then 'EX' else 'A' end as status 
            from document d , categories c where DATE_ADD(now(),INTERVAL 30 DAY) >  d.expiry_date and c.cat_type = 'D' and  now() < d.expiry_date and d.category = c.cat_id and d.is_deleted = 1 order by d.expiry_date asc" ;
        $query = $this->db->query($sql);       
        $array = $query->result_array();            
        return $array;
    }
    public function getAllDocumentsActive()
    {
        //$userid='1';
        $userid =$this->session->userdata('userid');  
       // $doc_id = $this->input->post('doc_id');
        $sql = "select d.*,c.cat_id,c.cat_name, case when now() > d.expiry_date then 'E'  when DATE_ADD(now(),INTERVAL 30 DAY) >  d.expiry_date then 'EX' else 'A' end as status 
            from document d , categories c where DATE_ADD(now(),INTERVAL 30 DAY)<  d.expiry_date and now() < d.expiry_date and c.cat_type = 'D' and  d.category = c.cat_id and d.is_deleted = 1 order by d.expiry_date asc" ;
        $query = $this->db->query($sql);       
        $array = $query->result_array();            
        return $array;
    }

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

    public function Insert_documents_Data($PostArr, $categoryid) {
        $now = date("Y-m-d H:i:s");
        //$userid=1;
        $userid =$this->session->userdata('userid');  

        
        $data = array(
            'category' => $categoryid,
            'user_id' => $userid,
            'doc_name' => $PostArr['doc_name'],
            'doc_number' => $PostArr['doc_number'], 
            'start_date' => strftime("%Y-%m-%d", strtotime($PostArr['start_date'])),
            'expiry_date' => strftime("%Y-%m-%d", strtotime($PostArr['expiry_date'])),
            'notes' => $PostArr['notes'],
            'created_date' => $now
        );
        $this->db->insert('document', $data);
        $insert_id = $this->db->insert_id();
        
       /* $this->db->select('id,image_url');
        $this->db->from('lincense');
        $query = $this->db->where('id', $insertid);
        $query = $this->db->get();
        $users = $query->result_array();
        $datausers = array_merge($users);
        return $datausers;*/
        return 'Done';
    }

 
}
