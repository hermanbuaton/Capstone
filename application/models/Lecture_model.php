<?php

class Lecture_model extends CI_Model {
    
    
    
    public function __construct()
    {
            parent::__construct();
            // Your own constructor code
    }
    
    
    
    /**
     *  Store NEW course into db
     */
    public function create($data)
    {
        $this->db->insert('lecture', $data);
        
        $out = $this->db->insert_id();
        return $out;
    }
    
    
    
    /**
     *  Validate if ref already exist
     */
    public function validate_ref($s)
    {
        $count = $this->db
                    ->where('lect_ref', $ran)
                    ->count_all_results('lecture');
        
        return $count;
    }

}