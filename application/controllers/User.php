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

        $post = $_POST;
        $username = $post['username'];
        $password = $post['password'];
        $room = $post['course'];
        $time = new DateTime();
        
        /* TODO: record login record in db */
        
        
        /* TODO: save username in cookies */
        /* TODO: set cookies timeout */
        $this->storeSession($username);
        
        redirect("Chat/$room");
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
    private function storeSession($name)
	{
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
