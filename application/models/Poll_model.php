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
        $this->db->insert('poll_vote',$data);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    
    
    /**
     *  Get text of ALL poll of a lecture
     *
     *  @param  $user   user ID
     *  @param  $lect   lect REF
     */
    public function load_poll($user, $lect)
    {
        
        // sub-query: count if user voted on OPT
        $sub = $this->db
                ->select(['o.m_id','v.opt_id','COUNT(v.p_id) AS voted'])
                ->from('poll_vote AS v')
                ->join('poll_opt AS o', 'v.opt_id = o.opt_id')
                ->where('v.u_id',$user)
                ->group_by('v.opt_id')
                ->get_compiled_select();
        
        // query: get message data, count if user voted on MESSAGE
        $query = $this->db
                    ->select([  'm.m_id',
                                'SUM(x.voted) AS u_vote',
                                'm.m_type',
                                'm.u_show',
                                'm.m_time',
                                'm.m_lastmod',
                                'm.m_body'
                             ])
                    ->from('message AS m')
                    ->join('thread AS t', 'm.t_id = t.t_id')
                    ->join('lecture AS l', 't.lect_id = l.lect_id')
                    ->join("($sub) AS x", 'm.m_id = x.m_id', 'LEFT')
                    ->where('lect_ref', $lect)
                    ->where('m_type',MESSAGE_TYPE_POLL_START)
                    ->or_where('m_type',MESSAGE_TYPE_POLL_SAVE)
                    ->or_where('m_type',MESSAGE_TYPE_POLL_STOP)
                    ->group_by('m.m_id')
                    ->order_by('m_type DESC');
        
        // get from DB
        $result = $query->get()->result_array();
        
        // return
        return $result;
        
    }
    
    
    
    /**
     *  Get text, opt, result of SINGLE poll
     *
     *  @param  $m      m_id
     *  @retuen $out    poll result
     */
    public function get_poll($m)
    {
        // poll
        $poll = $this->db
                    ->select(['o.m_id', 'm.t_id', 'm.m_type', 'm.m_body', 'm.m_time'])
                    ->from('poll_opt AS o')
                    ->join('message AS m','o.m_id = m.m_id','RIGHT')
                    ->where('o.m_id', $m)
                    ->group_by('m.m_id')
                    ->get()->row();
        
        // opt list
        $opt = $this->db
                    ->select(['o.opt_id', 'o.opt_txt', 'COUNT(p.p_id) AS vote'])
                    ->from('poll_opt AS o')
                    ->join('poll_vote AS p', 'o.opt_id = p.opt_id', 'LEFT')
                    ->where('o.m_id', $m)
                    ->group_by('o.opt_id')
                    ->get()->result_array();
        
        $out['id'] = $poll->m_id;
        $out['type'] = $poll->m_type;
        $out['poll'] = $poll;
        $out['opt'] = $opt;
        return $out;
        
    }
    
    
    
    /**
     *  Get poll id from opt_id
     *
     *  @param  $opt    opt_id
     *  @return $m_id   m_id
     */
    public function get_pollid($opt)
    {
        // query
        $sub = $this->db
                ->select('m_id')
                ->from('poll_opt')
                ->where('opt_id',$opt)
                ->get()->row();
        
        return $sub->m_id;
    }
    
    
    
    /**
     *  Get poll id from opt_id
     *
     *  @param  $opt    opt_id
     *  @return $m_id   m_id
     */
    public function update_type($m, $t)
    {
        // query
        $sub = $this->db
                ->set('m_type', $t)
                ->where('m_id', $m)
                ->update('message');
        
        if ($this->db->error() == null) {
            return FALSE;
        }
        
        return TRUE;
    }
    
    
    
    /**
     *  Validate if poll is open for voting
     */
    public function validatePoll($o)
    {
        // query
        $query = $this->db
                    ->select(['m.m_type'])
                    ->from('poll_opt AS o')
                    ->join('message AS m', 'm.m_id = o.m_id')
                    ->where("o.opt_id",$o);
        
        $result = $query->get()->row()->m_type;
        
        
        // return TRUE only if poll is started
        if ($result == MESSAGE_TYPE_POLL_START) {
            return TRUE;
        }
        
        return FALSE;
    }
    
    
    
    /**
     *  Validate User eligibility to vote the current poll
     *  
     *  @param  $u  user id
     *  @param  $o  opt id -> to find poll id
     *
     *  return TRUE when u_id NOT found
     *  return FALSE when u_id found
     */
    public function validateUser($u, $o)
    {
        // query
        $sub = $this->db
                ->select('m_id')
                ->from('poll_opt')
                ->where('opt_id',$o)
                ->get_compiled_select();
        
        $query = $this->db
                    ->select(['o.opt_id', 'v.u_id'])
                    ->from('poll_opt AS o')
                    ->join('poll_vote AS v','o.opt_id = v.opt_id','RIGHT')
                    ->where("o.m_id in ($sub)",null,false)
                    ->where("v.u_id",$u);
        
        $result = $query->get()->row();
        
        
        // return
        if ($result === null) {
            return TRUE;
        }
        return FALSE;
    }
    
    
    
}