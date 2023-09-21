<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/custom.php');

$success = 0;
$sql = "update task set leader_status=:confirmed,completion_date=:date where id=:id";
$q = $con->update_query($sql,array(':confirmed'=>CONFIRMED,':date'=>date('d-m-Y H:i A'), ':id'=>$_POST['id']));
if($q)
{
    $success = 1;
    
    //send mail
    $title = "Task Confirmed as completed";
    $sql = "select t.title,u.firstname,u.email from task_members tm left outer join task t on tm.task_id=t.id left outer join users u on tm.team_member_id=u.id where t.id=:id";
    $q = $con->select_query($sql,array(':id'=>$_POST['id']));
    foreach($q as $r)
    {
        
        $body = "Dear ".$r['firstname']."<br/> Your task has been confirmed as complete.<br/><br/>";
        $body .= "<strong>Task Title: </strong>".$r['title'].'<br/>';
        $body .= "<strong>Status: </strong> Complete & Confirmed.<br/><br/>";
        $body .= "Admin.<br/>AFIT-RMS";
        
        SendMessageToQueue($title,$r['email'],"AFIT-RMS",$body,$con);
    }
    
}
echo json_encode(array('success'=>$success));
?>