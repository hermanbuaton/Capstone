<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Second extends CI_Controller {

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
        echo "hello " . ENVIRONMENT;
        
        $servername = "104.199.234.169";
        $username = "root";
        $password = "root111";

        // Create connection
        $conn = new mysqli($servername, $username, $password);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        echo "Connected successfully";

        // $this->load->view('welcome_message');
        // $this->load->view('view_chat/view_chat_header');
        // $this->load->view('view_chat/view_chat_front');
        // $this->load->view('view_chat/view_chat_footer');
    }
}
