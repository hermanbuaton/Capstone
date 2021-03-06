<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
    public function index()
    {
        $data['page'] = "home";
        $data['title'] = "Homepage";
        
        if ($this->session->flashdata('lecture') !== null)
            $data['lecture'] = $this->session->flashdata('lecture');
        
        if ($this->session->flashdata('error') !== null)
            $data['error'] = $this->session->flashdata('error');
        
        $this->load->view('view_includes/view_header', $data);
        $this->load->view('view_home/view_home_front');
        $this->load->view('view_home/view_home_footer');

        // $this->load->view('header');
        // $this->load->view('welcome_message');
        // $this->load->view('footer');
    }
}
