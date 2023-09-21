<?php
include('../include/connection.php');
include('../include/app_config.php');
require_once '../lib/app_stat.php';
require_once '../lib/custom.php';

$success = 0;
$status = $_GET['status'];
$project_title = "";
$percentage = 0;
$sql = "select title,status,percentage_completed from project where id=:id";
$q = $con->select_query($sql,array(':id'=>$_GET['projectid']));
foreach($q as $r)
{
    $status = $r['status'];
    $project_title = $r['title'];
    $percentage = $r['percentage_completed'];
}

if($_GET['status'] == COMPLETED_PROJECT)
{
    $sql = "update project set status=:status,percentage_completed=:perc,leader_completion_date=:date where id=:id";
    $q = $con->update_query($sql,array(':status'=>$_GET['status'],':date'=>date('d-m-Y H:i A'),':perc'=>100,':id'=>$_GET['projectid']));
}
else 
{
    $sql = "update project set status=:status where id=:id";
    $q = $con->update_query($sql,array(':status'=>$_GET['status'],':id'=>$_GET['projectid']));
}
if($q)
{
        $success = 1;        
        //send message to admin
        if($_GET['status'] != $status)
        {
            $admin_email = GetAdminEmail($con);
            if($_GET['status'] == PENDING_PROJECT)
            {
                $title = "Project Pending";
                $body = "A project status has been changed to <strong>pending</strong>. See details below:<br/>";
            }
            else if($_GET['status'] == ONGOING_PROJECT)
            {
                $title = "Ongoing Project";
                $body = "A project status has been changed to <strong>ongoing</strong>. See details below:<br/>";
            }
            else if($_GET['status'] == COMPLETED_PROJECT)
            {
                $title = "Project Completed";
                $body = "A project status has been changed to <strong>completed</strong> and awaits confirmation. See details below:<br/>";
            }
            $body.='<strong>Project Title</strong>: '.$project_title.'</br/><strong>Project Status</strong>: '.$title;
            
            SendMessageToQueue($title,$admin_email,"AFIT_RMS",$body,$con);
        }
}
echo json_encode(array('success'=>$success));
?>