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