<?php
class authorize
{
    public $user;
    public $db;
    function __construct(\database $DB_con, $user)
    {
      $this->db = $DB_con;
      $this->user = $user;
    }
    
    function MenuIsActive($menucode)
    {
        $sql = "select status from menuitem where Code=:code AND status = 1";
        $q = $this->db->select_query($sql,array(':code'=>$menucode));
        if(count($q) > 0)
        {
            return true;
        }
        return false;
    }
    
    function GroupIsActive($groupcode)
    {
        $sql = "select status from menugroup where Code=:code AND status = 1";
        $q = $this->db->select_query($sql,array(':code'=>$groupcode));
        if(count($q) > 0)
        {
            return true;
        }
        return false;
    }
    
    function HasGroupView($groupcode)
    {
        $i=0;
        if(!$this->GroupIsActive($groupcode))
        {
            return false;
        }
        if(count($this->GetRoles()) > 0)
        {
            
            foreach($this->GetRoles() as $role)
            {
                $sql="select allow_view from roleauth where roleid=:roleid AND groupcode=:groupcode";
                $fields=array(':roleid'=>$role, ':groupcode'=>$groupcode);
                $q=$this->db->select_query($sql,$fields);
                if($this->db->rowcount > 0)
                {
                    foreach($q as $r)
                    {
                        if($r['allow_view'] == 1)
                        {
                            $i+=1;
                        }
                    }
                    
                }
            }
        }
        if($i > 0)
        {
            return true;
        }
        return false;
    }
    
    function HasView($menuid)
    {
        if(!$this->MenuIsActive($menuid))
        {
            return false;
        }
        $i=0;
        if(count($this->GetRoles()) > 0)
        {
            foreach($this->GetRoles() as $role)
            {
                $sql="select allow_view from roleauth where roleid=:roleid AND menucode=:menucode";
                $fields=array(':roleid'=>$role, ':menucode'=>$menuid);
                $q=$this->db->select_query($sql,$fields);
                if($this->db->rowcount > 0)
                {
                    foreach($q as $r)
                    {
                        if($r['allow_view'] == 1)
                        {
                            $i+=1;
                        }
                    }
                }
            }
        }
        if($i > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    
    function HasAddNew($menuid)
    {
        $i=0;
        if(count($this->GetRoles()) > 0)
        {
            foreach($this->GetRoles() as $role)
            {
                $sql="select allow_new from roleauth where roleid=:roleid AND menucode=:menucode";
                $fields=array(':roleid'=>$role, ':menucode'=>$menuid);
                $q=$this->db->select_query($sql,$fields);
                if($this->db->rowcount > 0)
                {
                    foreach($q as $r)
                    {
                        if($r['allow_new'] == 1)
                        {
                            $i+=1;
                        }
                    }
                }
            }
        }
        if($i > 0)
        {
            return true;
        }
        return false;
    }
    
    function HasUpdate($menuid)
    {
        $i=0;
        if(count($this->GetRoles()) > 0)
        {
            
            foreach($this->GetRoles() as $role)
            {
                $sql="select allow_update from roleauth where roleid=:roleid AND menucode=:menucode";
                $fields=array(':roleid'=>$role, ':menucode'=>$menuid);
                $q=$this->db->select_query($sql,$fields);
                if($this->db->rowcount > 0)
                {
                    foreach($q as $r)
                    {
                        if($r['allow_update'] == 1)
                        {
                            $i+=1;
                        }
                    }
                }
            }
        }
        if($i > 0)
        {
            return true;
        }
        return false;
    }
    
    function HasDelete($menuid)
    {
        $i=0;
        if(count($this->GetRoles()) > 0)
        {
            foreach($this->GetRoles() as $role)
            {
                $sql="select allow_delete from roleauth where roleid=:roleid AND menucode=:menucode";
                $fields=array(':roleid'=>$role, ':menucode'=>$menuid);
                $q=$this->db->select_query($sql,$fields);
                if($this->db->rowcount > 0)
                {
                    foreach($q as $r)
                    {
                        if($r['allow_delete'] == 1)
                        {
                            $i+=1;
                        }
                    }
                }
            }
        }
        if($i > 0)
        {
            return true;
        }
        return false;
    }
    
    function HasAuth($menuid)
    {
        $i=0;
        if(count($this->GetRoles()) > 0)
        {
            foreach($this->GetRoles() as $role)
            {
                $sql="select allow_auth from roleauth where roleid=:roleid AND menucode=:menucode";
                $fields=array(':roleid'=>$role, ':menucode'=>$menuid);
                $q=$this->db->select_query($sql,$fields);
                if($this->db->rowcount > 0)
                {
                    foreach($q as $r)
                    {
                        if($r['allow_auth'] == 1)
                        {
                            $i+=1;
                        }
                    }
                }
            }
        }
        if($i > 0)
        {
            return true;
        }
        return false;
    }
    
    function GetRoles()
    {
        $roles = array();
        $sql="select roleid from user_roles where userid=:id";
        
        $field=array(':id'=>$this->user);
        
        $q = $this->db->select_query($sql,$field);
        
        if($this->db->rowcount > 0)
        {
            foreach($q as $r)
            {
                $roles[]=$r['roleid'];
            }
        }
        return $roles;
    }
    
    function GetRoleNames($userid)
    {
        $roles = array();
        $sql="select r.name from user_roles ur inner join roles r on ur.roleid=r.id where ur.userid=:id";
    
        $field=array(':id'=>$userid);
    
        $q = $this->db->select_query($sql,$field);
    
        if($this->db->rowcount > 0)
        {
            foreach($q as $r)
            {
                $roles[]=$r['name'];
            }
        }
        return $roles;
    }
    
    function HasSubMenu($groupcode)
    {
        $sql="select HasMenuItems from menugroup where Code=:code";
        $q=$this->db->select_query($sql,array(':code'=>$groupcode));
        if($this->db->rowcount > 0)
        {
            foreach($q as $r)
            {
                if($r['HasMenuItems']==1)
                {
                    return true;
                }
            }
        }
        return false;
    }
}
?>