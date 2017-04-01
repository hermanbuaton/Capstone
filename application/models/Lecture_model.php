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
                    ->where('lect_ref', $s)
                    ->count_all_results('lecture');
        
        return $count;
    }
    
    
    
    /**
     *  return Lect ID from Lect Ref
     */
    public function get_lectid($ref)
    {
        $result = $this->db
                    ->select('lect_id')
                    ->from('lecture')
                    ->where('lect_ref', $ref)
                    ->get()->row();
        
        return intval($result->lect_id);
    }
    
    
    
    /**
     *  return name of lecture
     */
    public function get_lectname($ref)
    {
        $result = $this->db
                    ->select('lect_name')
                    ->from('lecture')
                    ->where('lect_ref', $ref)
                    ->get()->row();
        
        return $result->lect_name;
    }

}