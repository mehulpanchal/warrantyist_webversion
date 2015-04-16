
<?php

class Exportdata_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

     function get_amc()
    {                 
        $userid =82;   
        $this->db->select('a.*');
        $this->db->select('DATE_ADD(a.amc_start_date , INTERVAL a.duration MONTH) as amc_expiry_date',false);      
        $this->db->select('case when NOW() > DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) then "E"  when DATE_ADD(NOW(),INTERVAL 30 DAY) > DATE_ADD(a.amc_start_date, INTERVAL a.duration MONTH) then "EX" ELSE "A" END AS status',false);      
        $this->db->from('amc_details a');
        $this->db->where('userid',$userid);
        $this->db->where('is_deleted','1');
        $this->db->order_by('a.amc_id','desc');
        $query=$this->db->get();                  
        $amcs=$query->result_array();
        return $amcs;        
    }
    
    
    function get_user_data($userid)
    {          
        $this->db->select('u.username,u.email');
        $this->db->from('users AS u');
         $this->db->where('userid',$userid);
        $query = $this->db->get();
        return $query->result_array();   
    }
    

//    function getall_amc() {
//        $userid = $this->input->post('userid');
//        $type_val = $this->input->post('data_type');
//
//        $this->db->select('email,username');
//        $this->db->from('users');
//        $query = $this->db->where('userid', $userid);
//        $query = $this->db->get();
//        $users = $query->result_array();
//        If ($query->num_rows() > 0) {
//            $array = explode(',', $type_val);
//            $typearray = array();
//            foreach ($array as $value) {
//                $typearray[$value] = $value;
//            }
//            if (isset($typearray['all']) == "all") {
//                //$alldata = $this->exportdata_model->getall_amc();
//                //print_r($alldata);exit;
//                //echo "sgsg";exit;
//
//                $email_message = "<html><body>";
//                $email_message .= "<table>";
//                $email_message .= "<tr><td><b>GRADSPAD</b></td></tr>";
//                $email_message .= "<tr><td>Hello " . $users['0']['username'] . "!" . "</td></tr>";
//                $email_message .= "<tr><td><p>Someone (probably you) has requested a new password for your account on GRADSPAD</p><p><b>fhshfhhshsh</b></p></td></tr>";
//                $email_message .= "</table>";
//                $email_message .= "</html></body>";
//                $str_email_subject = "Password Recovery from GRADSPAD";
//                $toemail = $users['0']['email'];
//                $this->load->library('email');
//                $this->email->from("abec@lifeinurl.com");
//                $this->email->to($toemail);
//                $this->email->subject($str_email_subject);
//                $this->email->message($email_message);
//                $this->email->attach('C:/Users/Lenovo/Desktop/swapnil photo/10269182_795406320513005_1777113691300392365_o.jpg');
//                $this->email->send();
//                return "P";
//            }
//        } else {
//            return "N";
//        }
//    }

    public function setemail() {
        $email = "xyz@gmail.com";
        $subject = "some text";
        $message = "some text";
        $this->sendEmail($email, $subject, $message);
    }

    public function sendEmail($email, $subject, $message) {

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'abc@gmail.com',
            'smtp_pass' => 'passwrd',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );


        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('abc@gmail.com');
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->attach('C:\Users\xyz\Desktop\images\abc.png');
        if ($this->email->send()) {
            echo 'Email send.';
        } else {
            show_error($this->email->print_debugger());
        }
    }

}
