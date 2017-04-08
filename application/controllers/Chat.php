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
        // validate lecture ref
        if (!$this->checkLecture($lecture)) {
            $this->session->set_flashdata('error','Incorrect lecture assess code.');
            redirect("");
        }
        
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Input a nickname to continue.');
            $this->session->set_flashdata('lecture',$lecture);
            redirect("");
        }
        
        // load data into array
        $this->load->model('Lecture_model');
        $data['subject'] = $lecture;
        $data['page'] = "Chat";
        $data['title'] = $this->Lecture_model->get_lectname($lecture);
        
        // load view
        $this->load->view('view_includes/view_header', $data);
        $this->load->view('view_includes/view_sidebar');
        $this->load->view('view_chat/view_chat_header');
        $this->load->view('view_chat/view_chat_front');
        $this->load->view('view_chat/view_chat_panel');
        $this->load->view('view_chat/view_chat_input');
        $this->load->view('view_chat/view_chat_login');
        $this->load->view('view_chat/view_chat_settings');
        $this->load->view('view_chat/view_chat_modal');
        $this->load->view('view_chat/view_chat_poll_list');
        $this->load->view('view_chat/view_chat_poll_create');
        $this->load->view('view_chat/view_chat_poll_vote');
        $this->load->view('view_chat/view_chat_poll_result');
        $this->load->view('view_chat/view_chat_respond');
        $this->load->view('view_chat/view_chat_social_list');
        $this->load->view('view_chat/view_chat_footer');
        
        return;
    }
    
    
    
    /**
     *  ============================================================
     *  Load previous messages
     *  ============================================================
     */
    public function load($lecture='',$order=MESSAGE_SHOW_CHRONO,$label='')
    {
        // validate lecture ref
        if (!$this->checkLecture($lecture)) {
            $this->session->set_flashdata('error','Incorrect lecture assess code.');
            $this->echo_redirect("invalid lecture code", "");
        }
        
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Input a nickname to continue.');
            $this->session->set_flashdata('lecture',$lecture);
            $this->echo_redirect("session timeout", "");
        }
        
        // load model & get data
        $user = $this->session->userdata('user_id');
        $order = intval($order);
        $out['row'] = $this->Thread_model->load_thread($user,$lecture,$order,$label);
        $out['order'] = $order;
        
        // return
        $this->load->view('view_chat/view_chat_message',$out);
    }
    
    
    
    /**
     *  ============================================================
     *  Load ALL polls
     *  ============================================================
     */
    public function load_poll($lecture='')
    {
        // load modal
        $this->load->model('Poll_model');
        
        // validate lecture ref
        if (!$this->checkLecture($lecture)) {
            $this->session->set_flashdata('error','Incorrect lecture assess code.');
            $this->echo_redirect("invalid lecture code", "");
        }
        
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Input a nickname to continue.');
            $this->session->set_flashdata('lecture',$lecture);
            $this->echo_redirect("session timeout", "");
        }
        
        // load model & get data
        $user = $this->session->userdata('user_id');
        $out['row'] = $this->Poll_model->load_poll($user,$lecture);
        
        // return
        $this->load->view('view_chat/view_chat_poll_item',$out);
    }
    
    
    
    /**
     *  ============================================================
     *  Load FULL thread
     *  ============================================================
     */
    public function thread($message)
    {
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Session timeout. Login again.');
            $this->session->set_flashdata(
                    'lecture',$this->Thread_model->get_lect($message)
                );
            
            $this->echo_redirect("session timeout", "");
            return;
        }
        
        // load model & get data
        $user = $this->session->userdata('user_id');
        $out['row'] = $this->Thread_model->load_message($user,$message);
        
        // return
        $this->load->view('view_thread/view_thread_message',$out);
    }
    
    
    
    /**
     *  ============================================================
     *  Load author of a message
     *  ============================================================
     */
    public function get_author($message)
    {
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Session timeout. Login again.');
            $this->session->set_flashdata(
                    'lecture',$this->Thread_model->get_lect($message)
                );
            
            $this->echo_redirect("session timeout", "");
            return;
        }
        
        // validate user role
        if (!$this->checkUserRole(USER_TYPE_INSTRUCTOR)) {
            $out = array(
                            "message" => "Invalid user role. Login to instructor account to carry out the action."
                        );
            echo json_encode($out);
            return;
        }
        
        // load model & get data
        $author = $this->Thread_model->get_author($message);
        
        // return
        echo json_encode($author);
    }
    
    
    
    /**
     *  ============================================================
     *  process NEW MESSAGE
     *  ============================================================
     */
    public function message()
    {
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Session timeout. Login again.');
            $this->session->set_flashdata('lecture',$post['input-message-lect']);
            
            $this->echo_redirect("session timeout", "");
            return;
        }
        
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
        $message['m_type'] = MESSAGE_TYPE_OPENER;
        $message['u_id'] = $this->getUserID();
        $message['u_show'] = $post['input-message-anonymous'];
        $message['m_time'] = $this->getTimeString();
        $message['m_head'] = $post['input-message-head'];
        $message['m_body'] = $post['input-message-body'];
        $data = $this->Thread_model->insert_message($message);
        
        // get user name
        $data['u_name'] = $this->session->userdata('username');
        
        // text mining
        $text = $post['input-message-head'] . ' \n ' . $post['input-message-body'];
        $labels = $this->Rake_model->extract($text);
        $data['labels'] = $this->insert_labels($data['m_id'], 1, $labels);
        
        // on return put data into $out
        $out['row'] = array($data);
        $out['order'] = MESSAGE_SHOW_LABEL;
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
        // get POST
        $post = $_POST;
        
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Session timeout. Login again.');
            $this->session->set_flashdata(
                    'lecture',$this->Thread_model->get_lect($post['respond-id'])
                );
            
            $this->echo_redirect("session timeout", "");
            return;
        }
        
        // process message
        $message['t_id'] = $this->Thread_model->get_thread($post['respond-id']);
        $message['m_type'] = MESSAGE_TYPE_RESPOND;
        $message['u_id'] = $this->getUserID();
        $message['u_show'] = MESSAGE_ANONYMOUS_NO;
        $message['m_time'] = $this->getTimeString();
        $message['m_body'] = $post['respond-textarea'];
        
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
        // get POST
        $post = $_POST;
        
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Session timeout. Login again.');
            $this->session->set_flashdata(
                    'lecture',$this->Thread_model->get_lect($post['vote-message'])
                );
            
            $this->echo_redirect("session timeout", "");
            return;
        }
        
        // process vote
        $data['m_id'] = $post['vote-message'];
        $data['u_id'] = $this->getUserID();
        $data['vote'] = $post['vote-value'];
        $data['v_time'] = $this->getTimeString();
        
        // send to MODEL
        $this->Thread_model->insert_vote($data);
        
        // return
        $out['m'] = $data['m_id'];
        $out['v'] = $data['vote'];
        echo json_encode($out);
    }
    
    
    
    /**
     *  ============================================================
     *  RAISE HAND for messages
     *  ============================================================
     */
    public function hand()
    {
        // get POST
        $post = $_POST;
        
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Session timeout. Login again.');
            $this->session->set_flashdata(
                    'lecture',$this->Thread_model->get_lect($post['hand-message'])
                );
            
            $this->echo_redirect("session timeout", "");
            return;
        }
        
        // process vote
        $data['m_id'] = $post['hand-message'];
        $data['u_id'] = $this->getUserID();
        $data['hand'] = $post['hand-value'];
        $data['h_time'] = $this->getTimeString();
        
        // TODO: get user data
        
        // send to MODEL
        $this->Thread_model->insert_hand($data);
        
        // return
        $out['m'] = $data['m_id'];
        $out['v'] = $data['hand'];
        echo json_encode($out);
    }
    
    
    
    /**
     *  ============================================================
     *  GET users RAISED HAND for messages
     *  ============================================================
     */
    public function get_hands($message)
    {
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Session timeout. Login again.');
            $this->session->set_flashdata(
                    'lecture',$this->Thread_model->get_lect($message)
                );
            
            $this->echo_redirect("session timeout", "");
            return false;
        }
        
        // request from MODEL
        $hands = $this->Thread_model->load_hands($message);
        
        // return
        $data['row'] = $hands;
        $this->load->view('view_chat/view_chat_social_item',$data);
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
        $this->load->model('Lecture_model');
        
        // process message
        $post = $_POST;
        
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Session timeout. Login again.');
            $this->session->set_flashdata('lecture',$post['input-message-lect']);
            
            $this->echo_redirect("session timeout", "");
            return;
        }
        
        // insert thread
        $thread['class_id'] = $post['input-message-class'];
        $thread['lect_id'] = $this->Lecture_model->get_lectid($post['input-message-lect']);
        $message = $this->Thread_model->insert_thread($thread);
        
        // insert message
        $message['m_type'] = $post['input-poll-type'];
        $message['u_id'] = $this->getUserID();
        $message['u_show'] = $post['input-message-anonymous'];
        $message['m_time'] = $this->getTimeString();
        // $message['m_head'] = $post['input-message-head'];
        $message['m_body'] = $post['input-message-body'];
        $row = $this->Thread_model->insert_message($message);
        
        // validate poll option
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
        
        // send to model, insert options
        $poll['m_id'] = $row['m_id'];
        $result = $this->Poll_model->insert_opt($poll);
        
        // organize output
        $out['id'] = $row['m_id'];
        $out['body'] = $row['m_body'];
        $out['type'] = $row['m_type'];
        $out['time'] = $row['m_time'];
        $out['opt'] = $result;
        
        // return
        echo json_encode($out);
        return;
    }
    
    
    
    /**
     *  ============================================================
     *  Update existing Poll
     *  ============================================================
     */
    public function poll_update()
    {
        // load model
        $this->load->model('Poll_model');
        
        // process message
        $post = $_POST;
        $id = $post['id'];
        $type = $post['status'];
        
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Session timeout. Login again.');
            $this->session->set_flashdata('lecture',$post['input-message-lect']);
            
            $this->echo_redirect("session timeout", "");
            return;
        }
        
        // if update success
        // -> get poll data & output
        if ($this->Poll_model->update_type($id, $type) === TRUE) {
            $this->poll_get(id);
        }
    }
    
    
    
    /**
     *  ============================================================
     *  process VOTE for poll
     *  ============================================================
     */
    public function poll_vote()
    {
        // load model
        $this->load->model('Poll_model');
        
        // process vote
        $post = $_POST;
        $data['u_id'] = $this->getUserID();
        // $data['u_show'] = $post['something'];
        $data['p_time'] = $this->getTimeString();
        $data['opt_id'] = $post['opt'];
        
        $u_pass = $this->Poll_model->validateUser($data['u_id'],$data['opt_id']);
        $p_pass = $this->Poll_model->validatePoll($data['opt_id']);
        
        if ($u_pass === TRUE && $p_pass === TRUE) {
            
            // valid to vote -> record vote
            $re = $this->Poll_model->insert_vote($data);
            $out['message'] = 'Success';
            
        } elseif ($u_pass === FALSE) {
            
            // voted already -> return error
            $out['message'] = 'You have already voted.';
            
        } elseif ($p_pass === FALSE) {
            
            // poll closed -> return error
            $out['message'] = 'Poll closed or not yet started.';
            
        }
        
        // organize output
        $m = $this->Poll_model->get_pollid($data['opt_id']);
        $poll = $this->Poll_model->get_poll($m);
        $out['id'] = $poll['id'];
        $out['type'] = $poll['type'];
        $out['poll'] = $poll['poll'];
        $out['opt'] = $poll['opt'];
        $out['vote'] = $data['opt_id'];
        
        // return
        echo json_encode($out);
        return;
    }
    
    
    
    /**
     *  ============================================================
     *  get body & opt of a SINGLE poll
     *  ============================================================
     */
    public function poll_get($m)
    {
        // load model
        $this->load->model('Poll_model');
        
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Session timeout. Login again.');
            $this->session->set_flashdata(
                    'lecture',$this->Thread_model->get_lect($message)
                );
            
            $this->echo_redirect("session timeout", "");
            return;
        }
        
        // get results from model
        $poll = $this->Poll_model->get_poll($m);
        $row = $poll['poll'];
        
        // organize output
        $out['id'] = $row->m_id;
        $out['body'] = $row->m_body;
        $out['type'] = $row->m_type;
        $out['time'] = $row->m_time;
        $out['opt'] = $poll['opt'];
        
        // return
        echo json_encode($out);
        return;
    }
    
    
    
    /**
     *  ============================================================
     *  get result of a SINGLE poll
     *  ============================================================
     */
    public function poll_result($m)
    {
        // load model
        $this->load->model('Poll_model');
        
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Session timeout. Login again.');
            $this->session->set_flashdata(
                    'lecture',$this->Thread_model->get_lect($message)
                );
            
            $this->echo_redirect("session timeout", "");
            return;
        }
        
        // get results from model
        $poll = $this->Poll_model->get_poll($m);
        
        // organize output
        $out['id'] = $poll['id'];
        $out['type'] = $poll['type'];
        $out['poll'] = $poll['poll'];
        $out['opt'] = $poll['opt'];
        $out['vote'] = $data['opt_id'];
        $out['message'] = 'Success';
        
        // return
        echo json_encode($out);
        return;
    }
    
    
    
    /**
     *  ============================================================
     *  
     *  Save settings of a lecture
     *  
     *  @param  $set        field to be set
     *  @param  $val        new value of field
     *  
     *  ============================================================
     */
    public function settings($lect,$set,$val=true)
    {
        // load model
        $this->load->model('Lecture_model');
        
        
        // validate user
        if (!$this->checkLogin()) {
            $this->session->set_flashdata('error','Session timeout. Login again.');
            $this->session->set_flashdata(
                    'lecture',$this->Thread_model->get_lect($message)
                );
            
            $this->echo_redirect("session timeout", "");
            return;
        }
        
        
        // validate user role
        if (!$this->checkUserRole(USER_TYPE_INSTRUCTOR)) {
            $out = array(
                            "message" => "Invalid user role. Login to instructor account to carry out the action."
                        );
            echo json_encode($out);
            return;
        }
        
        
        // process inputting data
        switch ($set) {
                
            case 'anonymous':
                $set = 'set_anonymous';
                if ($val === "true") {
                    $val = SET_ANONYMOUS_YES;
                } else {
                    $val = SET_ANONYMOUS_NO;
                }
                
                break;
            
            case 'discussion':
                $set = 'set_discussion';
                if ($val === "true") {
                    $val = SET_DISCUSSION_YES;
                } else {
                    $val = SET_DISCUSSION_NO;
                }
                
                break;
            
            default:
                return false;
                
        }
        
        
        // send to model
        $this->Lecture_model->set_settings($lect,$set,$val);
        $this->get_settings($lect);
    }
    
    
    
    /**
     *  ============================================================
     *  GET instructors' settings of a lecture
     *  ============================================================
     */
    public function get_settings($lect)
    {
        // request from MODEL
        $this->load->model('Lecture_model');
        $data = $this->Lecture_model->get_settings($lect);
        
        // return
        echo json_encode($data);
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
            return false;
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
            return false;
        }
        
        return true;
    }
    
    
    
    /**
     *  ============================================================
     *  Check if user already login
     *  ============================================================
     */
    private function checkUserRole($target)
    {
        // check if logined already
        if(intval($this->session->userdata('user_type')) !== $target) {
            return false;
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
    
    
    
    /**
     *  ============================================================
     *  Respond to AJAX request with error message
     *  ============================================================
     */
    private function echo_redirect($message, $location)
    {
        $out = array(   "auth" => "failed", 
                        "message" => $message, 
                        "location" => $location
                    );
        echo json_encode($out);
        
        return;
    }
    

    
    
}
