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
    
    public function insert_hand($data)
    {
        $this->db->insert('hand',$data);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function load_thread($user,$lecture,$order=MESSAGE_SHOW_CHRONO,$label='')
    {
        // get specified label text
        if ($label !== null && $label !== '') {
            $query2 = $this->db
                        ->select('label')
                        ->from('label')
                        ->where('l_id',$label)
                        ->get_compiled_select();
        }
        
        
        // prepare query
        $query = $this->db
                    ->select(['m.*', 'u_name', 'sum_vote', 'user_vote', 'sum_hand', 'user_hand'])
                    ->from('message AS m')
                    ->join('thread AS t', 'm.t_id = t.t_id')
                    ->join('user_log AS u', 'm.u_id = u.log_id')
                    ->join('lecture AS lect', 't.lect_id = lect.lect_id')
                    ->join("(SELECT m_id, SUM(vote) AS sum_vote FROM vote GROUP BY m_id) AS v", 'm.m_id = v.m_id', 'left')
                    ->join("(SELECT m_id, SUM(vote) AS user_vote FROM vote WHERE u_id = $user GROUP BY m_id) AS uv", 'm.m_id = uv.m_id', 'left')
                    ->join("(SELECT m_id, SUM(hand) AS sum_hand FROM hand GROUP BY m_id) AS h", 'm.m_id = h.m_id', 'left')
                    ->join("(SELECT m_id, SUM(hand) AS user_hand FROM hand WHERE u_id = $user GROUP BY m_id) AS uh", 'm.m_id = uh.m_id', 'left');
        
        
        // fliter by label
        if ($label !== null && $label !== '') {
            $query = $this->db->join("label AS l", "l.m_id = m.m_id", "left");
            $query = $this->db->where("l.label in ($query2)",null,false);
        }
        
        
        // fliter by message type: get OPENER only
        // fliter by lecture ref
        $query = $this->db
                    ->where('m.m_type', MESSAGE_TYPE_OPENER)
                    ->where('lect.lect_ref', $lecture);
        
        
        // order by user preference
        switch ($order) {
            case MESSAGE_SHOW_CHRONO:
                $query = $this->db->order_by('m.m_time');
                $row = $query->get()->result_array();
                break;
            case MESSAGE_SHOW_VOTE:
                $query = $this->db->order_by('sum_vote, m.m_time');
                $row = $query->get()->result_array();
                break;
            case MESSAGE_SHOW_LABEL:
                $query = $this->db->get_compiled_select();
                $query2 = $this->db
                            ->select([  'DISTINCT(l.label) AS m_head', 
                                        'COUNT(DISTINCT(l.m_id)) AS sum_asked', 
                                        'AVG(l.l_score) AS score',
                                        'MIN(l.l_id) AS m_id',
                                        'SUM(sum_vote) AS sum_vote',
                                        'SUM(sum_hand) AS sum_hand'
                                    ])
                            ->from('label AS l')
                            ->join("($query) AS q", "l.m_id = q.m_id")
                            ->group_by('label')
                            ->order_by('sum_vote')
                            ->order_by('score');
                $row = $this->db->get()->result_array();
                return $row;
        }
        
        
        // get labels of messages
        $out = array();
        foreach ($row as $message) {
            $message['labels'] = $this->load_labels($message['m_id']);
            array_push($out, $message);
        }
        
        
        // return
        return $out;
    }
    
    public function load_message($user,$message)
    {
        // TODO: set query WHERE thread == thread id
        /*
        $query = $this->db
                    ->select('m.*, SUM(v.vote) AS vote')
                    ->from('(SELECT t_id FROM message WHERE m_id ='.$message.') AS t')
                    ->from('message AS m')
                    ->join('vote AS v', 'm.m_id = v.m_id', 'left')
                    ->where('m.t_id = t.t_id')
                    ->group_by('m.m_id');
        $row = $query->get()->result_array();
        */
        
        $query = $this->db
                    ->select(['m.*', 'u_name', 'sum_vote', 'user_vote', 'sum_hand', 'user_hand'])
                    ->from('message AS m')
                    ->from('(SELECT m.t_id, t.lect_id FROM message AS m JOIN thread AS t ON m.t_id = t.t_id WHERE m_id = '.$message.') AS t')
                    ->join('user_log AS u', 'm.u_id = u.log_id')
                    ->join("(SELECT m_id, SUM(vote) AS sum_vote FROM vote GROUP BY m_id) AS v", 'm.m_id = v.m_id', 'left')
                    ->join("(SELECT m_id, SUM(vote) AS user_vote FROM vote WHERE u_id = $user GROUP BY m_id) AS uv", 'm.m_id = uv.m_id', 'left')
                    ->join("(SELECT m_id, SUM(hand) AS sum_hand FROM hand GROUP BY m_id) AS h", 'm.m_id = h.m_id', 'left')
                    ->join("(SELECT m_id, SUM(hand) AS user_hand FROM hand WHERE u_id = $user GROUP BY m_id) AS uh", 'm.m_id = uh.m_id', 'left')
                    ->join('lecture AS lect', 't.lect_id = lect.lect_id')
                    ->where('m.t_id = t.t_id');
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
     *  Load upped hands of $message
     *
     *  @param  $m      message id
     *  @return $result array of users
     */
    public function load_hands($m)
    {
        $query = $this->db
                    ->select(['u.u_name', 'sh.*'])
                    ->from("(SELECT m_id, u_id, SUM(hand) AS sum_hand FROM hand WHERE m_id = $m GROUP BY u_id) AS sh")
                    ->join('user_log AS u', 'sh.u_id = u.log_id')
                    ->where('sum_hand > 0');
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
    
    
    
    /**
     *  Return Lecture Thread only
     *
     *  @param  $m      message id
     *  @return $id     thread id
     */
    public function get_lect($m)
    {
        $result = $this->db
                    ->select('l.lect_ref AS lect_ref')
                    ->from('message AS m')
                    ->join('thread AS t', 'm.m_id = t.m_id')
                    ->join('lecture AS l', 't.lect_id = l.lect_id')
                    ->where('m_id', $m)
                    ->get()->row();
        
        return $result->lect_ref;
    }
    
    
    
    /**
     *  Return Author name, and anonymous settings
     *
     *  @param  $m      message id
     *  @return $id     thread id
     */
    public function get_author($m)
    {
        $result = $this->db
                    ->select(['u.u_name', 'm.u_show'])
                    ->from('message AS m')
                    ->join('user_log AS u', 'm.u_id = u.log_id')
                    ->where('m_id', $m)
                    ->get()->row();
        
        return $result;
    }
    
    
    
}