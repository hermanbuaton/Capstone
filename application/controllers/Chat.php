<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
    
    
    
    /**
     *  ============================================================
     *  Construtor
     *  ============================================================
     */
    function __construct()
	{
		parent::__construct();
        
        $this->load->model('Thread_model');
	}
    
    
    
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
     *  
     *  Index:
     *      check if user already login
     *      direct user into chatroom
     *  
     *  @param  $subject    from GET, class / lect code
     *  
     *  ============================================================
     */
    public function index($lecture='')
    {
        // validation
        $this->checkLogin();
        $this->checkLecture($lecture);
        
        // load data into array
        $data['subject'] = $lecture;
        $data['page'] = "Chat";
        $data['title'] = $lecture . " - SB Admin";  // TODO: Page Title
        
        // load view
        $this->load->view('view_includes/view_header', $data);
        $this->load->view('view_includes/view_sidebar');
        $this->load->view('view_chat/view_chat_header');
        $this->load->view('view_chat/view_chat_front');
        $this->load->view('view_chat/view_chat_panel');
        $this->load->view('view_chat/view_chat_poll_create');
        $this->load->view('view_chat/view_chat_poll_vote');
        $this->load->view('view_chat/view_chat_poll_result');
        $this->load->view('view_chat/view_chat_modal');
        $this->load->view('view_chat/view_chat_footer');
        
        return;
    }
    
    
    
    /**
     *  ============================================================
     *  Load previous messages
     *  ============================================================
     */
    public function load($lecture='')
    {
        // validation
        $this->checkLecture($lecture);
        
        // load model & get data
        $out['row'] = $this->Thread_model->load_thread($lecture);
        
        // return
        $this->load->view('view_chat/view_chat_message',$out);
    }
    
    
    
    /**
     *  ============================================================
     *  process NEW MESSAGE
     *  ============================================================
     */
    public function message()
    {
        // load model
        $this->load->model('Lecture_model');
        $this->load->model('Rake_model');
        
        // process message
        $post = $_POST;
        
        // insert thread
        $thread['class_id'] = $post['input-message-class'];
        $thread['lect_id'] = $this->Lecture_model->get_lectid($post['input-message-lect']);
        $message = $this->Thread_model->insert_thread($thread);
        
        // insert message
        $message['m_type'] = 0;
        $message['u_id'] = $this->getUserID();
        $message['u_show'] = $post['input-message-anonymous'];
        $message['m_time'] = $this->getTimeString();
        $message['m_head'] = $post['input-message-head'];
        $message['m_body'] = $post['input-message-body'];
        $data = $this->Thread_model->insert_message($message);
        
        // text mining
        $text = $post['input-message-head'] . ' \n ' . $post['input-message-body'];
        $labels = $this->Rake_model->extract($text);
        $data['labels'] = $this->insert_labels($data['m_id'], 1, $labels);
        
        // on return put data into $out
        $out['row'] = array($data);
        $this->load->view('view_chat/view_chat_message',$out);
    }
    
    
    
    /**
     *  ============================================================
     *  process labels of messages before insert to db
     *  ============================================================
     */
    private function insert_labels($m, $type, $labels)
    {
        // new array
        $out = array();
        
        // put id into each row
        foreach ($labels AS $label) {
            $row['m_id'] = $m;
            $row['label'] = $label['words'];
            $row['l_type'] = 1;
            $row['l_score'] = $label['score'];
            array_push($out, $row);
        }
        
        // to model & return
        $this->Thread_model->insert_labels($out);
        return $out;
    }
    
    
    
    /**
     *  ============================================================
     *  process teachers' RESPOND
     *  ============================================================
     */
    public function respond()
    {   
        // process message
        $post = $_POST;
        $message['t_id'] = $this->Thread_model->get_thread($post['respond-id']);
        $message['m_type'] = 10;
        $message['u_id'] = $this->getUserID();
        $message['u_show'] = 1;
        $message['m_time'] = $this->getTimeString();
        $message['m_body'] = $post['respond-body'];
        
        // send to MODEL
        // on return put data into $out
        $row = $this->Thread_model->insert_message($message);
        $out['row'] = array($row);
        
        // return
        return true;
    }
    
    
    
    /**
     *  ============================================================
     *  process VOTE of messages
     *  ============================================================
     */
    public function vote()
    {
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
    
    
    
    /**
     *  ============================================================
     *  Create New Poll
     *  ============================================================
     */
    public function poll_create()
    {
        // load model
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
    
    
    
    /**
     *  ============================================================
     *  process VOTE for poll
     *  ============================================================
     */
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
            $poll = $this->Poll_model->get_poll($data['opt_id']);
            $out['poll'] = $poll['poll'];
            $out['opt'] = $poll['opt'];
            $out['vote'] = $data['opt_id'];
            $out['message'] = 'Success';
            
        } else {
            
            // voted already -> return error
            $out['message'] = 'Already Vote';
            
        }
        
        // return
        echo json_encode($out);
        return;
    }
    
    
    
    /**
     *  ============================================================
     *  
     *  TODO: check if inputted session EXISTED
     *  
     *  @param  $s          user input
     *  @return BOOLEAN     true when session exist, 
     *                      false when session NOT exist
     *  
     *  ============================================================
     */
    private function checkLecture($s)
    {
        // load model
        $this->load->model('Lecture_model');
        
        // if nothing is inputted
        if ($s=='' || $s === null) {
            redirect();
        }
        
        // check from db
        if (!($this->Lecture_model->validate_ref($s) > 0)) {
            // ref not found
            $this->session->set_flashdata('error','Login code incorrect.');
            redirect();
        }
        
        return true;
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
