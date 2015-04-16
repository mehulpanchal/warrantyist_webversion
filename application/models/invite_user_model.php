<?php

class Invite_user_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
//        date_default_timezone_set('Asia/Kolkata');
    }

    public function get_user_data_by_email_id($request) {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('email', $request->email);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_new_invited_user($request, $generatedPassword) {
        $username = $request->name;
        $email = $request->email;
        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => md5($generatedPassword),
            'is_invited' => true,
            'created_date' => date('Y-m-d H:i:s')
        );

        $this->db->insert('users', $data);

        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function get_group_by_user_id() {

        $this->db->select();
        $this->db->from('groups');
        $this->db->where('user_id', $this->session->userdata('userid'));


        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_new_group() {


        $data = array(
            'user_id' => $this->session->userdata('userid'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('groups', $data);

        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function get_group_id_by_userid() {
        $this->db->select('group_id');
        $this->db->from('groups');
        $this->db->where('user_id', $this->session->userdata('userid'));

        $query = $this->db->get();

        $result = $query->result_array();
        return $result[0]['group_id'];
    }

    public function add_new_group_user($group_id, $new_user_id, $role) {
        $data = array(
            'group_id' => $group_id,
            'user_id' => $new_user_id,
            'role' => $role,
            'role_changed_by' => $this->session->userdata('userid'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('group_users', $data);

        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function get_group_user_by_group_id_user_id($group_id, $new_user_id) {
        $this->db->select();
        $this->db->from('group_users');
        $this->db->where('group_id', $group_id);
        $this->db->where('user_id', $new_user_id);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_group_users_data_by_user_id() {
        $user_id = $this->session->userdata('userid');
        $sql = "SELECT u.userid, u.username,u.firstname,u.lastname, u.email, gu.role, u.created_date FROM users u 
                JOIN group_users gu ON u.userid = gu.user_id 
                    WHERE gu.group_id = (SELECT group_id FROM group_users WHERE user_id = " . $user_id . " ) Order by u.created_date desc";
//                    WHERE gu.group_id = (SELECT group_id FROM group_users WHERE user_id = ". $user_id . " ) and u.userid <> ". $user_id;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_user_data_by_user_id() {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('userid', $this->session->userdata('userid'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_group_data_by_user_id() {
        $this->db->select();
        $this->db->from('groups');
        $this->db->where('user_id', $this->session->userdata('userid'));
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_group_users_data_by_group_id($group_id) {
        $this->db->select('u.userid, u.username,u.firstname,u.lastname, u.email, gu.role ');
        $this->db->select_max('ud.last_login_date');
        $this->db->from('users u');
        $this->db->join('group_users gu', 'u.userid = gu.user_id');
        $this->db->join('user_devices ud', 'u.userid = ud.user_id', 'left');
        $this->db->where('gu.group_id', $group_id);
        $this->db->group_by('u.userid');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_userrole_data_by_user_id() {
        $user_id = $this->session->userdata('userid');
        $sql = "SELECT u.userid, u.username, u.email,u.created_date,u.security_notification,u.login_notification, gu.role
                    FROM users u JOIN group_users gu 
                        ON u.userid = gu.user_id 
                            WHERE gu.user_id = " . $user_id . " Order By u.created_date desc";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function update_user_role($request) {
        
        $data = array(
            'role' => $request->role,
            'role_changed_by' => $this->session->userdata('userid'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->trans_start();
        $this->db->where('user_id', $request->user_id);
        $this->db->update('group_users', $data);
        $this->db->trans_complete();

        // was there any update or error?
        if ($this->db->affected_rows() == '1') {
            return true;
        } else {
            // any trans error?
            if ($this->db->trans_status() === FALSE) {
                return false;
            } else {
                return true;
            }
        }
    }

}
