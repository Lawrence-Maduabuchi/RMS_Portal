<?php 


function GetTotalAdminUsers(\database $con)
{
    $no = 0;
    $sql = "select id from users where role=:admin";
    $q=$con->select_query($sql,array(':admin'=>ADMIN_USER_KEY));
    $no = count($q);
    return $no;
}

function GetAdminEmail(\database $con)
{
    $email = "";
    $sql = "select admin_email from settings order by id limit 1";
    $q = $con->select_query($sql);
    foreach($q as $r)
    {
        $email = $r['admin_email'];
    }
    return $email;
}

function GetUserFullName($userid,\database $con)
{
    $fullname = array();
    $firstname = "";
    $lastname = "";
    $othernames = "";
    $email = "";
    $sql = "select firstname,lastname,othernames,email from users where id=:id";
    $q = $con->select_query($sql,array(':id'=>$userid));
    foreach($q as $r)
    {
        $firstname = $r['firstname'];
        $lastname = $r['lastname'];
        $othernames = $r['othernames'];
        $email = $r['email'];
    }
    $fullname['firstname'] = $firstname;
    $fullname['lastname'] = $lastname;
    $fullname['othernames'] = $othernames;
    $fullname['email'] = $email;
    return $fullname;
}

function GetProirityText($value)
{
    $text = "";
    if($value == HIGH_PRIORITY)
    {
        $text = '<span class="badge badge-warning">High</span>';
    }
    else if($value == LOW_PRIORITY)
    {
        $text = '<span class="badge badge-info">Low</span>';
    }
    else if($value == MEDIUM_PRIORITY)
    {
        $text = '<span class="badge badge-success">Medium</span>';
    }
    else if($value == CRITICAL_PRIORITY)
    {
        $text = '<span class="badge badge-danger">Critical</span>';
    }
    return $text;
}

function GetProjectStatusText($value,$onclick="")
{
    $text = "";
    $onclickclass = "";
    if(!empty($onclick))
    {
        $onclickclass=" badge-pointer";
    }
    if($value == PENDING_PROJECT)
    {
        $text = '<span class="badge badge-default '.$onclickclass.'"'.$onclick.'>Pending</span>';
    }
    else if($value == ONGOING_PROJECT)
    {
        $text = '<span class="badge badge-warning '.$onclickclass.'"'.$onclick.'>Ongoing</span>';
    }
    else if($value == COMPLETED_PROJECT)
    {
        $text = '<span class="badge badge-success '.$onclickclass.'"'.$onclick.'>Completed</span>';
    }
    else if($value == OVERDUE_PROJECT)
    {
        $text = '<span class="badge badge-danger '.$onclickclass.'"'.$onclick.'>Overdue</span>';
    }
    return $text;
}

function GetProjectStatusTextPlain($value)
{
    $text = "";
    if($value == PENDING_PROJECT)
    {
        $text = 'Pending';
    }
    else if($value == ONGOING_PROJECT)
    {
        $text = 'Ongoing';
    }
    else if($value == COMPLETED_PROJECT)
    {
        $text = 'Completed';
    }
    else if($value == OVERDUE_PROJECT)
    {
        $text = 'Overdue';
    }
    return $text;
}

function GetAdminStatusTextPlain($value)
{
    $text = "";
    if($value == ATTENTION_REQUIRED)
    {
        $text = 'Attention Req.';
    }
    else if($value == PENDING_CONFIRMATION)
    {
        $text = 'Pending confirmation';
    }
    return $text;
}

function GetProjectStatusTextIcon($value,$append_text = "")
{
    $text = "";
    if($value == PENDING_PROJECT)
    {
        $text = '<span class="badge badge-default"><i class="ft-play-circle"></i> Pending'.$append_text.'</span>';
    }
    else if($value == ONGOING_PROJECT)
    {
        $text = '<span class="badge badge-warning"><i class="ft-layers"></i> Ongoing'.$append_text.'</span>';
    }
    else if($value == COMPLETED_PROJECT)
    {
        $text = '<span class="badge badge-success"><i class="ft-check-circle"></i> Completed'.$append_text.'</span>';
    }
    else if($value == OVERDUE_PROJECT)
    {
        $text = '<span class="badge badge-danger"><i class="ft-alert-circle"></i> Overdue'.$append_text.'</span>';
    }
    return $text;
}

