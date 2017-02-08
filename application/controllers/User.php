<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct()
	{
		parent::__construct();
        
        $this->load->helper('cookie');

        /*
		$this->load->model('User_model');
        */
	}
	
    public function login()
    {

        // load model
        $this->load->model('User_model');
        
        // process message
        $post = $_POST;
        $username = $post['username'];
        $password = $post['password'];
        $class = $post['course'];
        $time = date(DATE_RFC3339);
        
        // send to model
        $data['u_name'] = $username;
        $data['class_id'] = $class;
        $data['signin_time'] = $time;
        // $id = $this->User_model->record_signin($data);
        
        echo "1";
        
        /* TODO: save username in cookies */
        /* TODO: set cookies timeout */
        $this->storeSession($id,$username);
        
        echo "1";
        
        redirect("Chat/$class");
    }
    
    public function logout()
	{
		$this->unsetSession();
        
		redirect();
	}
    
    /**
     *  Store user info in session data
     *  @param  $name   [str]   username
     *  @return
     **/
    private function storeSession($id,$name)
	{
		$this->session->set_userdata('user_id',$id);
		$this->session->set_userdata('user_name',$name);
	}
    
    /**
     *  Remove user info in session data
     *  @param  $name   [str]   username
     *  @return
     **/
    private function unsetSession()
	{
		$this->session->unset_userdata('user_name');
	}
}
