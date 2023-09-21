<?php
include('../include/connection.php');
include('../include/app_config.php');
require_once '../lib/app_stat.php';
require_once '../lib/custom.php';

$success = 0;
$status = $_GET['status'];
$project_title = "";
$percentage = 0;

$sql = "select t.title,t.status,t.percentage_completed,u.email from task t inner join project p on t.project_id=p.id inner join users u on p.team_leader_id=u.id where t.id=:id";
$q = $con->select_query($sql,array(':id'=>$_GET['projectid']));
foreach($q as $r)
{
    $status = $r['status'];
    $project_title = $r['title'];
    $percentage = $r['percentage_completed'];
    $recipient = $r['email'];
}


if($_GET['status'] == COMPLETED_PROJECT)
{
    $sql = "update task set status=:status,percentage_completed=:perc,team_completion_date=:date where id=:id";
    $q = $con->update_query($sql,array(':status'=>$_GET['status'],':date'=>date('d-m-Y H:i A'),':perc'=>100,':id'=>$_GET['projectid']));
}
else 
{
    $sql = "update task set status=:status where id=:id";
    $q = $con->update_query($sql,array(':status'=>$_GET['status'],':id'=>$_GET['projectid']));
}
if($q)
{
        $success = 1;        
        //send message to admin
        if($_GET['status'] != $status)
        {
            if($_GET['status'] == PENDING_PROJECT)
            {
                $title = "Task Pending";
                $body = "A Task status has been changed to <strong>pending</strong>. See details below:<br/>";  
            }
            else if($_GET['status'] == ONGOING_PROJECT)
            {
                $title = "Ongoing Task";
                $body = "A Task status has been changed to <strong>ongoing</strong>. See details below:<br/>";
            }
            else if($_GET['status'] == COMPLETED_PROJECT)
            {
                $title = "Task Completed";
                $body = "A task status has been changed to <strong>completed</strong> and awaits confirmation. See details below:<br/>";
            }
            $body.='<strong>Project Title</strong>: '.$project_title.'</br/><strong>Task Status</strong>: '.$title;
            
            SendMessageToQueue($title,$recipient,"AFIT_RMS",$body,$con);
        }
}
echo json_encode(array('success'=>$success));
?>