<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    
    
    /**
     *  ============================================================
     *  Construtor
     *  ============================================================
     */
    function __construct()
	{
		parent::__construct();
	}
    
    
    
    /**
     *  ============================================================
     *
     *  Create New User
     *
     *  if $post NOT EXIST,
     *      go to form display
     *  elseif $post EXIST
     *      process data, pass to model
     *
     *  ============================================================
     */
    public function create()
    {
        $post = $_POST;
        
        if ($post == null) {
        
            $data['page'] = "User";
            $data['title'] = "Create Teacher Account";  // TODO: Page Title
            
            if ($this->session->flashdata('error') !== null)
                $data['error'] = $this->session->flashdata('error');
            
            $this->load->view('view_includes/view_header', $data);
            $this->load->view('view_includes/view_sidebar');
            $this->load->view('view_user_create/view_user_create_front');
            $this->load->view('view_user_create/view_user_create_footer');
            
        } else {
            
            // load model
            $this->load->model('User_model');
            
            // process data & send to model
            $data['u_name'] = $post['username'];
            $data['u_nick'] = $post['nickname'];
            $data['u_type'] = USER_TYPE_INSTRUCTOR;
            $data['u_pass'] = $post['password'];
            $result = $this->User_model->create_user($data);
            
            // return
            if ($result['message'] == 'Success') {
                
                // redirect to home
                $this->session->set_flashdata('target','Teacher');
                $this->session->set_flashdata('error','Account created successfully.');
                redirect("");
                
            } else {
                
                // redirect to form
                $this->session->set_flashdata('error',$result['message']);
                redirect("User/create");
                
            }
        }
    }
	
    
    
    /**
     *  ============================================================
     *
     *  Authentication
     *
     *  if user type == 11 (teacher):
     *      check username, password
     *
     *  All user type:
     *      log login name, class, time
     *
     *  ============================================================
     */
    public function login()
    {
        
        // load model
        $this->load->model('User_model');
        $this->load->model('Lecture_model');
        
        
        // process message
        $post = $_POST;
        $username = $post['username'];
        $password = $post['password'];
        $class = $post['course'];
        $type = $post['usertype'];
        $time = date(DATE_RFC3339);
        
        
        // validate teacher
        if ($type == USER_TYPE_INSTRUCTOR) {
            
            // check username, password
            $user = $this->User_model->validate_user($username, $password);
            
            // if NOT MATCH, redirect to home
            if ($user === FALSE) {
                $this->session->set_flashdata('error','Username or password incorrect.');
                redirect("");
            }
        
        }
        
        
        // log user action
        $log['u_id'] = $user;
        $log['u_name'] = $username;
        $log['class_id'] = $this->Lecture_model->get_lectid($class);
        $log['signin_time'] = $time;
        $id = $this->User_model->record_signin($log);
        
        
        /* TODO: save username in cookies */
        /* TODO: set cookies timeout */
        $this->storeSession($id,$type,$username);
        
        // redirect
        if ($type == USER_TYPE_INSTRUCTOR) {
            // teacher
            redirect("Dashboard");
        } elseif ($type == USER_TYPE_STUDENT) {
            // student
            redirect("Chat/$class");
        }
    }
    
    
    
    /**
     *  ============================================================
     *  Logout
     *  ============================================================
     */
    public function logout()
	{
		$this->unsetSession();
        redirect();
	}
    
    
    
    /**
     *  ============================================================
     *  
     *  Store user info in session data
     *  
     *  @param  $name   [str]   username
     *  @return
     *  
     *  ============================================================
     **/
    private function storeSession($id,$type,$name)
	{
		$this->session->set_userdata('user_id',$id);
		$this->session->set_userdata('user_type',$type);
		$this->session->set_userdata('user_name',$name);
	}
    
    
    
    /**
     *  ============================================================
     *  
     *  Remove user info in session data
     *
     *  @param  $name   [str]   username
     *  @return
     *  
     *  ============================================================
     **/
    private function unsetSession()
	{
		$this->session->unset_userdata('user_name');
	}
}
