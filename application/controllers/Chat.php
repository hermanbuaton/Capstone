<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
    
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
        $this->checkSubject($subject);
        $this->checkLogin();
        
        $data['subject'] = $subject;
        
        $data['page'] = "Chat";
        $data['title'] = $room . " - SB Admin";
        
        $this->load->view('view_includes/view_header', $data);
        $this->load->view('view_includes/view_sidebar');
        $this->load->view('view_chat/view_chat_front');
        $this->load->view('view_chat/view_chat_footer');
    }
    
    public function message()
    {
        $post = $_POST;
        
        // process message
        $m = $post['chat-message-body'];
        
        // return
        echo $m;
    }
    
    public function msg()
    {
        $arr = "12312123312";
        var_dump($arr);
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