function GetProjectProgress($percentage)
{
    $progress = "";
    if($percentage > 70)
    {
        $progress = '<div class="progress progress-sm" title="'.$percentage.'%">
                         <div aria-valuemin="'.$percentage.'" aria-valuemax="100" class="progress-bar bg-gradient-x-success" role="progressbar" style="width:'.$percentage.'%" aria-valuenow="'.$percentage.'"></div>
                     </div>';
    }
    else if($percentage >= 50 && $percentage < 70)
    {
        $progress = '<div class="progress progress-sm" title="'.$percentage.'%">
                         <div aria-valuemin="'.$percentage.'" aria-valuemax="100" class="progress-bar bg-gradient-x-info" role="progressbar" style="width:'.$percentage.'%" aria-valuenow="'.$percentage.'"></div>
                     </div>';
    }
    else if($percentage >= 30 && $percentage < 50)
    {
        $progress = '<div class="progress progress-sm" title="'.$percentage.'%">
                         <div aria-valuemin="'.$percentage.'" aria-valuemax="100" class="progress-bar bg-gradient-x-warning" role="progressbar" style="width:'.$percentage.'%" aria-valuenow="'.$percentage.'"></div>
                     </div>';
    }
    else 
    {
        $progress = '<div class="progress progress-sm" title="'.$percentage.'%">
                         <div aria-valuemin="'.$percentage.'" aria-valuemax="100" class="progress-bar bg-gradient-x-danger" role="progressbar" style="width:'.$percentage.'%" aria-valuenow="'.$percentage.'"></div>
                     </div>';
    }
    return $progress;
}

function GetUserNumberOfProjects($userid, \database $con)
{
    $count = 0;
    $sql = "select id from project where team_leader_id=:id AND status != :completed AND admin_status != :confirmed";
    $q = $con->select_query($sql,array(':id'=>$userid,':completed'=>COMPLETED_PROJECT, ':confirmed'=>CONFIRMED));
    $count = count($q);
    return $count;
}

function GetUserNumberOfTask($userid, \database $con)
{
    $count = 0;
    $sql = "select distinct(tm.task_id) from task_members tm left outer join task t on tm.task_id=t.id where team_member_id=:id AND t.status != :completed AND t.leader_status != :confirmed";
    $q = $con->select_query($sql,array(':id'=>$userid,':completed'=>COMPLETED_PROJECT, ':confirmed'=>CONFIRMED));
    $count = count($q);
    return $count;
}

function GetUserTotalNumberOfTask($userid, \database $con)
{
    $count = 0;
    $sql = "select distinct(tm.task_id) from task_members tm left outer join task t on tm.task_id=t.id where team_member_id=:id";
    $q = $con->select_query($sql,array(':id'=>$userid));
    $count = count($q);
    return $count;
}

function GetUserTotalNumberOfProjects($userid, \database $con)
{
    $count = 0;
    $sql = "select id from project where team_leader_id=:id";
    $q = $con->select_query($sql,array(':id'=>$userid));
    $count = count($q);
    return $count;
}


function GetProjectNumberOfTask($projectid, \database $con)
{
    $count = 0;
    $sql = "select id from task where project_id=:id";
    $q = $con->select_query($sql,array(':id'=>$projectid));
    $count = count($q);
    return $count;
}
function GetProjectNumberOfTaskStatus($projectid,$status,\database $con)
{
    $count = 0;
    $sql = "select id from task where project_id=:id AND status=:status";
    $q = $con->select_query($sql,array(':id'=>$projectid,':status'=>$status));
    $count = count($q);
    return $count;
}
function GetUserNumberOfTaskStatus($userid, $status, \database $con)
{
    $count = 0;
    $sql = "select distinct(tm.task_id) from task_members tm left outer join task t on tm.task_id=t.id where team_member_id=:id AND t.status = :status";
    $q = $con->select_query($sql,array(':id'=>$userid,':status'=>$status));
    $count = count($q);
    return $count;
}
function GetUserNumberOfProjectsStatus($userid, $status, \database $con)
{
    $count = 0;
    $sql = "select id from project where team_leader_id=:id AND status = :status";
    $q = $con->select_query($sql,array(':id'=>$userid,':status'=>$status));
    $count = count($q);
    return $count;
}
function GetNumberOfProjectsStatus($status, \database $con)
{
    $count = 0;
    $sql = "select id from project where status = :status";
    $q = $con->select_query($sql,array(':status'=>$status));
    $count = count($q);
    return $count;
}
function GetNumberOfProjectsAdminStatus($status, \database $con)
{
    $count = 0;
    $sql = "select id from project where admin_status = :status";
    $q = $con->select_query($sql,array(':status'=>$status));
    $count = count($q);
    return $count;
}
function GetTotalNumberProjects(\database $con)
{
    $count = 0;
    $sql = "select id from project";
    $q = $con->select_query($sql);
    $count = count($q);
    return $count;
}
function GetTotalMembers(\database $con)
{
    $count = 0;
    $sql = "select id from users where is_active=1 AND role != :admin";
    $q = $con->select_query($sql,array(':admin'=>ADMIN_USER_KEY));
    $count = count($q);
    return $count;
}
function GetNumberTeamMembers($projectid, \database $con)
{
    $count = 0;
    $sql = "select t.id from task_members tm left outer join task t on tm.task_id=t.id where t.project_id=:id";
    $q = $con->select_query($sql,array(':id'=>$projectid));
    $count = count($q);
    return $count;
}
function GetTotalAttentions($projectid,$type,\database $con)
{
    $count = 0;
    $sql = "select id from attention where project_id=:id AND type != :type";
    $q = $con->select_query($sql,array(':id'=>$projectid, ':type'=>$type));
    $count = count($q);
    return $count;
}
?>