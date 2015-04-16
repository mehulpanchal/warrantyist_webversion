<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Warranties extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('warranty_model');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('login');
        }
    }
    public function index()
    {
    $this->load->view('warranty/warranties');    
    }
    public function warranties_rnd()
    {
    $this->load->view('warranty/warranties_rnd');    
    }
    public function viewproducts()
    {  
       $data=$this->warranty_model->get_products();
       $this->output->set_content_type('application/json')->set_output(json_encode($data));       
    }
    public function productdetailsview()
    {                
        $this->load->view('warranty/productdetails');        
    }
    public function categoryview()
    {                
        $this->load->view('warranty/warranties_category');        
    }
    public function statusview()
    {                
        $this->load->view('warranty/warranties_status');        
    }
    public function addwarrantyview()
    {                
        $this->load->view('warranty/addwarranty');        
    }
    public function editWarrantyView()
    {
        $this->load->view('warranty/editwarranty');
    }
    public function productdetails()
    {        
        $product=$this->warranty_model->fetchproductdetails();        
        $this->output->set_content_type('application/json')->set_output(json_encode($product));        
    } 
     public function getproductcatwise()
    {        
        $product=$this->warranty_model->get_productcatwise();        
        $this->output->set_content_type('application/json')->set_output(json_encode($product));        
    } 
    
     public function get_category() {
        $this->load->model('category_model');
        $cat = $this->category_model->getCategory('w');
        $this->output->set_content_type('application/json')->set_output(json_encode($cat));
    }
    public function addwarranty()
    {       
        $p=$this->warranty_model->addWarranty();        
        $this->output->set_content_type('application/json')->set_output(json_encode($p));        
    }
    public function editproductview()
    {
        $p=$this->warranty_model->edit_product();        
        $this->output->set_content_type('application/json')->set_output(json_encode($p));                    
    }
     public function editWarranty()
    {
        $p=$this->warranty_model->edit_productsave();        
        //$this->output->set_content_type('application/json')->set_output(json_encode($p));                    
    }
    public function deleteWarranty()
    {
        $p=$this->warranty_model->deleteproduct();    
    }
    public function statussort()
    {
        $data=array();
        $data['expired']=$this->warranty_model->fetchwarrantyexpired();
        $data['expiring']=$this->warranty_model->fetchwarrantyexpiring();
        $data['active']=$this->warranty_model->fetchwarrantyactive();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function uploadimage()
    {
       // print_r($_FILES);   
        $tmp=$_FILES['file']['tmp_name'];                      
        $path="C:/Users/Appetals Solutions/Desktop/Warranty images/".$_FILES['file']['name'];
        move_uploaded_file($tmp, $path);               
        $answer = array( 'answer' => 'File transfer completed' );
        $json = json_encode($answer);
        echo $json;       
    }
     public function csv_file_upload() {
        $uploaddirdot = '';
        $uploaddir = $this->config->item('upload_url') . 'warranties/';
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
                $csvFileId = $this->warranty_model->Insert_CSV_File($fullfilefoldernm, 'warranty');
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
            $file_listArr = $this->warranty_model->Get_Csv_File($files_id_Val);
            // print_r($file_listArr);exit;
            $file_name = $file_listArr[0]['filename'];
            $handle = fopen($file_name, "r");
            $count = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($count) {
                    $product_name = $_POST['product_name'];
                    $user_name = $_POST['user_name'];
                    $provider_name = $_POST['provider_name'];
                    $manufacturer_name = $_POST['manufacturer_name'];
                    $support_phone = $_POST['support_phone'];
                    $support_email = $_POST['support_email'];
                    $seller_name = $_POST['seller_name'];
                    $model_number = $_POST['model_number'];
                    $serial_number = $_POST['serial_number'];
                    $invoice_number = $_POST['invoice_number'];
                    $invoice_date = $_POST['invoice_date'];
                    $warranty_start_date = $_POST['warranty_start_date'];
                    $warranty_duration = $_POST['warranty_duration'];
                    $reminder_time = $_POST['reminder_time'];
                    $add_note = $_POST['add_note'];
                    $Post_Arr = array();
                    $Post_Arr['a'] = $data[$product_name];
                    $Post_Arr['b'] = $data[$user_name];
                    $Post_Arr['c'] = $data[$provider_name];
                    $Post_Arr['d'] = $data[$manufacturer_name];
                    $Post_Arr['e'] = $data[$support_phone];
                    $Post_Arr['f'] = $data[$support_email];
                    $Post_Arr['g'] = $data[$seller_name];
                    $Post_Arr['h'] = $data[$model_number];
                    $Post_Arr['i'] = $data[$serial_number];
                    $Post_Arr['j'] = $data[$invoice_number];
//                $invoice_date = $data[$invoice_date];
//                $warranty_start_date = $data[$warranty_start_date];
//                list($day, $month, $year) = explode("-", $invoice_date);
//                $Post_Arr['k'] = $year . "-" . $month . "-" . $day;  // invoice date
//                list($day, $month, $year) = explode("-", $warranty_start_date);
//                $Post_Arr['l'] = $year . "-" . $month . "-" . $day; // warranty start date
                    $Post_Arr['k'] = $data[$invoice_date];
                    $Post_Arr['l'] = $data[$warranty_start_date];
                    $Post_Arr['m'] = $data[$warranty_duration];
                    $Post_Arr['n'] = $data[$reminder_time];
                    $Post_Arr['o'] = $data[$add_note];
                    //$Post_Arr['p'] = $data[$categoryid];
                    $adm_listArr = $this->warranty_model->Insert_Waaranty_Data($Post_Arr, $categoryid);
                }
                $count++;
            }
            fclose($handle);
        }
        return true;
    }
    public function warranties_import() { // code by mehul as on 11315
        $this->load->model('category_model');
        $categry_array['categories'] = $this->category_model->getCategory('w');
        $this->load->view('warranty/warranties_import', $categry_array);
    }
    function export_csv() {
        $this->load->database();
        $userid = 2;
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

//        $this->db->select('l.id,lr.lincenseid,lr.supliername,cat.cat_name,lr.invoice_number,lr.invoice_date,lr.purchase_amt,
//                            lr.validity_in_month,lr.notedesc,lr.renewal_purchase_date,lr.reminder,lr.start_date,lr.end_date,
//                            l.catid,l.softwear_name, l.softwear_version,l.vendor_name,l.no_lincense,l.image_url,l.is_renew');
//        $this->db->select('DATE_ADD(lr.start_date, INTERVAL lr.validity_in_month MONTH) as expired', false);
//        $this->db->from('lincense as l');
//        $this->db->join('lincense_renewal AS lr', 'lr.lincenseid = l.id');
//        $this->db->join('categories AS cat', 'cat.cat_id = l.catid');
//        $this->db->where('lr.userid', $userid);
//        $this->db->where('l.is_deleted', 1);
//        $this->db->having('expired < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null, false);
//        $this->db->group_by('lr.lincenseid');
//        $query_expired = $this->db->get();
//        echo $this->db->last_query();
//        exit;
         $userid=$this->session->userdata('userid');
        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry',false);
        $this->db->from('users as u');
        $this->db->join('products AS p', 'p.userid = u.userid');      
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
        $this->db->where('p.is_deleted','1');
        $query_expired = $this->db->where('p.userid', $userid); 
        $query_expired = $this->db->having('warranty_expiry < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null , false);            
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
        $objPHPExcel->getActiveSheet()->setTitle('Expired Warranty');
        $objPHPExcel->setActiveSheetIndex(0);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $userid=$this->session->userdata('userid');
        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry',false);
        $this->db->from('users as u');
        $this->db->join('products AS p', 'p.userid = u.userid');      
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
        $this->db->where('p.is_deleted','1');
        $query_expiring = $this->db->where('p.userid', $userid); 
        $query_expiring = $this->db->having('warranty_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 31 DAY)', null , false);                    
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
        $objWorkSheet->setTitle("Expiring Warranty");


        //active data
//        $this->db->select('l.id,lr.lincenseid,lr.supliername,cat.cat_name,lr.invoice_number,lr.invoice_date,lr.purchase_amt,
//                            lr.validity_in_month,lr.notedesc,lr.renewal_purchase_date,lr.reminder,lr.start_date,lr.end_date,
//                            l.catid,l.softwear_name, l.softwear_version,l.vendor_name,l.no_lincense,l.image_url,l.is_renew');
//        $this->db->select('DATE_ADD(lr.start_date, INTERVAL lr.validity_in_month MONTH) as expiry', false);
//        $this->db->from('lincense as l');
//        $this->db->join('lincense_renewal AS lr', 'lr.lincenseid = l.id');
//        $this->db->join('categories AS cat', 'cat.cat_id = l.catid');
//        $this->db->where('lr.userid', $userid);
//        $this->db->where('l.is_deleted', 1);
//        $this->db->having('expiry > DATE_ADD(CURDATE(), INTERVAL 30 DAY)', null, false);
//        $this->db->group_by('lr.lincenseid');
//        $query_active = $this->db->get();
            $userid=$this->session->userdata('userid');    
            $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
            $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry',false);
            $this->db->from('users as u');
            $this->db->join('products AS p', 'p.userid = u.userid');      
            $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
            $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
            $this->db->where('p.is_deleted','1');
            $query_active = $this->db->where('p.userid', $userid); 
            $query_active = $this->db->having('warranty_expiry > DATE_ADD(CURDATE(), INTERVAL 30 DAY)', null , false);                    
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
        $objWorkSheet->setTitle("Active Warranty");

        // Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="WarrantyData_'.  date('dMY').'.xls"');
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
     public function sortalldash()
    {        
        $data=$this->warranty_model->getsortalldash();      
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    
    

}