<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function index($room='')
    {
        // validation
        $this->checkRoom($room);
        $this->checkLogin();

        $data['room'] = $room;


        $data['page'] = "Chat";
        $data['title'] = $room . " - SB Admin";
        // $this->load->view('view_chat/view_chat_front', $data);
        $this->load->view('view_chat/view_chat_header', $data);
        $this->load->view('view_chat/view_chat_sidebar');
        $this->load->view('view_chat/view_chat_front');
        $this->load->view('view_chat/view_chat_footer');
    }
    
    private function checkRoom($room)
    {
        if($room=='' || $room === null) {
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
