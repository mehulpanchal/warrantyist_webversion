<?php

/*  Author: Mehul Panchal 
  Date:    12315
  Functions   : Add license, View Licenses, csv licenses import, licenses renewal
 * create licenses_import function for upload csv file and add data into database code by mehul as 11315
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Licenses extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('licenses_model');
        //if user not logged in then redirect to login page
        if (!$this->session->userdata('is_logged_in')) {
            //$this->load->helper('url');
            //$this->session->set_userdata('last_page', current_url());
            redirect('login');
        }
    }

    public function index() {
        $this->load->view('license/licenses');
    }

    public function licenses_by_category() {
        //echo 'i m here';exit;
        $this->load->view('license/licenses_by_category');
    }

    public function getlicenses_by_category() {
        $data = array();
        $data = $this->licenses_model->getAllLicensesByCategory();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function addlicenseview() {
        $this->load->view('license/add_license');
    }

    public function delete_license() {
        $returndata = $this->licenses_model->Delete_license();
        if ($returndata == TRUE) {
            $data['success'] = true;
            $data['message'] = 'License Deleted!';
            $data['data'] = $returndata;
        } else {
            $data['fails'] = true;
            $data['message'] = 'delete fails ';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function multi_delete_license() {
        $ids = explode(",", $this->input->post('ids'));
        foreach ($ids as $value) {
            $returndata = $this->licenses_model->Delete_multiple_license($value);
            if ($returndata == TRUE) {
                $data['success'] = true;
                $data['message'] = 'License Deleted!';
                $data['data'] = $value . ' updated';
            } else {
                $data['fails'] = true;
                $data['message'] = 'delete fails ';
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function editlicenseview() {
        $this->load->view('license/edit_license');
    }

    public function editrenewallicenseview() {
        $this->load->view('license/edit_renewal_license');
    }

    public function get_category() {
        $this->load->model('category_model');
        $cat = $this->category_model->getCategory('l');
        $this->output->set_content_type('application/json')->set_output(json_encode($cat));
    }
    
    public function getsuggestiondata() {
        $data['suggest'] = $this->licenses_model->getSuggestionDataforSearch();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function getlicensesdata() {
        $data = array();
        $data['expired'] = $this->licenses_model->getExpiredLicense();
        $data['expiring'] = $this->licenses_model->getExpiringLicense();
        $data['active'] = $this->licenses_model->getActiveLicense();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function licensedetailsview() {
        $this->load->view('license/license_details');
    }

    public function uploadimage() {
        $image_url = $this->input->post('image_url');
        if ($image_url != '') {
            $randno = substr(md5(rand()), 0, 6);
            $datas = base64_decode($image_url);
            $file = $_SERVER['DOCUMENT_ROOT'] . '/warrantyist/assets/images/licenses/' . $randno . '.png';
            $fullurl = "http://" . $_SERVER['HTTP_HOST'] . '/warrantyist/assets/images/licenses/' . $randno . '.png';
            $fullurl['success'] = $success = file_put_contents($file, $datas);
        } else {
            $fullurl = '';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function addlicense() {
        $this->load->model('category_model');
        $categry_array['categories'] = $this->category_model->getCategory('l');  // l for license category
        if (!empty($this->input->post('softwear_name'))) {
            $errors = array();   // array to hold validation errors
            $data = array();   // array to pass back data
            // validate the variables ======================================================
            if (empty($this->input->post('softwear_name')))
                $errors['softwear_name'] = 'softwear_name is required.';
            if (empty($this->input->post('softwear_version')))
                $errors['softwear_version'] = 'softwear_version alias is required.';
            // return a response ===========================================================
            // response if there are errors
            if (!empty($errors)) {
                // if there are items in our errors array, return those errors
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {
                // if there are no errors, return a message
                $Post_Arr = array();
                $categoryid = $this->input->post('category');
                $Post_Arr['softwear_name'] = $this->input->post('softwear_name');
                $Post_Arr['softwear_version'] = $this->input->post('softwear_version');
                $Post_Arr['registeremail'] = $this->input->post('registeremail');
                $Post_Arr['no_lincense'] = $this->input->post('no_lincense');
                $Post_Arr['validity_in_month'] = $this->input->post('validity_in_month');
                $Post_Arr['invoice_number'] = $this->input->post('invoice_number');
                $Post_Arr['invoice_date'] = $this->input->post('invoice_date');
                $Post_Arr['start_date'] = $this->input->post('invoice_date');
                $Post_Arr['vendor_name'] = $this->input->post('vendor_name');
                $Post_Arr['purchase_amt'] = $this->input->post('purchase_amt');
                $Post_Arr['is_renew'] = ($this->input->post('is_renew') == "true" ? 'y' : 'n');
                $Post_Arr['reminder'] = $this->input->post('reminder');
                $Post_Arr['add_note'] = $this->input->post('add_note');
                $Post_Arr['image_url'] = $this->input->post('license_image');

                $returndata = $this->licenses_model->Insert_Licenses_Data($Post_Arr, $categoryid, $single_entry = TRUE);
                $data['success'] = true;
                $data['message'] = 'Success! The License has been added. ';
                $data['data'] = $returndata;
            }
            // return all our data to an AJAX call
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $this->load->view('license/addlicense', $categry_array);
        }
    }

    public function editlicense() {
//        $this->load->model('category_model');
        //  $categry_array['categories'] = $this->category_model->getCategory('l');  // l for license category
        if (!empty($this->input->post('softwear_name'))) {
            $errors = array();   // array to hold validation errors
            $data = array();   // array to pass back data
            // validate the variables ======================================================
            if (empty($this->input->post('softwear_name')))
                $errors['softwear_name'] = 'softwear_name is required.';
            if (empty($this->input->post('softwear_version')))
                $errors['softwear_version'] = 'softwear_version alias is required.';
            // return a response ===========================================================
            // response if there are errors
            if (!empty($errors)) {
                // if there are items in our errors array, return those errors
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {
                // if there are no errors, return a message
                $Post_Arr = array();
                $categoryid = $this->input->post('category');
                $rowid = $this->input->post('id');
                $Post_Arr['softwear_name'] = $this->input->post('softwear_name');
                $Post_Arr['softwear_version'] = $this->input->post('softwear_version');
                $Post_Arr['registeremail'] = $this->input->post('registeremail');
                $Post_Arr['no_lincense'] = $this->input->post('no_lincense');
                $Post_Arr['validity_in_month'] = $this->input->post('validity_in_month');
                $Post_Arr['invoice_number'] = $this->input->post('invoice_number');
                $Post_Arr['invoice_date'] = $this->input->post('invoice_date');
                $Post_Arr['start_date'] = $this->input->post('invoice_date');
                $Post_Arr['vendor_name'] = $this->input->post('vendor_name');
                $Post_Arr['purchase_amt'] = $this->input->post('purchase_amt');
                $Post_Arr['is_renew'] = ($this->input->post('is_renew') == "y" ? 'y' : 'n');
                $Post_Arr['reminder'] = $this->input->post('reminder');
                $Post_Arr['notedesc'] = $this->input->post('notedesc');
                if (!empty($this->input->post('image_url'))) {
                    $Post_Arr['image_url'] = $this->input->post('image_url');
                }
                $returndata = $this->licenses_model->Update_Licenses_Data($Post_Arr, $categoryid, $rowid);
                if ($returndata == TRUE) {
                    $data['success'] = true;
                    $data['message'] = 'Success! The License has been Edited. ';
                    $data['data'] = $returndata;
                } else {
                    $data['fails'] = true;
                    $data['message'] = 'update fails ';
                }
            }
            // return all our data to an AJAX call
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $this->load->view('license/editlicense', $categry_array);
        }
    }

    public function editrenwallicense() {
        if (!empty($this->input->post('supliername_renewal'))) {
            $errors = array();   // array to hold validation errors
            $data = array();   // array to pass back data
            // validate the variables ======================================================
            if (empty($this->input->post('supliername_renewal')))
                $errors['supliername_renewal'] = 'Suplier Name is required.';
            if (empty($this->input->post('renewalreceiptno_renewal')))
                $errors['renewalreceiptno_renewal'] = 'Renewal Receipt No is required.';
            if (!empty($errors)) {
                // if there are items in our errors array, return those errors
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {
//                echo '<pre>'; print_r($_POST); exit();
                $returndata = $this->licenses_model->Add_Renwal_Licenses_Data();
                $data['success'] = true;
                $data['message'] = 'Success! Your License has been Renewed. ';
                $data['data'] = $returndata;
            }
            // return all our data to an AJAX call
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    public function csv_file_upload() {
        $uploaddirdot = '';
        $uploaddir = $this->config->item('upload_url') . 'licenses/';

        $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

        $path = $_FILES['userfile']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $validImageTypes = array("csv", "CSV");

        if (!in_array($ext, $validImageTypes)) {
            echo "error#@#Please upload valid CSV file.";
        } else {
            if (file_exists($uploaddirdot . $uploadfile)) {
                $time = date('YmdHis');
                $filenm = $time . '_' . basename($_FILES['userfile']['name']);
                $uploadfile = $uploaddir . $filenm;
            } else {
                $filenm = basename($_FILES['userfile']['name']);
            }
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddirdot . $uploadfile)) {
                $file = $uploaddir . $uploadfile;
                $fullfilefoldernm = $this->config->item('base_url') . '/' . $uploadfile;
                $csvFileId = $this->licenses_model->Insert_CSV_File($fullfilefoldernm, 'license');
                echo $filenm . "#@#" . $fullfilefoldernm . "#@#" . $csvFileId;
            } else {
                echo "error#@#";
            }
        }
    }

    public function add_csv_file() {
        $files_id_Arr = explode(",", $_POST['FilesI']);
        $categoryid = base64_decode($_POST['categoryid']);
//        print_r($files_id_Arr);exit;
        foreach ($files_id_Arr AS $files_id_Val) {
            $file_listArr = $this->licenses_model->Get_Csv_File($files_id_Val);
            //$data = fgetcsv($handle, 1000, ",");
            // print_r($data);exit;
            $file_name = $file_listArr[0]['filename'];
            $handle = fopen($file_name, "r");
            $count = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                if ($count) {
                    // echo '<pre>';                print_r($data); exit;
                    $softwear_name = $_POST['softwear_name'];
                    $softwear_version = $_POST['softwear_version'];
                    $registeremail = $_POST['registeremail'];
                    $no_lincense = $_POST['no_lincense'];
                    $validity_in_month = $_POST['validity_in_month'];
                    $invoice_number = $_POST['invoice_number'];
                    $invoice_date = $_POST['invoice_date'];
                    $vendor_name = $_POST['vendor_name'];
                    $purchase_amt = $_POST['purchase_amt'];
                    $is_renew = $_POST['is_renew'];
                    $reminder = $_POST['reminder'];
                    $add_note = $_POST['add_note'];

                    $Post_Arr = array();

                    $Post_Arr['softwear_name'] = $data[$softwear_name];
                    $Post_Arr['softwear_version'] = $data[$softwear_version];
                    $Post_Arr['registeremail'] = $data[$registeremail];
                    $Post_Arr['no_lincense'] = $data[$no_lincense];
                    $Post_Arr['validity_in_month'] = $data[$validity_in_month];
                    $Post_Arr['invoice_number'] = $data[$invoice_number];
                    $Post_Arr['invoice_date'] = $data[$invoice_date];
                    $Post_Arr['start_date'] = $data[$invoice_date];
                    $Post_Arr['vendor_name'] = $data[$vendor_name];
                    $Post_Arr['purchase_amt'] = $data[$purchase_amt];
                    $Post_Arr['is_renew'] = $data[$is_renew];
//                $invoice_date = $data[$invoice_date];
//                $warranty_start_date = $data[$warranty_start_date];
//                list($day, $month, $year) = explode("-", $invoice_date);
//                $Post_Arr['k'] = $year . "-" . $month . "-" . $day;  // invoice date
//                list($day, $month, $year) = explode("-", $warranty_start_date);
//                $Post_Arr['l'] = $year . "-" . $month . "-" . $day; // warranty start date

                    $Post_Arr['reminder'] = $data[$reminder];
                    $Post_Arr['add_note'] = $data[$add_note]; //11
                    //echo  $Post_Arr['m'] = $data[$categoryid];
                    //exit;
                    $adm_listArr = $this->licenses_model->Insert_Licenses_Data($Post_Arr, $categoryid, $single_entry = FALSE);
                }
                $count++;
            }
            fclose($handle);
        }
        return true;
    }

    public function licenses_import() { // code by mehul as on 11315
        $this->load->model('category_model');
        $categry_array['categories'] = $this->category_model->getCategory('l');  // l for license category
        $this->load->view('license/licenses_import', $categry_array);
    }

    public function license_details() {
        $product = $this->licenses_model->getLicensedetails();
        $this->output->set_content_type('application/json')->set_output(json_encode($product));
    }

    public function editproductview() {
        $product = $this->licenses_model->getLicensedetails();
        $this->output->set_content_type('application/json')->set_output(json_encode($product));
    }

    function export_csv() {
        $this->load->database();
        $userid = $this->session->userdata('userid');
        // Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Mehul")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

        $this->db->select('l.id,lr.lincenseid,lr.supliername,cat.cat_name,lr.invoice_number,lr.invoice_date,lr.purchase_amt,
                            lr.validity_in_month,lr.notedesc,lr.renewal_purchase_date,lr.reminder,lr.start_date,lr.end_date,
                            l.catid,l.softwear_name, l.softwear_version,l.vendor_name,l.no_lincense,l.image_url,l.is_renew');
        $this->db->select('DATE_ADD(lr.start_date, INTERVAL lr.validity_in_month MONTH) as expired', false);
        $this->db->from('lincense as l');
        $this->db->join('lincense_renewal AS lr', 'lr.lincenseid = l.id');
        $this->db->join('categories AS cat', 'cat.cat_id = l.catid');
        $this->db->where('lr.userid', $userid);
        $this->db->where('l.is_deleted', 1);
        $this->db->having('expired < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null, false);
        $this->db->group_by('lr.lincenseid');
        $query_expired = $this->db->get();
        if (!$query_expired)
            return false;
        $fields_expired = $query_expired->list_fields();
        $col = 0;
        foreach ($fields_expired as $field) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
        // Fetching the table data
        $row = 2;
        foreach ($query_expired->result() as $data) {
            $col = 0;
            foreach ($fields_expired as $field) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }

            $row++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('Expired License');
        $objPHPExcel->setActiveSheetIndex(0);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
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
        $query_expiring = $this->db->get();
        if (!$query_expiring)
            return false;
        $fieldsexpiring = $query_expiring->list_fields();
        // Add new sheet
        $objWorkSheet = $objPHPExcel->createSheet(1); //Setting index when creating
        $col = 0;
        foreach ($fieldsexpiring as $field) {
            $objWorkSheet->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
        // Fetching the table data
        $row = 2;
        foreach ($query_expiring->result() as $data) {
            $col = 0;
            foreach ($fieldsexpiring as $field) {
                $objWorkSheet->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }

            $row++;
        }
        // Rename sheet
        $objWorkSheet->setTitle("Expiring License");


        //active data
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
        $query_active = $this->db->get();
        if (!$query_active)
            return false;
        // Add new sheet
        $fieldsactive = $query_active->list_fields();
        $objWorkSheet = $objPHPExcel->createSheet(2); //Setting index when creating
        //Write cells
        $col = 0;
        foreach ($fieldsactive as $field) {
            $objWorkSheet->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
        // Fetching the table data
        $row = 2;
        foreach ($query_active->result() as $data) {
            $col = 0;
            foreach ($fieldsactive as $field) {
                $objWorkSheet->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }

            $row++;
        }
        // Rename sheet
        $objWorkSheet->setTitle("Active License");

        // Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="LicenseData_' . date('dMY') . '.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function sortalldash() {
        $data = $this->licenses_model->getsortalldash();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

}
