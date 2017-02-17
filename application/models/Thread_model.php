<?php

class Thread_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
            // Your own constructor code
    }
    
    public function insert_thread($data)
    {
        // insert THREAD
        $thread['class_id'] = $data['class_id'];
        $thread['lect_id'] = "";    // TODO: lect_id
        
        $this->db->insert('thread',$thread);
        $id['t'] = $this->db->insert_id();
        
        
        // insert MESSAGE
        $message['t_id'] = $id['t'];
        $message['m_type'] = $data['m_type'];
        $message['u_id'] = $data['u_id'];
        $message['u_show'] = $data['u_show'];
        $message['m_time'] = $data['m_time'];
        $message['m_head'] = $data['m_head'];
        $message['m_body'] = $data['m_body'];
        
        $row = $this->insert_message($message);
        
        return $row;
    }
    
    public function insert_message($data)
    {
        $this->db->insert('message',$data);
        $data['m_id'] = $this->db->insert_id();
        $query = $this->db
                    ->select('*')
                    ->from('message')
                    ->where('m_id',$data['m_id']);
        $row = $query->get()->result();
        
        // $row = array($data);
        return $row;
    }
    
    public function insert_vote($data)
    {
        $this->db->insert('vote',$data);
        $id = $this->db->insert_id();
        
        return $id;
    }

}