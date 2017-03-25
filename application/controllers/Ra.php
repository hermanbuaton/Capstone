<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ra extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
    
    public function index()
    {
        $this->load->model('Rake_model');
        
        $list = base_url('rake/stoplist_smart.txt');
        var_dump($list);
        
        $stop = $this->Rake_model->load_stopwords2($list);
        var_dump($stop);
        
    }

}