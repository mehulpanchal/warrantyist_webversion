<?php

class Users_model extends CI_Model {

    /**
     * Validate the login's data with the database
     * @param string $user_name
     * @param string $password
     * @return void
     */
    function validate($user_name, $password) {
        $this->db->select('u.userid,u.username,u.email,u.profile_image, gu.role');
        $this->db->from('users as u');
        $this->db->join('group_users gu', 'u.userid = gu.user_id');
        $query = $this->db->where('u.email', $user_name);
        $query = $this->db->where('u.password', $password);
        $query = $this->db->where('u.is_active', 'active');
        $query = $this->db->where('gu.role !=', '4');  // this user shhould not deavtived
        $query = $this->db->get();
        If ($query->num_rows() > 0) {
            $userData = $query->result_array();
            $data = array(
                'username' => $userData['0']['username'],
                'userid' => $userData['0']['userid'],
                'email' => $userData['0']['email'],
                'role' => $userData['0']['role'],
                'profile_image' => $userData['0']['profile_image'],
                'is_logged_in' => true
            );

            $this->load->library('session');
            $this->session->set_userdata($data);
            //var_dump($this->session);
            //exit;
            return true;
            //exit;
        } else {
            return false;
        }
    }

    /**
     * Serialize the session data stored in the database, 
     * store it in a new array and return it to the controller 
     * @return array
     */
    function get_db_session_data() {
        $query = $this->db->select('user_data')->get('ci_sessions');
        $user = array(); /* array to store the user data we fetch */
        foreach ($query->result() as $row) {
            $udata = unserialize($row->user_data);
            /* put data in array using username as key */
            $user['user_name'] = $udata['user_name'];
            $user['is_logged_in'] = $udata['is_logged_in'];
        }
        return $user;
    }

    /**
     * Store the new user's data into the database
     * @return boolean - check the insert
     */
    function create_user($request) {
        $now = date("Y-m-d H m s");
        $this->db->select('userid');
        $this->db->from('users');
        $query = $this->db->where('email', trim($request->email));
        $query = $this->db->get();
        // print_r($query->result()); exit;
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            $data = array(
                'username' => trim($request->userName),
                'email' => trim($request->email),
                'password' => md5($request->password),
                'is_active' => 'active',
                'deactivate' => 'live',
                'created_date' => $now
            );
            $this->db->insert('users', $data);
            $insert_id = $this->db->insert_id();

            // create new group while registration
            $data = array(
                'user_id' => $insert_id,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('groups', $data);
            $group_id = $this->db->insert_id();

            //add new group user member to group_users
            $data = array(
                'group_id' => $group_id,
                'user_id' => $insert_id,
                'role' => '0',
                'role_changed_by' => $insert_id,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('group_users', $data);
            $group_users_id = $this->db->insert_id();


            // add user_account data
            $acdata = array(
                'userid' => $insert_id,
                'timezone' => $this->config->item('default_timezone'),
                'date_formate' => $this->config->item('default_dateformate'),
                'created_date' => $now,
                'ip' => $this->input->ip_address()
            );
            $this->db->insert('user_account', $acdata);
            $acinsert_id = $this->db->insert_id();
            //return userid from user table
            return $insert_id;
        }
    }

//create_member

    public function change_password_model($request) {
        $param = explode('|',base64_decode($request->paramsdata));
        $userid = $param[0]; // 0 userid
        $email = $param[1]; // 1 email
        $this->db->select('userid');
        $this->db->from('users');
        $query = $this->db->where('userid', $userid);
        $query = $this->db->get();
        //$userData = $query->row_array();
        if ($query->num_rows() > 0) {
            $data = array(
                'password' => md5(trim($request->password)),
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

}
