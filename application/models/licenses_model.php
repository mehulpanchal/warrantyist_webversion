<?php

/*  Author: Mehul Panchal 
  Date:    12315
  Functions   : Add license, View Licenses, csv licenses import, licenses renewal, delete license
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Licenses_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
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

    public function Delete_license() {
        $id = $this->input->post('id');
        $data = array(
            'is_deleted' => 0
        );
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('lincense', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function Delete_multiple_license($id) {
        $data = array(
            'is_deleted' => 0
        );
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('lincense', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function Get_Csv_File($Fileid) {
        $this->db->select('filename');
        $this->db->where('id', $Fileid);
        $this->db->from('file_upload');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function Insert_Licenses_Data($PostArr, $categoryid, $single_entry) {
        $now = date("Y-m-d H:i:s");
        if ($single_entry == TRUE) {
            $data = array(
                'userid' => $this->session->userdata('userid'),
                'catid' => $categoryid,
                'softwear_name' => $PostArr['softwear_name'],
                'softwear_version' => $PostArr['softwear_version'],
                'registeremail' => $PostArr['registeremail'],
                'no_lincense' => $PostArr['no_lincense'],
                'vendor_name' => $PostArr['vendor_name'],
                'is_renew' => $PostArr['is_renew'],
                'image_url' => $PostArr['image_url'],
                'created_date' => $now
            );
        } else {
            $data = array(
                'userid' => $this->session->userdata('userid'),
                'catid' => $categoryid,
                'softwear_name' => $PostArr['softwear_name'],
                'softwear_version' => $PostArr['softwear_version'],
                'registeremail' => $PostArr['registeremail'],
                'no_lincense' => $PostArr['no_lincense'],
                'vendor_name' => $PostArr['vendor_name'],
                'is_renew' => $PostArr['is_renew'],
                'created_date' => $now
            );
        }
        $this->db->insert('lincense', $data);
        $insertid = $this->db->insert_id();

        $datas = array(
            'userid' => $this->session->userdata('userid'),
            'lincenseid' => $insertid,
            'invoice_number' => $PostArr['invoice_number'],
            'validity_in_month' => $PostArr['validity_in_month'],
            'invoice_date' => strftime("%Y-%m-%d", strtotime($PostArr['invoice_date'])),
            'purchase_amt' => $PostArr['purchase_amt'],
            'notedesc' => $PostArr['add_note'],
            'reminder' => $PostArr['reminder'],
            'start_date' => strftime("%Y-%m-%d", strtotime($PostArr['start_date']))
        );
        $this->db->insert('lincense_renewal', $datas);
        $insert_id = $this->db->insert_id();

        $this->db->select('id,image_url');
        $this->db->from('lincense');
        $query = $this->db->where('id', $insertid);
        $query = $this->db->get();
        $users = $query->result_array();
        $datausers = array_merge($users);
        return $datausers;
    }

    public function Update_Licenses_Data($PostArr, $categoryid, $rowid) {
        $now = date("Y-m-d H:i:s");

        $data = array(
            'userid' => $this->session->userdata('userid'),
            'catid' => $categoryid,
            'softwear_name' => $PostArr['softwear_name'],
            'softwear_version' => $PostArr['softwear_version'],
            'registeremail' => $PostArr['registeremail'],
            'no_lincense' => $PostArr['no_lincense'],
            'vendor_name' => $PostArr['vendor_name'],
            'is_renew' => $PostArr['is_renew'],
            'modified_date' => $now
        );
        if (!empty($this->input->post('image_url'))) {
            $data = array('image_url' => $PostArr['image_url']);
        }
        $this->db->trans_start();
        $this->db->where('id', $rowid);
        $this->db->update('lincense', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }

        $datas = array(
            'userid' => $this->session->userdata('userid'),
            'lincenseid' => $rowid,
            'invoice_number' => $PostArr['invoice_number'],
            'validity_in_month' => $PostArr['validity_in_month'],
            'invoice_date' => strftime("%Y-%m-%d", strtotime($PostArr['invoice_date'])),
            'purchase_amt' => $PostArr['purchase_amt'],
            'notedesc' => $PostArr['notedesc'],
            'reminder' => $PostArr['reminder'],
            'start_date' => strftime("%Y-%m-%d", strtotime($PostArr['start_date'])),
        );
        $this->db->trans_start();
        $this->db->where('lincenseid', $rowid);
        $this->db->update('lincense_renewal', $datas);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }
        $this->db->select('id');
        $this->db->from('lincense');
        $query = $this->db->where('id', $rowid);
        $query = $this->db->get();
        $users = $query->result_array();
        $datausers = array_merge($users);
        return $datausers;
    }

    public function Add_Renwal_Licenses_Data() {
        $now = date("Y-m-d H:i:s");
        $rowid = $this->input->post('lincenseid');
        $userid = $this->input->post('userid');
        $datas = array(
            //'userid' => $this->input->post('userid'),
            'supliername' => $this->input->post('supliername_renewal'),
            'renewal_purchase_date' => strftime("%Y-%m-%d", strtotime($this->input->post('renewal_purchase_date_renewal'))),
            'start_date' => strftime("%Y-%m-%d", strtotime($this->input->post('start_date_renewal'))),
            'validity_in_month' => $this->input->post('validity_in_month_renewal'),
            'notedesc' => $this->input->post('notedesc_renewal'),
            'created_date' => $now
        );
        $this->db->trans_start();
        $this->db->where('userid', $userid);
        $this->db->where('lincenseid', $rowid);
        $this->db->update('lincense_renewal', $datas);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function add_license() {
        $now = date("Y-m-d H:i:s");
        $userid = $this->input->post('userid');
        $catagory = $this->input->post('catagory');
        $softwear_name = $this->input->post('softwear_name');
        $softwear_version = $this->input->post('softwear_version');
        $registeremail = $this->input->post('registeremail');
        $no_lincense = $this->input->post('no_lincense');
        $vendor_name = $this->input->post('vendor_name');
        $is_renew = $this->input->post('is_renew');
        $image_url = $this->input->post('image_url');
        //this is for renewal data
        $supliername = $this->input->post('supliername');
        $validity_in_month = $this->input->post('validity_in_month');
        $invoice_number = $this->input->post('invoice_number');
        $invoice_date = $this->input->post('invoice_date');
        $purchase_amt = $this->input->post('purchase_amt');
        $renewal_purchase_date = $this->input->post('renewal_purchase_date');
        $notedesc = $this->input->post('notedesc');
        $start_date = $this->input->post('start_date');
        $reminder = $this->input->post('reminder');
        $clientid = $this->input->post('clientid');
        $this->db->select('cat_id,cat_name');
        $this->db->from('categories');
        $query = $this->db->where('cat_name', $catagory);
        $query = $this->db->get();
        $users = $query->result_array();
        $cat_id = $users['0']['cat_id'];
        $randno = substr(md5(rand()), 0, 6);
        if ($image_url != '') {
            $datas = base64_decode($image_url);
            $file = $_SERVER['DOCUMENT_ROOT'] . '/warrantyist/assets/img/lince/' . $randno . '.png';
            $fullurl = "http://" . $_SERVER['HTTP_HOST'] . '/warrantyist/assets/img/lince/' . $randno . '.png';
            $success = file_put_contents($file, $datas);
        } else {
            $fullurl = '';
        }

        $data = array(
            'userid' => $userid,
            'catid' => $cat_id,
            'softwear_name' => $softwear_name,
            'softwear_version' => $softwear_version,
            'registeremail' => $registeremail,
            'no_lincense' => $no_lincense,
            'vendor_name' => $vendor_name,
            'is_renew' => $is_renew,
            'image_url' => $fullurl,
            'created_date' => $now
        );
        $this->db->insert('lincense', $data);
        $insertid = $this->db->insert_id();

        $datas = array(
            'lincenseid' => $insertid,
            'supliername' => $supliername,
            'invoice_number' => $invoice_number,
            'validity_in_month' => $validity_in_month,
            'invoice_date' => $renewal_purchase_date,
            'purchase_amt' => $purchase_amt,
            'renewal_purchase_date' => $renewal_purchase_date,
            'notedesc' => $notedesc,
            'start_date' => $start_date,
            'reminder' => $reminder,
            'created_date' => $now
        );
        $this->db->insert('lincense_renewal', $datas);
        $insert_id = $this->db->insert_id();

        //this is for url
        $this->db->select('id,image_url');
        $this->db->from('lincense');
        $query = $this->db->where('id', $insertid);
        $query = $this->db->get();
        $users = $query->result_array();
        $datausers = array_merge($users, array($clientid));
        return $datausers;
    }

    function getLicensedetails() {
        $licenseid = $this->input->post('id');
        $userid = $this->session->userdata('userid');
        $this->db->select('lr.*, l.*, cat.cat_id as category, cat.cat_name');
        $this->db->from('lincense as l ');
        $this->db->join('lincense_renewal AS lr', 'lr.lincenseid = l.id');
        $this->db->join('categories AS cat', 'cat.cat_id = l.catid');
        $query = $this->db->where('l.id', $licenseid);
        $query = $this->db->where('lr.userid', $userid);
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            $array = $query->row_array();
            return $array;
        } else {
            return 'D';
        }
    }

    function getExpiredLicense() {
        $userid = $this->session->userdata('userid');
        $this->db->select('l.id,lr.lincenseid,lr.supliername,cat.cat_name,lr.invoice_number,lr.invoice_date,lr.purchase_amt,
                            lr.validity_in_month,lr.notedesc,lr.renewal_purchase_date,lr.reminder,lr.start_date,lr.end_date,
                            l.catid,l.softwear_name, l.softwear_version,l.vendor_name,l.no_lincense,l.image_url,l.is_renew');
        $this->db->select('DATE_ADD(lr.start_date, INTERVAL lr.validity_in_month MONTH) as expired', false);
        $this->db->from('lincense as l');
        $this->db->join('lincense_renewal AS lr', 'lr.lincenseid = l.id');
        $this->db->join('categories AS cat', 'cat.cat_id = l.catid');
        $query = $this->db->where('lr.userid', $userid);
        $query = $this->db->where('l.is_deleted', 1);
        $query = $this->db->having('expired < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null, false);
        $query = $this->db->group_by('lr.lincenseid');
//        echo $this->db->last_query();
//        exit;
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            $array = $query->result_array();
            return $array;
        } else {
            return 'D';
        }
    }

    function getExpiringLicense() {
        $userid = $this->session->userdata('userid');
        $this->db->select('l.id,lr.lincenseid,lr.supliername,cat.cat_name,lr.invoice_number,lr.invoice_date,lr.purchase_amt,
                            lr.validity_in_month,lr.notedesc,lr.renewal_purchase_date,lr.reminder,lr.start_date,lr.end_date,
                            l.catid,l.softwear_name, l.softwear_version,l.vendor_name,l.no_lincense,l.image_url,l.is_renew');
        $this->db->select('DATE_ADD(lr.start_date, INTERVAL lr.validity_in_month MONTH) as expiry', false);
        $this->db->from('lincense as l');
        $this->db->join('lincense_renewal AS lr', 'lr.lincenseid = l.id');
        $this->db->join('categories AS cat', 'cat.cat_id = l.catid');
        $query = $this->db->where('lr.userid', $userid);
        $query = $this->db->where('l.is_deleted', 1);
        $query = $this->db->having('expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 31 DAY)', null, false);
        $query = $this->db->group_by('lr.lincenseid');
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            $array = $query->result_array();
            return $array;
        } else {
            return 'D';
        }
    }

    function getActiveLicense() {
        $userid = $this->session->userdata('userid');
        $this->db->select('l.id,lr.lincenseid,lr.supliername,cat.cat_name,lr.invoice_number,lr.invoice_date,lr.purchase_amt,
                            lr.validity_in_month,lr.notedesc,lr.renewal_purchase_date,lr.reminder,lr.start_date,lr.end_date,
                            l.catid,l.softwear_name, l.softwear_version,l.vendor_name,l.no_lincense,l.image_url,l.is_renew');
        $this->db->select('DATE_ADD(lr.start_date, INTERVAL lr.validity_in_month MONTH) as expiry', false);
        $this->db->from('lincense as l');
        $this->db->join('lincense_renewal AS lr', 'lr.lincenseid = l.id');
        $this->db->join('categories AS cat', 'cat.cat_id = l.catid');
        $this->db->where('lr.userid', $userid);
        $this->db->where('l.is_deleted', 1);
        $this->db->having('expiry > DATE_ADD(CURDATE(), INTERVAL 30 DAY)', null, false);
        $this->db->group_by('lr.lincenseid');
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            $array = $query->result_array();
            return $array;
        } else {
            return 'D';
        }
    }
    
    function getSuggestionDataforSearch() {
        $userid = $this->session->userdata('userid');
        $this->db->select('softwear_name');
        $this->db->from('lincense');
        $this->db->where('userid', $userid);
       // $this->db->where('softwear_name', $this->input->post('word'));
       // $this->db->orderby('softwear_name','asc');
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            $array = $query->result_array();
            return $array;
        } else {
            return 'D';
        }
    }
    
    function getAllLicensesByCategory() {
        $userid = $this->session->userdata('userid');
        $sql = "select l.catid,c.cat_name from lincense l , categories c where l.userid = " . $userid . " AND l.catid = c.cat_id and c.cat_type = 'l' group by l.catid ";
        $query = $this->db->query($sql);
        $array = array();
        if ($query->num_rows > 0) {
            $array1 = $query->result_array();
            foreach ($array1 as $i => $row) {
                $this->db->_protect_identifiers = false;
                /* $this->db->select("l.id,lr.lincenseid,lr.supliername,cat.cat_name,lr.invoice_number,lr.invoice_date,lr.purchase_amt,
                  lr.validity_in_month,lr.notedesc,lr.renewal_purchase_date,lr.reminder,lr.start_date,lr.end_date,
                  l.catid,l.softwear_name, l.softwear_version,l.vendor_name,l.no_lincense,l.image_url,l.is_renew
                  , case when DATE_ADD(lr.start_date, INTERVAL lr.validity_in_month MONTH) < DATE_ADD(CURDATE(), INTERVAL -1 DAY) then 'expired'
                  when DATE_ADD(lr.start_date, INTERVAL lr.validity_in_month MONTH) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 31 DAY) then 'expiring'
                  else 'active' end as status");
                  $this->db->from('lincense as l');
                  $this->db->join('lincense_renewal as lr', 'lr.lincenseid = l.id');
                  $this->db->join('categories as cat', 'cat.cat_id = l.catid');
                  $query = $this->db->where('lr.userid', $userid);
                  $query = $this->db->where('l.catid', $row['catid']);
                  $query = $this->db->where('l.is_deleted', 1);
                  //$query = $this->db->having('expired < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null, false);
                  $query = $this->db->group_by('lr.lincenseid');
                  $query = $this->db->get();
                  $array = $query->result_array();
                  print_r($array);
                  exit; */
                $sql = "select l.id,lr.lincenseid,l.userid, lr.supliername,cat.cat_name,lr.invoice_number,lr.invoice_date,lr.purchase_amt,
                            lr.validity_in_month,lr.notedesc,lr.renewal_purchase_date,lr.reminder,lr.start_date,lr.end_date,
                            l.catid,l.softwear_name, l.softwear_version,l.vendor_name,l.no_lincense,l.image_url,l.is_renew
                            , case when DATE_ADD(lr.start_date, INTERVAL lr.validity_in_month MONTH) < DATE_ADD(CURDATE(), INTERVAL -1 DAY) then 'expired' 
                                 when DATE_ADD(lr.start_date, INTERVAL lr.validity_in_month MONTH) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 31 DAY) then 'expiring'
                                    else 'active' end as status from lincense l , lincense_renewal lr, categories cat where lr.lincenseid = l.id AND l.userid=" . $userid . " AND l.is_deleted = 1 AND l.catid = cat.cat_id and cat.cat_id = " . $row['catid'] . " group by lr.lincenseid";
                $query = $this->db->query($sql, array($row['catid']));
                $extended_arr = $query->result_array();
                // echo '<pre>';                print_r($extended_arr); exit;
                foreach ($extended_arr as $key => $value) {
                    $array[$row['cat_name']][$key] = $value;
                }
            }
            return $array;
        } else {
            return 'E';
        }
    }

    // insert method to your model
    function getReports($sDateStart, $sDateEnd) {

        $csv_terminated = "\n";
        $csv_separator = ", ";
        $csv_enclosed = '"';
        $csv_escaped = "\"";
        $schema_insert = "";
        $out = '';

        if (!is_int($sDateStart)) {

            $sDateStart = strtotime($sDateStart);
        }
        if (!is_int($sDateEnd)) {

            $sDateEnd = strtotime($sDateEnd);
        }

        $userid = $this->session->userdata('userid');
        $this->db->select('l.id, lr.lincenseid, lr.supliername, cat.cat_name, lr.invoice_number, lr.invoice_date, lr.purchase_amt,
            lr.validity_in_month, lr.notedesc, lr.renewal_purchase_date, lr.reminder, lr.start_date, lr.end_date,
            l.catid, l.softwear_name, l.softwear_version, l.vendor_name, l.no_lincense, l.image_url, l.is_renew');
        $this->db->select('DATE_ADD(lr.start_date, INTERVAL lr.validity_in_month MONTH) as active', false);
        $this->db->from('lincense as l');
        $this->db->join('lincense_renewal AS lr', 'lr.lincenseid = l.id');
        $this->db->join('categories AS cat', 'cat.cat_id = l.catid');
        $this->db->where('lr.userid', $userid);
        $this->db->where('l.is_deleted', 1);
        $this->db->having('active > DATE_ADD(CURDATE(), INTERVAL 30 DAY)', null, false);
        $this->db->group_by('lr.lincenseid');
        $aResults = $this->db->get();

        $aFields = $aResults->list_fields();

        foreach ($aFields as $sField) {

            $l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, stripslashes($sField)) . $csv_enclosed;
            $schema_insert .= $l;
            $schema_insert .= $csv_separator;
        }
        $out .= $schema_insert . $csv_terminated;

        // Format the data
        foreach ($aResults->result_array() as $aResult) {
            $schema_insert = '';
            foreach ($aFields as $sField) {

                //if ($aResult[$sField] == '0' || $aResult[$sField] != '') {

                if ($csv_enclosed == '') {

                    $schema_insert .= $aResult[$sField];
                } else {

                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $aResult[$sField]) . $csv_enclosed . $csv_separator;
                }
                /*  } else {

                  $schema_insert .= '';
                  } */
            }

            $out .= $schema_insert;
            $out .= $csv_terminated;
        }

        return $out;
    }

    function getsortalldash() {
        $data = array();
        $userid = $this->session->userdata('userid');
        $dt = date('Y-m-d', strtotime('-1 days'));
        $this->db->select('l.id,lr.lincenseid,lr.supliername,cat.cat_name,lr.invoice_number,lr.invoice_date,lr.purchase_amt');
        $this->db->select('DATE_ADD(lr.start_date, INTERVAL lr.validity_in_month MONTH) as expiry', false);
        $this->db->from('lincense as l');
        $this->db->join('lincense_renewal AS lr', 'lr.lincenseid = l.id');
        $this->db->join('categories AS cat', 'cat.cat_id = l.catid');
        $this->db->where('lr.userid', $userid);
        $this->db->where('l.is_deleted', 1);
        $this->db->having('expiry > DATE_ADD(CURDATE(), INTERVAL 30 DAY)', null, false);
        $this->db->group_by('lr.lincenseid');
        $query = $this->db->get();
        $data['licenses_active'] = $query->num_rows;


        $this->db->select('l.id,lr.lincenseid,lr.supliername,cat.cat_name,lr.invoice_number,lr.invoice_date,lr.purchase_amt');
        $this->db->select('DATE_ADD(lr.start_date, INTERVAL lr.validity_in_month MONTH) as expiry', false);
        $this->db->from('lincense as l');
        $this->db->join('lincense_renewal AS lr', 'lr.lincenseid = l.id');
        $this->db->join('categories AS cat', 'cat.cat_id = l.catid');
        $query2 = $this->db->where('lr.userid', $userid);
        $query2 = $this->db->where('l.is_deleted', 1);
        $query2 = $this->db->having('expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 31 DAY)', null, false);
        $query2 = $this->db->group_by('lr.lincenseid');
        $query2 = $this->db->get();
        $data['licenses_expiring'] = $query2->num_rows;


        $this->db->select('l.id,lr.lincenseid,lr.supliername,cat.cat_name,lr.invoice_number,lr.invoice_date,lr.purchase_amt');
        $this->db->select('DATE_ADD(lr.start_date, INTERVAL lr.validity_in_month MONTH) as expired', false);
        $this->db->from('lincense as l');
        $this->db->join('lincense_renewal AS lr', 'lr.lincenseid = l.id');
        $this->db->join('categories AS cat', 'cat.cat_id = l.catid');
        $query3 = $this->db->where('lr.userid', $userid);
        $query3 = $this->db->where('l.is_deleted', 1);
        $query3 = $this->db->having('expired < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null, false);
        $query3 = $this->db->group_by('lr.lincenseid');
        $query3 = $this->db->get();
        $data['licenses_expired'] = $query3->num_rows;

        return $data;
    }

}
