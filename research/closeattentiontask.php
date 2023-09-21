<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/custom.php');
$success = 0;

$project_title = "";
$reciepients = array();
$sql = "select t.title,attention_date,u.email from task_members tm left outer join task t on tm.task_id=t.id left outer join users u on tm.team_member_id=u.id where t.id=:id";
                    $q = $con->select_query($sql,array(':id'=>$_GET['projectid']));
                    foreach($q as $r)
                    {
                        $project_title = $r['title'];
                        $reciepients[] = $r['email'];
                    }

if($_GET['type'] == "close")
{
    $sql = "update task set leader_status=0,attention_status = :closed,attention_modify_date=:date where id=:id";
    $q = $con->update_query($sql,array(':closed'=>CLOSED_ATTENTION,':date'=>date('d-m-Y H:i a'), ':id'=>$_GET['projectid']));
    if($q)
    {
        $success = 1;
        
        //send message
        $title = "Attention Closed";
        $body = "The attention added to the your task has been closed. Task details:<br/>";
        $body.='<strong>Task Title</strong>: '.$project_title.'</br/><strong>Current Status</strong>: Attention Closed';
        
        foreach($reciepients as $email)
        {
            SendMessageToQueue($title,$email,"AFIT_RMS",$body,$con);
        }
        
        //update archive
        $aid = 0;
        $sql = "select id from attention where project_id=:id AND type=:type order by id DESC limit 1";
        $q = $con->select_query($sql,array(':id'=>$_GET['projectid'],':type'=>TASK_TYPE));
        foreach($q as $r)
        {
            $aid = $r['id'];
        }
        $sql = "update attention set attention_status=".CLOSED_ATTENTION.", close_date=:date where id = :id";
        $con->update_query($sql,array(':date'=>date('d-m-Y H:i A'), ':id'=>$aid));
    }
    echo json_encode(array('success'=>$success));
}
else if($_GET['type'] == "open")
{
    $sql = "update task set leader_status=:att,attention_status = :open,attention_modify_date=:date where id=:id";
    $q = $con->update_query($sql,array(':att'=>ATTENTION_REQUIRED,':open'=>OPEN_ATTENTION,':date'=>date('d-m-Y H:i a'), ':id'=>$_GET['projectid']));
    if($q)
    {
        $success = 1;
        
        //send message
        $title = "Attention Opened";
        $body = "The attention added to the your task has been opened. Task details:<br/>";
        $body.='<strong>Task Title</strong>: '.$project_title.'</br/><strong>Current Status</strong>: Attention Required';
        
        foreach($reciepients as $email)
        {
            SendMessageToQueue($title,$email,"AFIT_RMS",$body,$con);
        }
        
        //update archive
        $aid = 0;
        $sql = "select id from attention where project_id=:id AND type=:type order by id DESC limit 1";
        $q = $con->select_query($sql,array(':id'=>$_GET['projectid'],':type'=>TASK_TYPE));
        foreach($q as $r)
        {
            $aid = $r['id'];
        }
        $sql = "update attention set attention_status=".OPEN_ATTENTION.", close_date='' where id = :id";
        $con->update_query($sql,array(':id'=>$aid));
    }
    echo json_encode(array('success'=>$success));
}
?> 