<?php
class USER
{
    private $db;
    public $attempts;
    public $errormsg = array();
    public $lastuser;
 
    function __construct(\database $DB_con)
    {
      $this->db = $DB_con;
    }
 
    public function register($umail,$upass,$repeatpass,$phone,$status,$role,$firstname,$lastname)
    {
       try
       {
           if($upass != $repeatpass)
           {
               $this->errormsg[] = "Passwords do not match";
               return false;
           }
           $sql = "select id from users where email=:email";
           $q=$this->db->select_query($sql,array(':email'=>$umail));
           if(count($q) > 0)
           {
               $this->errormsg[] = "Email already registered";
               return false;
           }
           $new_password = Sha1($upass);
   
           $sql="INSERT INTO users(email,phone,pword,is_active,role,date_created,firstname,lastname) 
                                                       VALUES(:umail, :phone, :upass, :status, :role, :date, :fname, :lname)";
           $fields=array(
               ':umail'=>$umail,
               ':phone'=>$phone,
               ':upass'=>$new_password,
               ':status'=>$status,
               ':role'=>$role,
               ':date'=>date('d-m-Y'),
               ':fname'=>$firstname,
               ':lname'=>$lastname
           );
           $q=$this->db->insert_query($sql,$fields); 
           $this->lastuser=$this->db->lastID;  
           return $q; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
 
    public function login($umail,$upass)
    {

           $sql="SELECT * FROM users WHERE email=:uname LIMIT 1";
           $field=array(':uname'=>$umail);
           $r=$this->db->select_query($sql,$field);
           if($this->db->rowcount > 0)
           {
               foreach($r as $q)
               {
                   //if(password_verify($upass, $q['pword']))
                   if(sha1($upass) == $q['pword'] || (password_verify($upass, $q['pword'])))
                   {
                       if($q['is_active'] == 0)
                       {
                           $this->errormsg[] = "Account is inactive.";
                           return false;
                       }
                       else
                       {
                           $_SESSION['user_session'] = $q['email'];
                           $_SESSION['user_role']=$q['role'];
                           $_SESSION['user_id']=$q['id'];
                           //$this->newsession($userRow['username']);
                                                  
                           return true;
                       }
                        
                   }
                   else
                   {
                       $this->errormsg[] = "Incorrect Password";
                       return false;
                   }
               }
           }
           else
           {
               $this->errormsg[] = "Incorrect Username";
               return false;
           }
          
               
   }
   
   public function updateUser($userid,$umail,$status,$role,$firstname,$lastname)
   {
       try
       {
           $sql = "select id from users where email=:email AND id!=:userid";
           $q=$this->db->select_query($sql,array(':email'=>$umail,':userid'=>$userid));
           if(count($q) > 0)
           {
               $this->errormsg[] = "Email already registered";
               return false;
           }
           $sql="update users set email=:umail,is_active=:status,role=:role,firstname=:fname,lastname=:lname where id=:userid";
           $fields=array(
               ':umail'=>$umail,
               ':status'=>$status,
               ':role'=>$role,
               ':fname'=>$firstname,
               ':lname'=>$lastname,
               ':userid'=>$userid
           );
           $q=$this->db->update_query($sql,$fields);
           return $q;
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }
   
   public function ResetPassword($new_password, $email, \database $con)
   {
       $new_password = Sha1($new_password);
       $sql = "update users set pword = :pword where email = :email";
       $q=$con->update_query($sql,array(':pword'=>$new_password,':email'=>$email));
       if($q)
       {
           return true;
       }
       return false;
   }
   
   public function is_loggedin()
   {
      if(isset($_SESSION['user_session']))
      {
         return true;
      }
      return false;
   }
   
   /*
    * Creates a new session for the provided username and sets cookie
    * @param string $username
    */
   
   function newsession($username)
   {
       include("auth_config.php");
   
       $hash = md5(microtime());
   
       // Fetch User ID :
       $stmt = $this->db->prepare("SELECT id,username FROM users WHERE username=:uname");
       $stmt->execute(array(':uname'=>$username));
       $q=$stmt->fetch(PDO::FETCH_ASSOC);
       $count=$stmt->rowCount();
       $uid=$q['id'];
       
       // Delete all previous sessions :
       $stmt = $this->db->prepare("DELETE FROM sessions WHERE username=:uname");
       $stmt->execute(array(':uname'=>$username));       

       $ip = $_SERVER['REMOTE_ADDR'];
       $expiredate = date("Y-m-d H:i:s", strtotime($auth_conf['session_duration']));
       $expiretime = strtotime($expiredate);
       
       $stmt = $this->db->prepare("INSERT INTO sessions (uid, username, hash, expiredate, ip)
                                                       VALUES(:uid,:uname,:hash,:expdate,:ip)");
       
       $stmt->bindparam(":uid", $uid);
       $stmt->bindparam(":uname", $username);
       $stmt->bindparam(":hash", $hash);
       $stmt->bindparam(":expdate", $expiredate);
       $stmt->bindparam(":ip", $ip);
       $stmt->execute();

       setcookie("auth_session", $hash, $expiretime);
   }
   
 
   public function redirect($url)
   {
       header("Location: $url");
   }
 
   public function logout()
   {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
   }
}
?>