<?php

class Poll_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
    
    public function insert_opt($data)
    {
        // init
        $row = $data['opt'];
        $out = array();
        
        
        foreach($row as $key) {
            
            // organize data
            $a = array( 'm_id' => $data['m_id'],
                        'opt_txt' => $key
                      );
            
            // insert
            $this->db->insert('poll_opt', $a);
            
            // organize output
            $b = array( 'opt_id' => $this->db->insert_id(),
                        'opt_txt' => $key
                      );
            array_push($out, $b);
        }
        
        
        // return
        return $out;
    }
    
    public function insert_vote($data)
    {
        $this->db->insert('vote',$data);
        $id = $this->db->insert_id();
        
        return $id;
    }

}