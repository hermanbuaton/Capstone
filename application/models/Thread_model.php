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
        // insert
        $this->db->insert('message',$data);
        
        // put id into array
        $data['m_id'] = $this->db->insert_id();
        
        return array($data);
    }
    
    public function insert_vote($data)
    {
        $this->db->insert('vote',$data);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function load_thread($subject)
    {
        // TODO: set query WHERE subject == subject id
        $query = $this->db
                    ->select('m.*, SUM(v.vote) AS vote')
                    ->from('message AS m')
                    ->join('vote AS v', 'm.m_id = v.m_id', 'left')
                    ->where('m.m_type',0)
                    ->group_by('m.m_id');
        $row = $query->get()->result_array();
        
        return $row;
    }
    
    public function load_message($thread)
    {
        // TODO: set query WHERE thread == thread id
        $query = $this->db
                    ->select('m.*, SUM(v.vote) AS vote')
                    ->from('(SELECT t_id FROM message WHERE m_id ='.$thread.') AS t')
                    ->from('message AS m')
                    ->join('vote AS v', 'm.m_id = v.m_id', 'left')
                    ->where('m.t_id = t.t_id')
                    ->group_by('m.m_id');
        $row = $query->get()->result_array();
        
        return $row;
    }
    
    
    /**
     *  Return Thread ID only
     *
     *  @param  $m      message id
     *  @return $id     thread id
     */
    public function get_thread($m)
    {
        $result = $this->db
                    ->select('t_id')
                    ->from('message')
                    ->where('m_id', $m)
                    ->get()->row();
        
        return $result->t_id;
    }

}