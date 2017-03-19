<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    
    
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
     *  Index:
     *      check if user already login
     *      load dashboard
     *  ============================================================
     */
    public function index()
    {
        // validation
        $this->checkLogin();
        
        // get form input options
        $this->load->model('User_model');
        $user = $this->User_model->get_userid($this->session->userdata('user_id'));
        
        // put necessary data into array
        $data['page'] = "Dashboard";
        $data['title'] = "Dashboard";  // TODO: Page Title
        $data['user'] = $user;
        $data['semester'] = $this->User_model->get_semester($user);
        
        $this->load->view('view_includes/view_header', $data);
        $this->load->view('view_includes/view_sidebar');
        $this->load->view('view_dashboard/view_dashboard_header');
        $this->load->view('view_dashboard/view_dashboard_front');
        $this->load->view('view_dashboard/view_dashboard_new_class');
        $this->load->view('view_dashboard/view_dashboard_new_lect');
        $this->load->view('view_dashboard/view_dashboard_footer');
        
        return;
    }
    
    
    
    /**
     *  ============================================================
     *  Load list of classes
     *  ============================================================
     */
    public function load()
    {
        // load model
        $this->load->model('User_model');
        $this->load->model('Class_model');
        
        // get data
        $user = $this->User_model->get_userid($this->session->userdata['user_id']);
        $class = $this->Class_model->load_class($user);
        // $out['row'] = $this->Thread_model->load_thread($subject);
        
        // return
        $out['row'] = $class;
        $this->load->view('view_dashboard/view_dashboard_class',$out);
    }
    
    
    
    /**
     *  ============================================================
     *  Create new class
     *  ============================================================
     */
    private function class_create()
    {
        // load model
        $this->load->model('User_model');
        $this->load->model('Course_model');
        $this->load->model('Class_model');
        
        $user = $this->User_model->get_userid($this->session->userdata['user_id']);
        $sch = $this->User_model->get_schid($user);
        
        // process message
        $post = $_POST;
        $co['course_code'] = $post['course_code'];
        $co['sch_id'] = $sch;
        $cl['class_code'] = $post['class_code'];
        $cl['sem_id'] = $post['semester'];
        $cl['own_id'] = $user;
        
        // check if course exists
        $exist = $this->Course_model->check_exist($co['course_code'],$co['sch_id']);
        if ($exist !== FALSE) {
            // course exist, copy course id into array
            $cl['course_id'] = $exist;
        } else {
            // course do not exist, create a new one
            $cl['course_id'] = $this->Course_model->create($co);
        }
        
        // check if course exists
        $exist = $this->Class_model->check_exist(
                    $cl['course_id'],$cl['class_code'],$cl['sem_id']
                 );
        if ($exist !== FALSE) {
            // class exist, return error message
            $out['message'] = 'Failed. Class already exists.';
            echo json_encode($out);
        } else {
            // class do not exist, create a new one
            $out = $this->Class_model->create($cl);
            $this->load();
        }
        
        // return
        return;
    }
    
    
    
    /**
     *  ============================================================
     *  Create new lect
     *  ============================================================
     */
    private function lect_create()
    {
        // load model
        $this->load->helper('string');
        $this->load->model('User_model');
        $this->load->model('Lecture_model');
            
        // process message
        $post = $_POST;
        $user = $this->User_model->get_userid($this->session->userdata['user_id']);
        $time = date(DATE_RFC3339, mktime(
                        $post['start_hour'],    // hour
                        $post['start_min'],     // minute
                        0,                      // second
                        $post['start_month'],   // month
                        $post['start_day'],     // day
                        $post['start_year']     // year
                    ));
        $data['class_id'] = $post['class_id'];
        $data['lect_name'] = $post['lect_name'];
        $data['lect_start'] = $time;
        $data['own_id'] = $user;
        
        // generate random ref #
        $ran = '';
        do {
            $ran   = strtoupper(random_string('alnum', 8));
            $count = $this->Lecture_model->validate_ref($ran);
        } while ($count > 0);
        
        // to model->db
        $data['lect_ref'] = $ran;
        $out = $this->Lecture_model->create($data);
        
        // return
        $this->load();
        return;
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