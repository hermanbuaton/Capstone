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
        $this->checkLogin();
        $this->checkSubject($subject);
        
        $data['subject'] = $subject;
        
        $data['page'] = "Chat";
        $data['title'] = $subject . " - SB Admin";  // TODO: Page Title
        
        $this->load->view('view_includes/view_header', $data);
        $this->load->view('view_includes/view_sidebar');
        $this->load->view('view_chat/view_chat_front');
        $this->load->view('view_chat/view_chat_footer');
    }
    
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
    
    public function message()
    {
        // load model
        $this->load->model('Thread_model');
        
        // process message
        $post = $_POST;
        $data['class_id'] = $post['chat-message-class'];
        $data['lect_id'] = $post['chat-message-lect'];
        $data['m_type'] = 0;
        $data['u_id'] = $this->getUserID();
        $data['u_show'] = $post['chat-message-anonymous'];
        $data['m_time'] = $this->getTimeString();
        $data['m_head'] = $post['chat-message-head'];
        $data['m_body'] = $post['chat-message-body'];
        
        // send to MODEL
        // on return put data into $out
        $out['row'] = $this->Thread_model->insert_thread($data);
        
        // return
        $this->load->view('view_chat/view_chat_message',$out);
    }
    
    public function vote()
    {
        // load model
        $this->load->model('Thread_model');
        
        // process vote
        $post = $_POST;
        $data['m_id'] = $post['vote-message'];
        $data['vote'] = $post['vote-value'];
        $data['v_time'] = $this->getTimeString();
        
        // send to MODEL
        $this->Thread_model->insert_vote($data);
        
        // return
        $out['m'] = $data['m_id'];
        $out['v'] = $data['vote'];
        echo json_encode($out);
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
    
    private function getUserID()
    {
        return $this->session->userdata('user_id');
    }
    
    private function getTimeString()
    {
        return date(DATE_RFC3339);
    }

}
