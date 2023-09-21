<?php
class database
{
    private $db=Null;
    public $lastID;
    public $rowcount;
    public $num_rows;

    public function __construct($dbname,$host,$username,$password)
    {
        $this->db=new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function insert_query($sql,$fields=array())
    {
        try {
            $query=$sql;
            $q=$this->db->prepare($query);
            $r=$q->execute($fields);
            $this->lastID = $this->db->lastInsertId();
            $this->num_rows = $q->rowCount();
            return $r;
        }
        catch(PDOException $p)
        {
            echo $p->getMessage();
        }
        
    }
    
    public function select_query($sql,$fields=array())
    {
        try {
            $query=$sql;
            $q=$this->db->prepare($query);
            $q->execute($fields);
            $r= $q->fetchAll();
            $this->rowcount=count($r);
            return $r;
        }
        catch(PDOException $p)
        {
            echo $p->getMessage();
        }
    
    }
    
    public function one_select_query($sql,$fields=array())
    {
        try {
            $query=$sql;
            $q=$this->db->prepare($query);
            $q->execute($fields);
            $r=$q->fetch();
            $this->rowcount=count($r);
            return $r;
        }
        catch(PDOException $p)
        {
            echo $p->getMessage();
        }
    
    }
    
    public function run_select_query($sql)
        {
            try {
                $query=$sql;
                $q=$this->db->query($query);
                $q->execute();
                $r=$q->fetchAll();
                $this->rowcount=count($r);
                return $r;
            }
            catch(PDOException $p)
            {
                echo $p->getMessage();
            }
        
        }
    
    public function count_select_query($sql,$fields=array())
    {
        try {
            $query=$sql;
            $q=$this->db->prepare($query);
            $q->execute($fields);
            return $q->rowCount();
        }
        catch(PDOException $p)
        {
            echo $p->getMessage();
        } 
    }
    
    public function update_query($sql,$fields=array())
    {
        try {
            $query=$sql;
            $q=$this->db->prepare($query);
            $r = $q->execute($fields);
            $this->num_rows = $q->rowCount();
            return $r;
        }
        catch(PDOException $p)
        {
            echo $p->getMessage();
        }
    
    }
    
    public function delete_query($sql,$fields=array())
    {
        try {
            $query=$sql;
            $q=$this->db->prepare($query);
            $r=$q->execute($fields);
            $this->num_rows = $q->rowCount();
            return $r;
        }
        catch(PDOException $p)
        {
            echo $p->getMessage();
        }
    
    }
    
}
    
  
?>