<?php

class User_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
            // Your own constructor code
    }
    
    public function record_signin($data)
    {
        $this->db->insert('user_log', $data);
        
        $id = $this->db->insert_id();
        return $id;
    }

}