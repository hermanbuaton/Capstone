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
      $data['room'] = $room;
      // $this->load->view('view_chat/view_chat_front', $data);
      
      $this->load->view('view_chat/view_chat_header', $data);
      $this->load->view('view_chat/view_chat_front2', $data);
      $this->load->view('view_chat/view_chat_footer', $data);
  }
}
