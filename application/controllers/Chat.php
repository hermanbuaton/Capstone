<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    /**
    * Index Page for this controller.
    *
    * Maps to the following URL
    *    http://example.com/index.php/welcome
    *  - or -
    *    http://example.com/index.php/welcome/index
    *  - or -
    * Since this controller is set as the default controller in
    * config/routes.php, it's displayed at http://example.com/
    *
    * So any other public methods not prefixed with an underscore will
    * map to /index.php/welcome/<method_name>
    * @see http://codeigniter.com/user_guide/general/urls.html
    */
    public function index($room='')
    {
        //check if logined already
        if(!$this->session->userdata('user_name')) {
            redirect('');
        }

        $data['room'] = $room;


        $data['page'] = "Chat";
        $data['title'] = $room . " - SB Admin";
        // $this->load->view('view_chat/view_chat_front', $data);
        $this->load->view('view_chat/view_chat_header', $data);
        $this->load->view('view_chat/view_chat_sidebar');
        $this->load->view('view_chat/view_chat_front');
        $this->load->view('view_chat/view_chat_footer');
    }

}
