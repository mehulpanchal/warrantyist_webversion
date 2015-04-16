<?php

// Mehul 2415
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates  
 * and open the template in the editor.   
 */

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('account_model');
        $this->load->library('upload');
        //permission settings
        $this->load->library(array('session', 'permisson'));
        $data = array('uid' => $this->session->userdata('userid'), 'roles' => array($this->session->userdata('role')));
        $this->session->set_userdata($data);
        //if user not logged in then redirect to login page
        if (!$this->session->userdata('is_logged_in')) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            redirect('login');
        }
    }

    public function main() {
        $this->load->view('profile/main');
    }

    public function change_profile() {
        if ($this->permisson->has_permission('profile', array('change_profile'), 1)) {
            $this->load->view('profile/change_profile');
        } else {
            $this->load->view('acs_msg');
        }
    }

    public function manage_account() {
        if ($this->permisson->has_permission('profile', array('manage_account'), 1)) {
            $this->load->helper('warranty');
            $gmtdata['gmt'] = generate_timezone_list();
            $this->load->view('profile/manage_account', $gmtdata);
        } else {
            $this->load->view('acs_msg');
        }
    }

    public function contact_information() {
        if ($this->permisson->has_permission('profile', array('contact_information'), 1)) {
            $this->load->view('profile/contact_information');
        } else {
            $this->load->view('acs_msg');
        }
    }

    public function user_management() {
        if ($this->permisson->has_permission('profile', array('user_management'), 1)) {
            $this->load->view('profile/user_management');
        } else {
            $this->load->view('acs_msg');
        }
    }

    public function manage_devices() {
        if ($this->permisson->has_permission('profile', array('manage_devices'), 1)) {
            $this->load->view('profile/device_management');
        } else {
            $this->load->view('acs_msg');
        }
    }

    public function export_data() {
        if ($this->permisson->has_permission('profile', array('export_data'), 1)) {
            $this->load->view('profile/export_data');
        } else {
            $this->load->view('acs_msg');
        }
    }

    public function deactivate_account() {
        if ($this->permisson->has_permission('profile', array('deactivate_account'), 1)) {
            $this->load->view('profile/deactivate_account');
        } else {
            $this->load->view('acs_msg');
        }
    }

    public function get_invite_user_form() {
        $this->load->view('profile/invite_user');
    }

    public function get_access_role_edit_form() {
        $this->load->view('profile/access_role_edit');
    }

    public function get_user_role_for_update() {
        $data = array();
        $data['active'] = $this->account_model->get_user_role_for_edit();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function change_profile_image() {
        if (!empty($_FILES)) {
            $filename = md5($this->session->userdata('userid')) . '.png';
            $uploadPath = 'uploads' . DIRECTORY_SEPARATOR . 'profile_images' . DIRECTORY_SEPARATOR . $filename;
            $fullpath = base_url() . 'uploads/profile_images/' . $filename;
            $config['upload_path'] = './uploads/profile_images/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '600';
            $config['file_name'] = $filename;
            $config['max_width'] = '360';
            $config['overwrite'] = true;
            $config['max_height'] = '360';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file')) {
                $error = array('error' => $this->upload->display_errors());
                $answer = array('answer' => 'File to transfer', 'error' => $error);
                $this->output->set_content_type('application/json')->set_output(json_encode($answer));
            } else {
                $data = array('upload_data' => $this->upload->data());
                if ($this->account_model->change_profile_image($fullpath) == TRUE) {
                    $answer = array('answer' => 'File transfer completed', 'filename' => $fullpath, $data);
                }
                $this->output->set_content_type('application/json')->set_output(json_encode($answer));
            }
        } else {
            $answer = array('fail' => 'No Files Selected');
            $this->output->set_content_type('application/json')->set_output(json_encode($answer));
        }
    }

    public function get_user_profile_data() {
        $data = array();
        $data['active'] = $this->account_model->edit_profile();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function get_user_for_manage_view() {
        $data = array();
        $this->load->model('invite_user_model');
        //Need to check if given user_id is of super admin's or not. So we can get group id and find the group users
        $group_data = $this->invite_user_model->get_group_data_by_user_id();
        $group_users_data = array();
        // var_dump($group_data);
        if (!empty($group_data)) {
            $group_users_data = $this->invite_user_model->get_group_users_data_by_group_id($group_data['group_id']);
            //echo $this->session->userdata('userid').'=<pre>'.$group_data['group_id'];            print_r($group_users_data); exit;
        } else {
            $group_users_data = $this->invite_user_model->get_group_users_data_by_user_id();
        }
        if (!empty($group_users_data)) {
            $data['active'] = TRUE;
            $data['users_data'] = $group_users_data;
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $data['active'] = FALSE;
            $data['users_data'] = "Sorry! No Data Found.";
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    public function get_account_details_view() {
        $data = array();
        $data['active'] = $this->account_model->get_account_details_model();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function get_devicesformanage_view() {
        $data = array();
        $data['alldevices'] = $this->account_model->get_devices_for_manage_model();
        if (!empty($data['alldevices'])) {
            $data['active'] = TRUE;
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $datafalse['active'] = FALSE;
            $this->output->set_content_type('application/json')->set_output(json_encode($datafalse));
        }
    }

    public function get_group_users_view() {
        $this->load->model('invite_user_model');
        $group_users_data = $this->invite_user_model->get_userrole_data_by_user_id();
        if (!empty($group_users_data)) {
            $data['users_data'] = $group_users_data;
            $data['status'] = 1;
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $data = array('message' => 'Sorry, no data found.', 'status' => 0);
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    public function change_basic_info() {
        if ($postdata = file_get_contents("php://input")) {
            $request = json_decode($postdata);
            $data = array();
            $data['status'] = $this->account_model->change_basic_info_model($request);
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    public function change_password() {
        if ($postdata = file_get_contents("php://input")) {
            $request = json_decode($postdata);
            $data = array();
            $data_edit_save = $this->account_model->change_password_model($request);
            if ($data_edit_save['status'] != 'fail') {
                $data['status'] = 'updated';
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            } else {
                $data['status'] = 'password not matched';
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
        }
    }

    public function change_notifications() {
        if ($postdata = file_get_contents("php://input")) {
            $request = json_decode($postdata);
            $data = array();
            $data['status'] = $this->account_model->change_notification_info_model($request);
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    public function change_account_details() {
        if ($postdata = file_get_contents("php://input")) {
            $request = json_decode($postdata);
            $data['status'] = $this->account_model->change_account_details_model($request);
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    public function send_invitation_to_user() {
        if ($postdata = file_get_contents("php://input")) {
            $this->load->model('invite_user_model');
            $request = json_decode($postdata);
//            echo '<pre>'; print_r($request); exit;
            $user = $this->invite_user_model->get_user_data_by_email_id($request);

            if (empty($user)) {
                $this->load->helper('warranty');
                $generatedPassword = generate_strong_password();
                $new_user_id = $this->invite_user_model->add_new_invited_user($request, $generatedPassword);
                $group_info = $this->invite_user_model->get_group_by_user_id();

                $group_id = null;

                if (empty($group_info)) {
                    $group_id = $this->invite_user_model->add_new_group();
                } else {
                    $group_id = $this->invite_user_model->get_group_id_by_userid();
                }

                //We need to check if user is already invited.
                $group_users = $this->invite_user_model->get_group_user_by_group_id_user_id($group_id, $new_user_id);

                if (empty($group_users)) {
                    //While adding new user, keep role changed by as admin user's id 
                    $group_users_id = $this->invite_user_model->add_new_group_user($group_id, $new_user_id, $request->role);

                    //Code to send notification to invited user
                    $new_user = $this->invite_user_model->get_user_data_by_email_id($request);

                    $admin_user = $this->invite_user_model->get_user_data_by_user_id();
                    $email_message = "<html><body>";
                    $email_message .= "<table>";
                    $email_message .= "<tr><td><p>Hello " . ucfirst($new_user['0']['username']) . "!" . "</p></td></tr>";
                    $email_message .= "<tr><td><p><b>" . ucfirst($admin_user['0']['username']) . "</b> has invited to you to use warranyist app.</p>
                    <p>To use warrantyist app, download it from following link.</p><p>For login, use following credentials:</p><p>Username: <strong>" . $new_user['0']['email'] . "</strong></p><p>Password: <strong>" . $generatedPassword . "</strong></p></td></tr>";
                    $email_message .= "</table>";
                    $email_message .= "</html></body>";
                    $email_subject = "Invitation to use warrantyist app";
                    $to_email = $new_user['0']['email'];

                    $this->load->library('email');
                    $this->email->from("noreply@warrantyist.com", "noreply - Warrantyist");
                    $this->email->to($to_email);
                    $this->email->subject($email_subject);
                    $this->email->message($email_message);
                    if ($this->email->send()) {
                        $data = array('message' => 'User invited Succesfully', 'status' => TRUE, 'userid' => $new_user_id);
                        $this->output->set_content_type('application/json')->set_output(json_encode($data));
                    } else {
                        $data = array('message' => 'Sorry... Email could not be sent', 'status' => FALSE);
                        $this->output->set_content_type('application/json')->set_output(json_encode($data));
                    }
                } else {
                    $data = array('message' => 'User already has been invited', 'status' => FALSE);
                    $this->output->set_content_type('application/json')->set_output(json_encode($data));
                }
            } else {
                //User is already in our database, so we can't send invitation
                $data = array('message' => 'You can\'t add this user.', 'status' => FALSE);
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
        }
    }

    public function change_user_access_role() {
        if ($postdata = file_get_contents("php://input")) {
            $this->load->model('invite_user_model');
            $request = json_decode($postdata);
            $response = $this->invite_user_model->update_user_role($request);
            if ($response != FALSE) {
                $data['staus'] = TRUE;
                $data['message'] = 'User Access Role Updated Successfully.';
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            } else {
                $data['staus'] = FALSE;
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
        }
    }

    public function change_deviceto_forget() {
        if ($postdata = file_get_contents("php://input")) {
            $request = json_decode($postdata);
            $data['status'] = $this->account_model->change_device_to_forget_model($request);
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    public function change_deviceto_unforget() {
        if ($postdata = file_get_contents("php://input")) {
            $request = json_decode($postdata);
            $data['status'] = $this->account_model->change_device_to_unforget_model($request);
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    public function change_deactivated_account() {
        if ($postdata = file_get_contents("php://input")) {
            $request = json_decode($postdata);
            $data['status'] = $this->account_model->change_deactivated_account_model($request);
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

}
