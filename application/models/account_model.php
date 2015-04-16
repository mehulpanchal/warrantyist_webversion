<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Account_model extends CI_Model {

    public function edit_profile() {
        $userid = $this->session->userdata('userid');
        $this->db->select('email, username, profile_image, firstname, lastname, modified_date,deactivate');
        $this->db->from('users');
        $query = $this->db->where('userid', $userid);
        $query = $this->db->where('is_active', 'active');
        $query = $this->db->get();
        $userData = $query->row_array();
        return $userData;
    }

    public function get_user_role_for_edit() {
        $userid = $this->input->post('user_id');
        $this->db->select('group_id, role, user_id');
        $this->db->from('group_users');
        $query = $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $userData = $query->row_array();
        return $userData;
    }

    public function get_account_details_model() {
        $userid = $this->session->userdata('userid');
        $this->db->select('u.userid, u.username, ua.timezone, ua.account_name as accountname, ua.date_formate as dateformate, ua.type_of_company as typeofcompany,
                 ua.peoples_in_company as peoplesincompany, ua.how_old_company as howoldcompany, cmp_contact_name as contactpersonname, cmp_name as companyname, cmp_website as companywebsite,
                 cmp_address as companyaddress, cmp_email as companyemail');
        $this->db->from('users u');
        $this->db->join('user_account ua', 'u.userid = ua.userid');
        $this->db->where('ua.userid', $userid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_devices_for_manage_model() {
        $userid = $this->session->userdata('userid');
        $this->db->select('id,device_id,device_name,device_os,last_login_date,status');
        $this->db->from('user_devices');
        $query = $this->db->where('user_id', $userid);
        //$query = $this->db->where('status', '1');
        $query = $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function change_profile_image($image) {
        $userid = $this->session->userdata('userid');
        $data = array(
            'profile_image' => $image,
            'modified_date' => date("Y-m-d H:i:s")
        );
        $this->db->trans_start();
        $this->db->where('userid', $userid);
        $this->db->update('users', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function change_basic_info_model($request) {
        $userid = $this->session->userdata('userid');
        $data = array(
            'firstname' => trim($request->firstname),
            'lastname' => trim($request->lastname),
            'email' => trim($request->email),
            'username' => trim($request->username),
            'modified_date' => date("Y-m-d H:i:s")
        );
        $this->db->trans_start();
        $this->db->where('userid', $userid);
        $this->db->update('users', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function change_password_model($request) {
        $userid = $this->session->userdata('userid');
        $this->db->select('userid');
        $this->db->from('users');
        $query = $this->db->where('userid', $userid);
        $query = $this->db->where('password', md5(trim($request->password)));
        $query = $this->db->get();
        //$userData = $query->row_array();
        if ($query->num_rows() > 0) {
            $data = array(
                'password' => md5(trim($request->newpassword)),
                'modified_date' => date("Y-m-d H:i:s")
            );
            $this->db->trans_start();
            $this->db->where('userid', $userid);
            $this->db->update('users', $data);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            $data = array();
            return $data['status'] = 'fail';
        }
    }

    public function change_notification_info_model($request) {
        $userid = $this->session->userdata('userid');
        $data = array(
            'security_notification' => trim($request->security_notification),
            'login_notification' => trim($request->login_notification),
            'modified_date' => date("Y-m-d H:i:s")
        );
        $this->db->trans_start();
        $this->db->where('userid', $userid);
        $this->db->update('users', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function change_account_details_model($request) {
        $userid = $this->session->userdata('userid');
        if ($request->action == 'contactinfo') {
            // below variables for company detail
            $data = array(
                'cmp_contact_name' => trim($request->contactpersonname),
                'cmp_name' => trim($request->companyname),
                'cmp_website' => trim($request->companywebsite),
                'cmp_address' => $request->companyaddress,
                'cmp_email' => trim($request->companyemail),
                'modified_date' => date("Y-m-d H:i:s"),
                'ip' => $this->input->ip_address()
            );
        } else {
            $data = array(
                'account_name' => trim($request->accountname),
                'timezone' => trim($request->timezone),
                'date_formate' => trim($request->dateformate),
                'type_of_company' => trim($request->typeofcompany),
                'peoples_in_company' => trim($request->peoplesincompany),
                'how_old_company' => trim($request->howoldcompany),
                'modified_date' => date("Y-m-d H:i:s"),
                'ip' => $this->input->ip_address()
            );
        }
        $this->db->trans_start();
        $this->db->where('userid', $userid);
        $this->db->update('user_account', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function change_device_to_forget_model($request) {
        $userid = $this->session->userdata('userid');
        $data = array(
            'status' => '0'
        );
        $this->db->trans_start();
        $this->db->where('id', $request->forgetid);
        $this->db->where('user_id', $userid);
        $this->db->update('user_devices', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function change_device_to_unforget_model($request) {
        $userid = $this->session->userdata('userid');
        $data = array(
            'status' => '1'
        );
        $this->db->trans_start();
        $this->db->where('id', $request->forgetid);
        $this->db->where('user_id', $userid);
        $this->db->update('user_devices', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function change_deactivated_account_model($request) {
        $userid = $this->session->userdata('userid');
        $data = array(
            'deactivate' => $request->checkflag,
            'modified_date' => date("Y-m-d H:i:s")
        );
        $this->db->trans_start();
        $this->db->where('userid', $userid);
        $this->db->update('users', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
