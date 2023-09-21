<?php
class Register
{
    private $db;
    public $attempts;
    public $errormsg = array();
 
    function __construct(\database $DB_con)
    {
      $this->db = $DB_con;
    }
 
    public function start_reg($userid)
    {
        $_SESSION['reg_user_id']=$userid;
        $_SESSION['registration_in_progress'] = true;
        $_SESSION['registration_ended'] = false;
    }
    
    public function end_reg()
    {
        unset($_SESSION['reg_user_id']);
        $_SESSION['registration_in_progress'] = false;
        $_SESSION['registration_ended'] = true;
        unset($_SESSION['pic']);
    }
    
    public function reg_on()
    {
        if(isset($_SESSION['reg_user_id']) && $_SESSION['registration_in_progress'] == true)
        {
            return true;
        }
        return false;
    }
}
?>