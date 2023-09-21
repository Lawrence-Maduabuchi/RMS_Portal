<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/custom.php');

$success = 0;
$sql = "update project set admin_status=:confirmed,completion_date=:date where id=:id";
$q = $con->update_query($sql,array(':confirmed'=>CONFIRMED,':date'=>date('d-m-Y H:i A'), ':id'=>$_POST['id']));
if($q)
{
    $success = 1;
    
    //send mail
    $title = "Project Confirmed as completed";
    $body = "Dear ".$_POST['firstname']."<br/> Your project has been confirmed as complete.<br/><br/>";
    $body .= "<strong>Project Title: </strong>".$_POST['title'].'<br/>';
    $body .= "<strong>Status: </strong> Complete & Confirmed.<br/><br/>";
    $body .= "Admin.<br/>AFIT-RMS";
    
    SendMessageToQueue($title,$_POST['leader_email'],"AFIT-RMS",$body,$con);
}
echo json_encode(array('success'=>$success));
?>