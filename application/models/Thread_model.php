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
        $this->db->insert('thread',$data);
        
        // EDIT: return to controller before goto insert_message()
        // $row = $this->insert_message($message);
        $out['t_id'] = $this->db->insert_id();
        return $out;
    }
    
    public function insert_message($data)
    {
        // insert
        $this->db->insert('message',$data);
        
        // put id into array
        $data['m_id'] = $this->db->insert_id();
        return $data;
    }
    
    public function insert_labels($data)
    {
        $this->db->insert_batch('label',$data);
        
        return $data;
    }
    
    public function insert_vote($data)
    {
        $this->db->insert('vote',$data);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function load_thread($lecture)
    {
        // TODO: set query WHERE subject == subject id
        $query = $this->db
                    ->select('m.*, SUM(v.vote) AS vote')
                    ->from('message AS m')
                    ->join('thread AS t', 'm.t_id = t.t_id')
                    ->join('vote AS v', 'm.m_id = v.m_id', 'left')
                    ->join('lecture AS l', 't.lect_id = l.lect_id')
                    ->where('m.m_type',0)
                    ->where('l.lect_ref',$lecture)
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