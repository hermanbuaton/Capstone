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
        // load model
        $this->load->model('Thread_model');
        
        // process message
        $post = $_POST;
        $data['class_id'] = $post['chat-message-class'];
        $data['lect_id'] = $post['chat-message-lect'];
        $data['m_type'] = 0;
        $data['u_id'] = $this->session->userdata('user_id');
        $data['u_show'] = $post['chat-message-anonymous'];
        $data['m_time'] = date(DATE_RFC3339);
        $data['m_head'] = $post['chat-message-head'];
        $data['m_body'] = $post['chat-message-body'];
        
        // send to MODEL
        $id = $this->Thread_model->insert_thread($data);
        
        // return
        echo json_encode($id);
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
