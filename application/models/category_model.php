<?php

/*  Author: Mehul Panchal 
  Date:    12315
  Functions   : Add license, View Licenses, csv licenses import, licenses renewal+
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category_model extends CI_Model {

    public function __construct() { // add by mehul as on 11315
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function getCategory($cat_type) {
         $this->db->select('*');
        $this->db->from('categories');
        $this->db->where('cat_type',$cat_type);
        $query=$this->db->get();
        $cat=$query->result_array();                
        return $cat;
    }
    
    public function getCategoryName($id) {
        $this->db->select('cat_name');
        $this->db->from('categories');
        $this->db->where('cat_id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['cat_name'];
    }
}
