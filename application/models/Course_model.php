<?php

class Course_model extends CI_Model {
    
    
    
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
        $this->db->insert('course', $data);
        
        $out = $this->db->insert_id();
        return $out;
    }
    
    
    
    /**
     *  Validate if course already exists
     *  
     *  @param  $co         course code
     *  @param  $sch        school id
     *  @return [INT]       when course existed
     *  @return [BOOLEAN]   when course not existed
     */
    public function check_exist($co,$sch)
    {
        // count username
        $result = $this->db
                    ->select('course_id AS id')
                    ->from('course')
                    ->where('course_code', $co)
                    ->where('sch_id', $sch)
                    ->get()->row();
        
        // return
        if ($result->id !== null)
            return $result->id;
        // else
        return false;
    }
    

}