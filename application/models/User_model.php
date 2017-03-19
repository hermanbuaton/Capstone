<?php

class User_model extends CI_Model {
    
    
    
    public function __construct()
    {
            parent::__construct();
            // Your own constructor code
    }
    
    
    
    /**
     *  Store NEW acct into db
     *  
     *  @param  $data   array with username, nickname, password, u_type
     *  @retuen $out    [message] any error message or "Success"
     *  @retuen $out    [id] id in [user] table
     */
    public function create_user($data)
    {
        // TODO: check if user exists
        $name = $data['u_name'];
        
        if ($this->check_username($name) === TRUE) {
            
            // name DO NOT exist
            $this->db->insert('user', $data);
            $out['message'] = 'Success';
            $out['id'] = $this->db->insert_id();
        
        } else {
            
            // name DO exist
            $out['message'] = 'Username already existed.';
            
        }
        
        // return
        return $out;
    }
    
    
    
    /**
     *  Validate if username already exists
     *  
     *  @param  $in [str]   inputted username
     *  @return _BOOLEAN    true when does not exist, false when already exist
     */
    public function check_username($in)
    {
        // count username
        $result = $this->db
                    ->select('COUNT(*) AS EXIST')
                    ->from('user')
                    ->where('u_name', $in)
                    ->get()->row();
        $count = intval($result->EXIST);
        
        // return
        if ($count == 0)
            return true;
        // else
        return false;
    }
    
    
    
    /**
     *  Validate if username already exists
     *  
     *  @param  $in [str]   inputted username
     *  @return _BOOLEAN    true when does not exist, false when already exist
     */
    public function validate_user($id, $pw)
    {
        $result = $this->db
                    ->select('u_id')
                    ->from('user')
                    ->where('u_name',$id)
                    ->where('u_pass',$pw)
                    ->get()->row();
        
        if ($result->u_id !== NULL) {
            return $result->u_id;
        }
        
        return FALSE;
    }
    
    
    
    /**
     *  Record user actions in db
     *  
     *  @param  $data   [str]   array w/ nickname, class code
     *  @return $id     [str]   id in [user_log] table
     */
    public function record_signin($data)
    {
        $this->db->insert('user_log', $data);
        
        $id = $this->db->insert_id();
        return $id;
    }
    
    
    
    /**
     *  Return u_id using log_id
     */
    public function get_userid($log_id)
    {
        $result = $this->db
                    ->select('u_id')
                    ->from('user_log')
                    ->where('log_id',$log_id)
                    ->get()->row();
        
        return $result->u_id;
    }
    
    
    
    /**
     *  Return sch_id using u_id
     */
    public function get_schid($u_id)
    {
        $result = $this->db
                    ->select('sch_id')
                    ->from('user')
                    ->where('u_id',$u_id)
                    ->get()->row();
        
        return $result->sch_id;
    }
    
    
    
    /**
     *  get list of semester base on user id and sch id
     */
    public function get_semester($user)
    {
        $result = $this->db
                    ->select(['DISTINCT(sem_id)', 'sem_code', 'sem_name'])
                    ->from('semester AS s')
                    ->join('user AS u','s.sch_id = u.sch_id')
                    ->where('u.u_id',$user)
                    ->get()->result_array();
        
        return $result;
    }

}