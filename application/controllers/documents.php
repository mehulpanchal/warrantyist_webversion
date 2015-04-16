<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Documents extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('document_model');
        //$this->load->helper('warranty_helper');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('login');
        }
    }
    public function index()
    {
    $this->load->view('documents/documents');    
    }
    public function viewDocproducts()
    {  
      $data=array();
          
      $data=$this->document_model->fetchDocData();
      //print_r($data);
      //exit;

      $this->output->set_content_type('application/json')->set_output(json_encode($data));       
    }

    public function docviewdetails()
    {                
        $this->load->view('documents/documentdetails');        
    }
    public function documentdetails()
    {        
      $doc=$this->document_model->edit_doc();       
      $this->output->set_content_type('application/json')->set_output(json_encode($doc));        
    }
     public function editDocumentView()
    {
        $this->load->view('documents/editdocuments');
    }
   
    public function editdocuments()
    {
        $p=$this->document_model->editproductview();        
        $this->output->set_content_type('application/json')->set_output(json_encode($p));                    
    }
    public function adddocumentview()
    {                
        $this->load->view('documents/adddocument');        
    }
    public function adddocument()
    {       
        $p=$this->document_model->addDocuments();        
        $this->output->set_content_type('application/json')->set_output(json_encode($p));        
    }
    public function get_category()
    {
        $cat= $this->document_model->get_document_category();
        $this->output->set_content_type('application/json')->set_output(json_encode($cat));       
    } 
    public function editDocument()
    {
    
        $p=$this->document_model->edit_docsave();      
    
        //$this->output->set_content_type('application/json')->set_output(json_encode($p));                    
    }
    public function deleteDoc()
    {
        $p=$this->document_model->deleteDocdata();    
        $this->output->set_content_type('application/json')->set_output(json_encode($p));     
    }
    public function getDocumentsByCategory() {
        $data = array();
        //$data = $this->document_model->getAllDocumentsByCategory();
         $data['expired']=$this->document_model->getAllDocumentsExpired();
       $data['expiring']=$this->document_model->getAllDocumentsExpiring();
       $data['active']=$this->document_model->getAllDocumentsActive();

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function documents_by_category() {
        //echo 'i m here';exit;

        $this->load->view('documents/getDocumentsByCategory');
    }

    public function getDocumentsByProduct() {
        $data = array();
        //$data = $this->document_model->getAllDocumentsByCategory();
        $data=$this->document_model->getAllDocumentsByCategory();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function documents_by_product() {
        //echo 'i m here';exit;

        $this->load->view('documents/getDocumentsByProduct');
    }

    public function documents_import() { // code by mehul as on 11315
        $this->load->model('category_model');
        $categry_array['categories'] = $this->category_model->getCategory('d');  // d for license category
        $this->load->view('documents/documents_import', $categry_array);
    }

    public function csv_file_upload() {
        $uploaddirdot = '';
        $uploaddir = $this->config->item('upload_url') . 'documents/';

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
                $csvFileId = $this->document_model->Insert_CSV_File($fullfilefoldernm, 'document');
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
            $file_listArr = $this->document_model->Get_Csv_File($files_id_Val);
            //$data = fgetcsv($handle, 1000, ",");
            // print_r($data);exit;
            $file_name = $file_listArr[0]['filename'];
            $handle = fopen($file_name, "r");
            $count = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                if ($count) {
                    // echo '<pre>';                print_r($data); exit;

                    //$categoryid = $_POST['categoryid'];
                    $doc_name = $_POST['doc_name'];
                    $doc_number = $_POST['doc_number'];
                    $start_date = $_POST['start_date'];
                    $expiry_date = $_POST['expiry_date'];
                    //$upload_doc = $_POST['upload_doc'];
                    $notes = $_POST['notes'];
                    

                    $Post_Arr = array();

                   // $Post_Arr['categoryid'] = $data[$categoryid];
                    $Post_Arr['doc_name'] = $data[$doc_name];
                    $Post_Arr['doc_number'] = $data[$doc_number];
                    $Post_Arr['start_date'] = $data[$start_date];
                    $Post_Arr['expiry_date'] = $data[$expiry_date];
                   // $Post_Arr['upload_doc'] = $data[$upload_doc];
                    $Post_Arr['notes'] = $data[$notes];
                    
                    $adm_listArr = $this->document_model->Insert_documents_Data($Post_Arr, $categoryid );
                }
                $count++;
            }
            fclose($handle);
        }
        return true;
    }

    function export_csv() {
        $this->load->database();
        //$userid = $this->session->userdata('userid');
        $userid = 1 ;
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

      
        $sql = "select d.*,c.cat_id,c.cat_name, case when now() > d.expiry_date then 'E'  when DATE_ADD(now(),INTERVAL 30 DAY) >  d.expiry_date then 'EX' else 'A' end as status 
                    from document d , categories c where now() > d.expiry_date  and c.cat_type = 'D' and d.category = c.cat_id and d.is_deleted = 1 order by d.expiry_date asc";
        $query_expired = $this->db->query($sql);  
        
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
        $objPHPExcel->getActiveSheet()->setTitle('Expired Documents');
        $objPHPExcel->setActiveSheetIndex(0);

       
        $sql = "select d.*,c.cat_id,c.cat_name, case when now() > d.expiry_date then 'E'  when DATE_ADD(now(),INTERVAL 30 DAY) >  d.expiry_date then 'EX' else 'A' end as status 
            from document d , categories c where DATE_ADD(now(),INTERVAL 30 DAY) >  d.expiry_date and c.cat_type = 'D' and  now() < d.expiry_date and d.category = c.cat_id and d.is_deleted = 1 order by d.expiry_date asc";
        $query_expiring = $this->db->query($sql);

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
        $objWorkSheet->setTitle("Expiring Documents");


        //active data

        $sql = "select d.*,c.cat_id,c.cat_name, case when now() > d.expiry_date then 'E'  when DATE_ADD(now(),INTERVAL 30 DAY) >  d.expiry_date then 'EX' else 'A' end as status 
            from document d , categories c where DATE_ADD(now(),INTERVAL 30 DAY)<  d.expiry_date and now() < d.expiry_date and c.cat_type = 'D' and  d.category = c.cat_id and d.is_deleted = 1 order by d.expiry_date asc";
        $query_active = $this->db->query($sql);

       
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
        $objWorkSheet->setTitle("Active Documents");

        // Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="DocumentsData_' . date('dMY') . '.xls"');
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
   
   
}

