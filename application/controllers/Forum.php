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
	
    public function index($subject='')
    {
        // validation
        $this->checkLogin();
        $this->checkSubject($subject);
        
        $data['subject'] = $subject;
        
        $data['page'] = "Forum";
        $data['title'] = $subject . " - SB Admin";  // TODO: Page Title
        
        $this->load->view('view_includes/view_header', $data);
        $this->load->view('view_includes/view_sidebar');
        $this->load->view('view_forum/view_forum_header');
        $this->load->view('view_forum/view_forum_front');
        $this->load->view('view_chat/view_chat_panel');
        $this->load->view('view_forum/view_forum_footer');
    }
    
    private function checkSubject($s)
    {
        if($s=='' || $s === null) {
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
