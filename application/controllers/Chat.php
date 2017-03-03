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
        $this->load->view('view_chat/view_chat_header');
        $this->load->view('view_chat/view_chat_front');
        $this->load->view('view_chat/view_chat_panel');
        $this->load->view('view_chat/view_chat_poll_create');
        $this->load->view('view_chat/view_chat_poll_vote');
        $this->load->view('view_chat/view_chat_modal');
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
        $thread['class_id'] = $post['input-message-class'];
        $thread['lect_id'] = $post['input-message-lect'];
        $thread['m_type'] = 0;
        $thread['u_id'] = $this->getUserID();
        $thread['u_show'] = $post['input-message-anonymous'];
        $thread['m_time'] = $this->getTimeString();
        $thread['m_head'] = $post['input-message-head'];
        $thread['m_body'] = $post['input-message-body'];
        
        // send to MODEL
        // on return put data into $out
        $message = $this->Thread_model->insert_thread($thread);
        $row = $this->Thread_model->insert_message($message);
        $out['row'] = array($row);
        
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
        $data['u_id'] = $this->getUserID();
        $data['vote'] = $post['vote-value'];
        $data['v_time'] = $this->getTimeString();
        
        // TODO: get user data
        
        // send to MODEL
        $this->Thread_model->insert_vote($data);
        
        // return
        $out['m'] = $data['m_id'];
        $out['v'] = $data['vote'];
        echo json_encode($out);
    }
    
    public function poll_create()
    {
        // load model
        $this->load->model('Thread_model');
        $this->load->model('Poll_model');
        
        // process message
        $post = $_POST;
        
        
        // insert thread
        $thread['class_id'] = $post['input-message-class'];
        $thread['lect_id'] = $post['input-message-lect'];
        $message = $this->Thread_model->insert_thread($thread);
        
        
        // insert message
        $message['m_type'] = 99;
        $message['u_id'] = $this->getUserID();
        $message['u_show'] = $post['input-message-anonymous'];
        $message['m_time'] = $this->getTimeString();
        // $message['m_head'] = $post['input-message-head'];
        $message['m_body'] = $post['input-message-body'];
        $row = $this->Thread_model->insert_message($message);
        
        
        // validate & insert poll option
        $max_opt = 4;
        $count = 0;
        for ($i=0; $i<$max_opt; $i++) {
            
            // $fname = 'input-pull-opt-' . (string)$i;
            $fdata = $post['input-poll-opt'][$i];
            
            if ($fdata !== null && $fdata !== "") {
                $poll['opt'][$count] = $fdata;
                $count++;
            }
        }   // end FOR loop
        
        $poll['m_id'] = $row['m_id'];
        $result = $this->Poll_model->insert_opt($poll);
        
        
        // TODO: organize output
        $out['id'] = $row['m_id'];
        $out['body'] = $row['m_body'];
        $out['time'] = $row['m_time'];
        $out['opt'] = $result;
        
        // return
        echo json_encode($out);
        return;
    }
    
    public function poll_vote()
    {
        // TODO: record vote for polling
        
        // load model
        $this->load->model('Poll_model');
        
        // process vote
        $post = $_POST;
        $data['u_id'] = $this->getUserID();
        // $data['u_show'] = $post['something'];
        $data['p_time'] = $this->getTimeString();
        $data['opt_id'] = $post['opt'];
        
        // verify if User already vote
        if ($this->Poll_model->validateUser($data['u_id'],$data['opt_id']) === true) {
            
            // valid to vote -> record vote
            $re = $this->Poll_model->insert_vote($data);
            
            // organize output
            $out['opt'] = $data['opt_id'];
            $out['message'] = 'Success';
            
        } else {
            
            // voted already -> return error
            $out['message'] = 'Already Vote';
            
        }
        
        // return
        echo json_encode($out);
        return;
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
