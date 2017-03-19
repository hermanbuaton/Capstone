<?php

class Class_model extends CI_Model {
    
    
    
    public function __construct()
    {
            parent::__construct();
            // Your own constructor code
    }
    
    
    
    /**
     *  Store NEW class into db
     */
    public function create($data)
    {
        $this->db->insert('class', $data);
        
        $out = $this->db->insert_id();
        return $out;
    }
    
    
    
    /**
     *  Validate if class already exists
     *  
     *  @param  $co         course id
     *  @param  $cl         class code
     *  @param  $sem        semester id
     *  @return [INT]       when class existed
     *  @return [BOOLEAN]   when class not existed
     */
    public function check_exist($co,$cl,$sem)
    {
        // count username
        $result = $this->db
                    ->select('class_id AS id')
                    ->from('class')
                    ->where('course_id', $co)
                    ->where('class_code', $cl)
                    ->where('sem_id', $sem)
                    ->get()->row();
        
        // return
        if ($result->id !== null)
            return $result->id;
        // else
        return false;
    }
    
    
    
    /**
     *  Get all classes of an user
     */
    public function load_class($user)
    {
        
        // get all classes
        $query = $this->db
                    ->select([
                            'cl.class_id AS class_id',
                            'cl.course_id AS course_id',
                            'co.sch_id AS sch_id',
                            'sch.sch_code AS sch_code',
                            'sch.sch_name AS sch_name',
                            'co.course_code AS course_code',
                            'co.course_name AS course_name',
                            'cl.class_code AS class_code',
                            'cl.sem_id AS sem_id',
                            'sem.sem_code AS sem_code',
                            'sem.sem_name AS sem_name',
                            'cl.own_id AS own_id',
                            'u.u_nick AS u_nick'
                            ])
                    ->from('class AS cl')
                    ->join('course AS co', 'cl.course_id = co.course_id')
                    ->join('school AS sch', 'co.sch_id = sch.sch_id')
                    ->join('semester AS sem', 'cl.sem_id = sem.sem_id')
                    ->join('user AS u', 'cl.own_id = u.u_id')
                    ->where('cl.own_id', $user);
        $row = $query->get()->result_array();
        
        // get lectures of classes
        $out = [];
        $count = 0;
        foreach ($row as $class) {
            $class['lecture'] = $this->load_lecture($class['class_id']);
            $out[$count] = $class;
            $count++;
        }
        
        // return
        return $out;
    }
    
    
    
    /**
     *  Get all lectures of a class
     */
    public function load_lecture($class)
    {
        
        $query = $this->db
                    ->select(['lect_id','lect_ref','lect_name','lect_start'])
                    ->from('lecture')
                    ->where('class_id', $class);
        $row = $query->get()->result_array();
        
        return $row;
    }
    
}