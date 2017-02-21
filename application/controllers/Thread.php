<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thread extends CI_Controller {

    public function _remap($method, $params = array())
	{
		if (method_exists($this, $method))
		{
			return call_user_func_array(array($this, $method), $params);
		}
		$this->index($method);
	}
	
    public function index($thread='')
    {
        // validation
        $this->checkLogin();
        $this->checkThread($thread);
        
        $data['thread'] = $thread;
        
        $data['page'] = "Thread";
        $data['title'] = "Thread " . $thread;  // TODO: Page Title
        
        $this->load->view('view_includes/view_header', $data);
        $this->load->view('view_includes/view_sidebar');
        $this->load->view('view_thread/view_thread_header');
        $this->load->view('view_thread/view_thread_front');
        $this->load->view('view_thread/view_thread_panel');
        $this->load->view('view_thread/view_thread_footer');
    }
    
    public function load($thread='')
    {
        // validation
        $this->checkThread($thread);
        
        // load model & get data
        $this->load->model('Thread_model');
        $out['row'] = $this->Thread_model->load_message($thread);
        
        // return
        $this->load->view('view_thread/view_thread_message',$out);
    }
    
    private function checkSubject($s)
    {
        if($s=='' || $s === null) {
            redirect();
        }
        
        return true;
    }
    
    private function checkThread($t)
    {
        if($t=='' || $t === null) {
            redirect();
        }
        
        return true;
    }
    
    private function checkLogin()
    {
        //check if logined already
        if(!$this->session->userdata('user_name')) {
            redirect();
        }
        
        return true;
    }

}
