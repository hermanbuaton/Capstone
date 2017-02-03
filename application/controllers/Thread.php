<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thread extends CI_Controller {

    public function index($subject='', $thread='')
    {
        // validation
        $this->checkSubject($subject);
        $this->checkThread($thread);
        $this->checkLogin();

        $data['room'] = $room;
        
        $data['page'] = "Chat";
        $data['title'] = $room . " - SB Admin";
        
        $this->load->view('view_includes/view_header', $data);
        $this->load->view('view_includes/view_sidebar');
        $this->load->view('view_chat/view_chat_front');
        $this->load->view('view_chat/view_chat_footer');
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
