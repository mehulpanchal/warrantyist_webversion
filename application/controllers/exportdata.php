<?php

// Mehul 2415
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates  
 * and open the template in the editor.   
 */

class Exportdata extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('exportdata_model');
        $this->load->library('csvimport');
    }

    public function data_export() {
        if ($postdata = file_get_contents("php://input")) {
            $request = json_decode($postdata);
        }
        $userid = $this->session->userdata('userid');
        
        $typearray = array();
        foreach ($request->export as $value) {
            $typearray[$value] = $value;
        }

        if (isset($typearray['All']) == "All") {
            $this->data_export_all($userid);
        }
        if (isset($typearray['Warranties']) == "Warranties") {
            $this->data_export_warrantyists($userid);
        }

        if (isset($typearray['Licenses']) == "Licenses") {
            $this->data_export_licences($userid);
        }
        if (isset($typearray['Documents']) == "Documents") {
            $this->data_export_documents($userid);
        }

        if (isset($typearray['AMCs']) == "AMCs") {
            $this->data_export_amcs($userid);
        }
        if (isset($typearray['Service Schedule']) == "Service Schedule") {
            $this->data_export_service_schedule($userid);
        }
        if (!empty($request->export)) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('message' => 'Data exported successfully', 'status' => TRUE)));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('message' => 'Data export faild', 'status' => FALSE)));
        }
    }

    public function data_export_all($userid) {

        $result = $this->exportdata_model->get_user_data($userid);
        $this->load->database();
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        //Set AMCS
        $objPHPExcel->getProperties()->setCreator("Mehul")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

        $this->db->select('a.*');
        $this->db->select('DATE_ADD(a.amc_start_date , INTERVAL a.duration MONTH) as amc_expiry_date', false);
        $this->db->select('case when NOW() > DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) then "E"  when DATE_ADD(NOW(),INTERVAL 30 DAY) > DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) then "EX" ELSE "A" END AS status', false);
        $this->db->from('amc_details a');
        $this->db->where('userid', $userid);
        $this->db->where('is_deleted', '1');
        $this->db->order_by('a.amc_id', 'desc');
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

        $objPHPExcel->getActiveSheet()->setTitle('AMCS');
        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $randno = date('DMYhms');
        $file = $this->config->item('doc_root') . 'uploads/exportdata/' . $result['0']['username'] . '_AMCs_' . $randno . '.xls';
        $objWriter->save($file);

        //SET DOCUMENTS

        $this->db->select('l.doc_id,l.doc_name,l.doc_number,l.start_date,l.expiry_date,l.notes');
        $this->db->from('document as l');
        $this->db->where('l.user_id', $userid);
        $query_expired2 = $this->db->get();
        if (!$query_expired2)
            return false;
        $fields_expired2 = $query_expired2->list_fields();
        $col = 0;
        foreach ($fields_expired2 as $field) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
        // Fetching the table data
        $row = 2;
        foreach ($query_expired2->result() as $data) {
            $col = 0;
            foreach ($fields_expired2 as $field) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }
            $row++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('Documents');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $randno = date('DMYhms');
        $file2 = $this->config->item('doc_root') . 'uploads/exportdata/' . $result['0']['username'] . '_Documents' . $randno . '.xls';
        $objWriter->save($file2);

        //Warranties

        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.warranty_card,p.purchase_invoice,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry', false);
        $this->db->from('users as u');
        $this->db->join('products AS p', 'p.userid = u.userid');
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
        $this->db->where('p.is_deleted', '1');
        $query = $this->db->where('p.userid', $userid);
        $query = $this->db->having('warranty_expiry < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null, false);
        $query_expired_warr = $this->db->get();
        if (!$query_expired_warr)
            return false;
        $fields_expired_warr = $query_expired_warr->list_fields();
        $col = 0;
        foreach ($fields_expired_warr as $field) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
        // Fetching the table data
        $row = 2;
        foreach ($query_expired_warr->result() as $data) {
            $col = 0;
            foreach ($fields_expired_warr as $field) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }

            $row++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('Expired Warranties');
        $objPHPExcel->setActiveSheetIndex(0);

        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.warranty_card,p.purchase_invoice,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry', false);
        $this->db->from('users as u');
        $this->db->join('products AS p', 'p.userid = u.userid');
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
        $this->db->where('p.is_deleted', '1');
        $query = $this->db->where('p.userid', $userid);
        $query = $this->db->having('warranty_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 31 DAY)', null, false);
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
        $objWorkSheet->setTitle("Expiring Warranties");

        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.warranty_card,p.purchase_invoice,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry', false);
        $this->db->from('users as u');
        $this->db->join('products AS p', 'p.userid = u.userid');
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
        $this->db->where('p.is_deleted', '1');
        $query = $this->db->where('p.userid', $userid);
        $query = $this->db->having('warranty_expiry > DATE_ADD(CURDATE(), INTERVAL 30 DAY)', null, false);
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
        $objWorkSheet->setTitle("Active Warranties");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $randno = date('DMYhms');
        //echo $_SERVER['DOCUMENT_ROOT'];exit;
        $file3 = $this->config->item('doc_root') . 'uploads/exportdata/' . $result['0']['username'] . '_Warranties_' . $randno . '.xls';
        $objWriter->save($file3);



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
        $query_expired_lic = $this->db->get();
        if (!$query_expired)
            return false;
        $fields_expired_lic = $query_expired_lic->list_fields();
        $col = 0;
        foreach ($fields_expired_lic as $field) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
        // Fetching the table data
        $row = 2;
        foreach ($query_expired_lic->result() as $data) {
            $col = 0;
            foreach ($fields_expired_lic as $field) {
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
        $query_expiring_lic = $this->db->get();
        if (!$query_expiring)
            return false;
        $fieldsexpiring_lic = $query_expiring_lic->list_fields();
        // Add new sheet
        $objWorkSheet = $objPHPExcel->createSheet(1); //Setting index when creating
        $col = 0;
        foreach ($fieldsexpiring_lic as $field) {
            $objWorkSheet->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
        // Fetching the table data
        $row = 2;
        foreach ($query_expiring_lic->result() as $data) {
            $col = 0;
            foreach ($fieldsexpiring_lic as $field) {
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
        $query_active_lic = $this->db->get();
        if (!$query_active)
            return false;
        // Add new sheet
        $fieldsactive_lic = $query_active_lic->list_fields();
        $objWorkSheet = $objPHPExcel->createSheet(2); //Setting index when creating
        //Write cells
        $col = 0;
        foreach ($fieldsactive_lic as $field) {
            $objWorkSheet->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
        // Fetching the table data
        $row = 2;
        foreach ($query_active_lic->result() as $data) {
            $col = 0;
            foreach ($fieldsactive_lic as $field) {
                $objWorkSheet->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }

            $row++;
        }
        // Rename sheet
        $objWorkSheet->setTitle("Active License");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $randno = date('DMYhms');
        //echo $_SERVER['DOCUMENT_ROOT'];exit;
        $file4 = $this->config->item('doc_root') . 'uploads/exportdata/' . $result['0']['username'] . '_Licenses_' . $randno . '.xls';
        $objWriter->save($file4);


        $this->db->select('s.*,GROUP_CONCAT(DISTINCT dm.image) as images,GROUP_CONCAT(DISTINCT dm.id) as imgids,GROUP_CONCAT(DISTINCT sd.id) as dateids,GROUP_CONCAT(DISTINCT sd.service_date) as sdates');
        $this->db->from('services_shedule s');
        $this->db->join('services_dates sd', 's.service_id = sd.service_id', 'left');
        $this->db->join('document_image dm', 's.service_id = dm.service_id', 'left');
        $this->db->where('s.is_deleted', '1');
        $this->db->where('s.user_id IN (".$userid.")');
        $this->db->group_by('s.service_id');
        $this->db->order_by('s.service_id', 'desc');
        $query_expired_service = $this->db->get();

        if (!$query_expired)
            return false;
        $fields_expired_service = $query_expired_service->list_fields();
        $col = 0;
        foreach ($fields_expired_service as $field) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
        // Fetching the table data
        $row = 2;
        foreach ($query_expired_service->result() as $data) {
            $col = 0;
            foreach ($fields_expired_service as $field) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }
            $row++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('Services Schedule');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $randno = date('DMYhms');
        $file5 = $this->config->item('doc_root') . 'uploads/exportdata/' . $result['0']['username'] . '_ServicesSchedules_' . $randno . '.xls';
        $objWriter->save($file5);

        $email_message = "<html><body>";
        $email_message .= "<table>";
        $email_message .= "<tr><td><b>Warrantyist</b></td></tr>";
        $email_message .= "<tr><td>Hello " . $result['0']['username'] . "!" . "</td></tr>";
        $email_message .= "</table>";
        $email_message .= "</html></body>";
        $str_email_subject = "Document of  Warrantyist";
        $toemail = $result['0']['email'];
        $this->load->library('email');
        $this->email->from("noreply@warrantyist.com","noreply");
        $this->email->to($toemail);
        $this->email->subject($str_email_subject);
        $this->email->message($email_message);
        $this->email->attach($file);
        $this->email->attach($file2);
        $this->email->attach($file3);
        $this->email->attach($file4);
        $this->email->attach($file5);
        $this->email->send();
    }

    public function data_export_amcs($userid) {

        $result = $this->exportdata_model->get_user_data($userid);
        //print_r($result);exit;
        $this->load->database();
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        //Set document properties
        $objPHPExcel->getProperties()->setCreator("Mehul")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

        $this->db->select('a.*');
        $this->db->select('DATE_ADD(a.amc_start_date , INTERVAL a.duration MONTH) as amc_expiry_date', false);
        $this->db->select('case when NOW() > DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) then "E"  when DATE_ADD(NOW(),INTERVAL 30 DAY) > DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) then "EX" ELSE "A" END AS status', false);
        $this->db->from('amc_details a');
        $this->db->where('userid', $userid);
        $this->db->where('is_deleted', '1');
        $this->db->order_by('a.amc_id', 'desc');
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

        $objPHPExcel->getActiveSheet()->setTitle('AMCs');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $randno = date('DMYhms');
        $file = $this->config->item('doc_root') . 'uploads/exportdata/' . $result['0']['username'] . '_AMCs_' . $randno . '.xls';
        $objWriter->save($file);
        $email_message = "<html><body>";
        $email_message .= "<table>";
        $email_message .= "<tr><td><b>Warrantyist</b></td></tr>";
        $email_message .= "<tr><td>Hello " . $result['0']['username'] . "!" . "</td></tr>";
        $email_message .= "</table>";
        $email_message .= "</html></body>";
        $str_email_subject = "Document of  Warrantyist";
        $toemail = $result['0']['email'];
        $this->load->library('email');
        $this->email->from("noreply@warrantyist.com");
        $this->email->to($toemail);
        $this->email->subject($str_email_subject);
        $this->email->message($email_message);
        $this->email->attach($file);
        $this->email->send();
    }

    public function data_export_warrantyists($userid) {

        $result = $this->exportdata_model->get_user_data($userid);
        $this->load->database();
        //$userid = 2;
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

        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.warranty_card,p.purchase_invoice,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry', false);
        $this->db->from('users as u');
        $this->db->join('products AS p', 'p.userid = u.userid');
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
        $this->db->where('p.is_deleted', '1');
        $query = $this->db->where('p.userid', $userid);
        $query = $this->db->having('warranty_expiry < DATE_ADD(CURDATE(), INTERVAL -1 DAY)', null, false);
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
        $objPHPExcel->getActiveSheet()->setTitle('Expired Warranties');
        $objPHPExcel->setActiveSheetIndex(0);

        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.warranty_card,p.purchase_invoice,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry', false);
        $this->db->from('users as u');
        $this->db->join('products AS p', 'p.userid = u.userid');
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
        $this->db->where('p.is_deleted', '1');
        $query = $this->db->where('p.userid', $userid);
        $query = $this->db->having('warranty_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 31 DAY)', null, false);
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
        $objWorkSheet->setTitle("Expiring Warranties");

        $this->db->select('u.userid,p.product_id,p.catagory,p.provider_name,cat.cat_name,p.product_name,p.user_name,p.manufacturer_name,p.support_phone,p.support_email,p.seller_name,p.model_number,p.serial_number,p.invoice_number,p.invoice_date,p.warranty_card,p.purchase_invoice,p.reminder_time,p.warranty_duration,p.warranty_start_date,no.desc');
        $this->db->select('DATE_ADD(p.warranty_start_date, INTERVAL p.warranty_duration MONTH) as warranty_expiry', false);
        $this->db->from('users as u');
        $this->db->join('products AS p', 'p.userid = u.userid');
        $this->db->join('user_notes AS no', 'no.product_id = p.product_id');
        $this->db->join('categories AS cat', 'cat.cat_id = p.catagory');
        $this->db->where('p.is_deleted', '1');
        $query = $this->db->where('p.userid', $userid);
        $query = $this->db->having('warranty_expiry > DATE_ADD(CURDATE(), INTERVAL 30 DAY)', null, false);
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
        $objWorkSheet->setTitle("Active Warranties");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $randno = date('DMYhms');
        //echo $_SERVER['DOCUMENT_ROOT'];exit;
        $file = $this->config->item('doc_root') . 'uploads/exportdata/' . $result['0']['username'] . '_Warranties_' . $randno . '.xls';
        $objWriter->save($file);
        $email_message = "<html><body>";
        $email_message .= "<table>";
        $email_message .= "<tr><td><b>Warrantyist</b></td></tr>";
        $email_message .= "<tr><td>Hello " . $result['0']['username'] . "!" . "</td></tr>";
        $email_message .= "</table>";
        $email_message .= "</html></body>";
        $str_email_subject = "Document of  Warrantyist";
        $toemail = $result['0']['email'];
        $this->load->library('email');
        $this->email->from("noreply@warrantyist.com");
        $this->email->to($toemail);
        $this->email->subject($str_email_subject);
        $this->email->message($email_message);
        $this->email->attach($file);
        $this->email->send();
    }

    public function data_export_licences($userid) {

        $result = $this->exportdata_model->get_user_data($userid);
        $this->load->database();
        //$userid = 2;
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

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $randno = date('DMYhms');
        //echo $_SERVER['DOCUMENT_ROOT'];exit;
        $file = $this->config->item('doc_root') . 'uploads/exportdata/' . $result['0']['username'] . '_Licenses_' . $randno . '.xls';
        $objWriter->save($file);
        $email_message = "<html><body>";
        $email_message .= "<table>";
        $email_message .= "<tr><td><b>Warrantyist</b></td></tr>";
        $email_message .= "<tr><td>Hello " . $result['0']['username'] . "!" . "</td></tr>";
        $email_message .= "</table>";
        $email_message .= "</html></body>";
        $str_email_subject = "Document of  Warrantyist";
        $toemail = $result['0']['email'];
        $this->load->library('email');
        $this->email->from("noreply@warrantyist.com");
        $this->email->to($toemail);
        $this->email->subject($str_email_subject);
        $this->email->message($email_message);
        $this->email->attach($file);
        $this->email->send();
    }

    public function data_export_documents($userid) {

        $result = $this->exportdata_model->get_user_data($userid);
        $this->load->database();
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        //Set document properties
        $objPHPExcel->getProperties()->setCreator("Mehul")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

        $this->db->select('l.doc_id,l.doc_name,l.doc_number,l.start_date,l.expiry_date,l.notes');
        $this->db->from('document as l');
        $this->db->where('l.user_id', $userid);
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

        $objPHPExcel->getActiveSheet()->setTitle('Documents');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $randno = date('DMYhms');
        $file = $this->config->item('doc_root') . 'uploads/exportdata/' . $result['0']['username'] . '_Documents_' . $randno . '.xls';
        $objWriter->save($file);
        $email_message = "<html><body>";
        $email_message .= "<table>";
        $email_message .= "<tr><td><b>Warrantyist</b></td></tr>";
        $email_message .= "<tr><td>Hello " . $result['0']['username'] . "!" . "</td></tr>";
        $email_message .= "</table>";
        $email_message .= "</html></body>";
        $str_email_subject = "Document of  Warrantyist";
        $toemail = $result['0']['email'];
        $this->load->library('email');
        $this->email->from("noreply@warrantyist.com");
        $this->email->to($toemail);
        $this->email->subject($str_email_subject);
        $this->email->message($email_message);
        $this->email->attach($file);
        $this->email->send();
    }

    public function data_export_service_schedule($userid) {

        $result = $this->exportdata_model->get_user_data($userid);
        $this->load->database();
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        //Set document properties
        $objPHPExcel->getProperties()->setCreator("Mehul")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

        //$where="s.user_id IN (".$userid.")";
        $this->db->select('s.*,GROUP_CONCAT(DISTINCT dm.image) as images,GROUP_CONCAT(DISTINCT dm.id) as imgids,GROUP_CONCAT(DISTINCT sd.id) as dateids,GROUP_CONCAT(DISTINCT sd.service_date) as sdates');
        $this->db->from('services_shedule s');
        $this->db->join('services_dates sd', 's.service_id = sd.service_id', 'left');
        $this->db->join('document_image dm', 's.service_id = dm.service_id', 'left');
        $this->db->where('s.is_deleted', '1');
        $this->db->where('s.user_id IN (".$userid.")');
        $this->db->group_by('s.service_id');
        $this->db->order_by('s.service_id', 'desc');
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

        $objPHPExcel->getActiveSheet()->setTitle('Documents');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $randno = date('DMYhms');
        $file = $this->config->item('doc_root') . 'uploads/exportdata/' . $result['0']['username'] . '_ServicesScheduls_' . $randno . '.xls';
        $objWriter->save($file);
        $email_message = "<html><body>";
        $email_message .= "<table>";
        $email_message .= "<tr><td><b>Warrantyist</b></td></tr>";
        $email_message .= "<tr><td>Hello " . $result['0']['username'] . "!" . "</td></tr>";
        $email_message .= "</table>";
        $email_message .= "</html></body>";
        $str_email_subject = "Document of Warrantyist";
        $toemail = $result['0']['email'];
        $this->load->library('email');
        $this->email->from("noreply@warrantyist.com");
        $this->email->to($toemail);
        $this->email->subject($str_email_subject);
        $this->email->message($email_message);
        $this->email->attach($file);
        $this->email->send();
    }

    public function sendEmail($email, $subject, $message) {
        $this->load->library('email');
//        $config = Array(
//            'protocol' => 'smtp',
//            'smtp_host' => 'ssl://smtp.googlemail.com',
//            'smtp_port' => 465,
//            'smtp_user' => 'abc@gmail.com',
//            'smtp_pass' => 'passwrd',
//            'mailtype' => 'html',
//            'charset' => 'iso-8859-1',
//            'wordwrap' => TRUE
//        );
//
//
//        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('abec@lifeinurl.com');
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
        $path = $_SERVER["DOCUMENT_ROOT"];
        print_r($path);
        $file = $path . "/assets/img/logo.png";
        //$this->email->attach('C:\Users\Lenovo\Desktop\swapnil photo\10269182_795406320513005_1777113691300392365_o.jpg');
        $this->email->attach($file);
        if ($this->email->send()) {
            echo 'Email send.';
        } else {
            show_error($this->email->print_debugger());
        }
    }

}
