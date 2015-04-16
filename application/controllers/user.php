
<?php

class User extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not, 
     * send him to the login page
     * @return void
     */
    function index() {

        if ($this->session->userdata('is_logged_in')) {
            redirect('/dashboard');
        } else {
            $this->load->view('user/login');
        }
    }

    /**
     * encript the password 
     * @return mixed
     */
    function __encrip_password($password) {
        return md5($password);
    }

    /**
     * check the username and the password with the database
     * @return void
     */
    function validate_credentials() {

        $this->load->model('Users_model');
        $postdata = file_get_contents("php://input");
        $user_data = json_decode($postdata);
        $password = $this->__encrip_password($user_data->password);
        $is_valid = $this->Users_model->validate($user_data->email, $password);

        if ($is_valid) {
            $data['check'] = 'success';
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        } else { // incorrect username or password
            $data['check'] = 'fail';
            $data['message_error'] = TRUE;
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
            //$this->load->view('admin/login', $data);
        }
    }

    /**
     * The method just loads the signup view
     * @return void
     */
    public function signup() {
        if ($postdata = file_get_contents("php://input")) {

            $this->load->model('Users_model');
            $request = json_decode($postdata);
            $result = $this->Users_model->create_user($request);
            if ($result != FALSE) {
                $data['check'] = 'success';
                $data['id'] = $result;
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            } else {
                $data['check'] = 'fail';
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
        } else {
            $this->load->view('user/signup');
        }
    }

    /**
     * Destroy the session, and logout the user.
     * @return void
     */
    function logout() {
        $this->session->sess_destroy();
        redirect('/');
    }

    function thankyou() {
        $this->load->view('user/signup_successful');
    }

    function forgot_password() {
        $this->load->view('user/forgot_password');
    }

    function reset_key() {
//        $params['params']  = explode('|',base64_decode($this->uri->segment(2)));
        $params['params'] = $this->uri->segment(2);
//        var_dump($params);        exit;

        $this->load->view('user/reset_password_form', $params);
    }

    public function user_password_update() {
        if ($postdata = file_get_contents("php://input")) {
            $this->load->model('Users_model');
            $request = json_decode($postdata);
            $data = array();
            if ($request->password == $request->cpassword) {
                $data_edit_save = $this->Users_model->change_password_model($request);
                if ($data_edit_save['status'] != 'fail') {
                    $data['status'] = TRUE;
                    $data['message'] = 'Your New Password Applyed to Warrantyist.';
                    $this->output->set_content_type('application/json')->set_output(json_encode($data));
                }
            } else {
                $data['status'] = FALSE;
                $data['message'] = 'Your Confirm Password Not Matched.';
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
        }
    }

    function send_resetlink_to_user() {
        if ($postdata = file_get_contents("php://input")) {
            $request = json_decode($postdata);
            $this->load->model('invite_user_model');
            $user = $this->invite_user_model->get_user_data_by_email_id($request);
//            var_dump($user);
//            exit;
            if (!empty($user)) {
                $sendparams = base64_encode($user['0']['userid'] . '|' . $user['0']['email']);
                $email_message = "<html><body>";
                $email_message .= "<table>";
                $email_message .= "<tr><td><p>Hello " . ucfirst($user['0']['username']) . "!" . "</p></td></tr>";
                $email_message .= "<tr><td>
                    <p>To reset your password in  warrantyist, please click on following link.</p>
                    <p><strong><a href='" . base_url() . "resetmykey/" . $sendparams . "' > Reset Your Password </a></strong></p>
                        </td></tr>";
                $email_message .= "</table>";
                $email_message .= "</html></body>";
                $email_subject = "Reset Your Password in Warrantyist";
                $to_email = $user['0']['email'];

                $this->load->library('email');
                $this->email->from("noreply@warrantyist.com", "noreply - Warrantyist");
                $this->email->to($to_email);
                $this->email->subject($email_subject);
                $this->email->message($email_message);
                if ($this->email->send()) {
                    $data = array('message' => 'Reset Password Succesfully Sent to your email', 'status' => TRUE, 'userid' => $user['0']['userid']);
                    $this->output->set_content_type('application/json')->set_output(json_encode($data));
                } else {
                    $data = array('message' => 'Sorry... Email could not be sent', 'status' => FALSE);
                    $this->output->set_content_type('application/json')->set_output(json_encode($data));
                }
            } else {
                //User is already in our database, so we can't send invitation
                $data = array('message' => 'Sorry! Invalid Email Provided By you', 'status' => FALSE);
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
        }
    }

}
