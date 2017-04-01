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
    
    public function load_thread($user,$lecture,$order=MESSAGE_SHOW_CHRONO)
    {
        $query = $this->db
                    ->select(['m.*', 'sum_vote', 'user_vote'])
                    ->from('message AS m')
                    ->join('thread AS t', 'm.t_id = t.t_id')
                    ->join("(SELECT m_id, SUM(vote) AS sum_vote FROM vote GROUP BY m_id) AS v", 'm.m_id = v.m_id', 'left')
                    ->join("(SELECT m_id, SUM(vote) AS user_vote FROM vote WHERE u_id = $user GROUP BY m_id) AS uv", 'm.m_id = uv.m_id', 'left')
                    ->join('lecture AS lect', 't.lect_id = lect.lect_id')
                    ->where('m.m_type', MESSAGE_TYPE_OPENER)
                    ->where('lect.lect_ref', $lecture);
        
        // order by user preference
        switch ($order) {
            case MESSAGE_SHOW_CHRONO:
                $query = $this->db->order_by('m.m_time');
                break;
            case MESSAGE_SHOW_VOTE:
                $query = $this->db->order_by('sum_vote');
                break;
            case MESSAGE_SHOW_LABEL:
                // TODO: show tags only
                break;
        }
        
        // retrieve
        $row = $query->get()->result_array();
        
        // get labels of messages
        $out = array();
        foreach ($row as $message) {
            $message['labels'] = $this->load_labels($message['m_id']);
            array_push($out, $message);
        }
        
        return $out;
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
     *  Load Labels of $message
     *
     *  @param  $m      message id
     *  @return $result array of labels
     */
    public function load_labels($m)
    {
        $query = $this->db
                    ->select('*')
                    ->from('label')
                    ->where('m_id',$m);
        $result = $query->get()->result_array();
        
        return $result;
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