<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
    
    
    
    /**
     *  ============================================================
     *  remap
     *  ============================================================
     */
    public function _remap($method, $params = array())
	{
		if (method_exists($this, $method))
		{
			return call_user_func_array(array($this, $method), $params);
		}
		$this->index($method);
	}
	
    
    
    /**
     *  ============================================================
     *  Index:
     *      check if user already login
     *      load dashboard
     *  ============================================================
     */
    public function index()
    {
        // validation
        $this->checkLogin();
        
        $data['page'] = "Dashboard";
        $data['title'] = "Dashboard";  // TODO: Page Title
        
        $this->load->view('view_includes/view_header', $data);
        $this->load->view('view_includes/view_sidebar');
        $this->load->view('view_chat/view_dashboard_header');
        $this->load->view('view_chat/view_dashboard_front');
        $this->load->view('view_chat/view_dashboard_panel');
        $this->load->view('view_chat/view_dashboard_footer');
        
        return;
    }
    
    
    
    /**
     *  ============================================================
     *  Load list of classes
     *  ============================================================
     */
    public function load($subject='')
    {
        // validation
        $this->checkSubject($subject);
        
        // load model & get data
        $this->load->model('Thread_model');
        $out['row'] = $this->Thread_model->load_thread($subject);
        
        // return
        $this->load->view('view_chat/view_chat_message',$out);
    }
    
    
    
    /**
     *  ============================================================
     *  Check if user already login
     *  ============================================================
     */
    private function checkLogin()
    {
        // check if logined already
        if(!$this->session->userdata('user_name')) {
            redirect();
        }
        
        return true;
    }
    
    
    
    /**
     *  ============================================================
     *  Get user ID
     *  ============================================================
     */
    private function getUserID()
    {
        return $this->session->userdata('user_id');
    }
    
    
    
    /**
     *  ============================================================
     *  Generate time string
     *  ============================================================
     */
    private function getTimeString()
    {
        return date(DATE_RFC3339);
    }

    
    
}