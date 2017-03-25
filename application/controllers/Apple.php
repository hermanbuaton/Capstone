<?php
defined('BASEPATH') OR exit('No direct script access allowed');



/*******************************************************************************
 *  Rake seems being reserved
 *  Use Apple as Controller name
 *******************************************************************************/
class Apple extends CI_Controller {
    
    
    
    /**
     *  ============================================================
     *  constructor
     *  ============================================================
     */
    function __construct()
	{
		parent::__construct();
        
        $this->load->model('Rake_model'); 
	}
	
    
    
    /**
     *  ============================================================
     *  remap
     *  ============================================================
     */
    public function _remap($method, $params = array())
	{
		if (method_exists($this, $method))
		{
			return call_user_func_array(array($this, $method), $params);
		}
		$this->index($method);
	}
	
    
    
    /**
     *  ============================================================
     *  index
     *  ============================================================
     */
    public function index()
    {
        $post = $_POST;
        
        $text = $post['input-message-head'] . ' \n' . $post['input-message-body'];
        
        $result = $this->Rake_model->extract($text);
        
        echo var_dump($result);
    }
    
    
    
    /**
     *  ============================================================
     *  update stopwords list
     *  TODO: allow user input
     *  ============================================================
     */
    public function update()
    {
        
        // create new version in db
        $time = date(DATE_RFC3339);
        $ver = $this->Rake_model->version_post($time);
        
        // TODO: allow user input
        // read file
        $file = base_url('rake/stoplist_smart.txt');
        $list = $this->read_file($ver, $file);
        
        // send to model
        $this->Rake_model->words_post($list);
        
        echo 'Done <br/>';
        var_dump($list);
        
    }
    
    
    
    /**
     *  ============================================================
     *  read stopwords from a .txt file
     *  
     *  Ref:
     *      see license-rake.txt
     *      & comments in Rake_model.php
     *
     *  @param  $path   [string]    file path to .txt file
     *  @return $words  [array]     all words from file
     *  ============================================================
     */
    private function read_file($ver, $path)
	{
        // init array for words
        $words = array();
        
        // open text file
		if ($h = @fopen($path, 'r')) {
            
            // read line by lines
			while (($line = fgets($h)) !== false) {
                
				$line = trim($line);
                
				if ($line[0] != '#') {
                    $data = array("ver_id"=>$ver, "word"=>$line);
					array_push($words, $data);
				}
                
			}
            
            // return
			return $words;
            
		} else {
            echo 'Error: could not read file "'. $path. '".';
            return false;
        }
	}
    
    
    
    //  For TESTING purpose
    public function pie()
    { 
        var_dump($this->Rake_model->load_stopwords());
    }
    
    
    
}

?>