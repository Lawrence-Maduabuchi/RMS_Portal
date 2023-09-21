<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/custom.php');
$success = 0;

$project_title = "";
$leader_email = "";
$sql = "select p.title,attention_date,u.email from project p inner join users u on p.team_leader_id=u.id where p.id=:id";
$q = $con->select_query($sql,array(':id'=>$_GET['projectid']));
foreach($q as $r)
{
    $project_title = $r['title'];
    $leader_email = $r['email'];
}

if($_GET['type'] == "close")
{
    $sql = "update project set admin_status=0,attention_status = :closed,attention_modify_date=:date where id=:id";
    $q = $con->update_query($sql,array(':closed'=>CLOSED_ATTENTION,':date'=>date('d-m-Y H:i a'), ':id'=>$_GET['projectid']));
    if($q)
    {
        $success = 1;
        
        //send message
        $title = "Attention Closed";
        $body = "The attention added to the your project has been closed. Project details:<br/>";
        $body.='<strong>Project Title</strong>: '.$project_title.'</br/><strong>Current Status</strong>: Attention Closed';
        
        SendMessageToQueue($title,$leader_email,"AFIT_RMS",$body,$con);
        
        //update archive
        $aid = 0;
        $sql = "select id from attention where project_id=:id AND type=:type order by id DESC limit 1";
        $q = $con->select_query($sql,array(':id'=>$_GET['projectid'],':type'=>PROJECT_TYPE));
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
    $sql = "update project set admin_status=:att,attention_status = :open,attention_modify_date=:date where id=:id";
    $q = $con->update_query($sql,array(':att'=>ATTENTION_REQUIRED,':open'=>OPEN_ATTENTION,':date'=>date('d-m-Y H:i a'), ':id'=>$_GET['projectid']));
    if($q)
    {
        $success = 1;
        
        //send message
        $title = "Attention Opened";
        $body = "The attention added to the your project has been opened. Project details:<br/>";
        $body.='<strong>Project Title</strong>: '.$project_title.'</br/><strong>Current Status</strong>: Attention Required';
        
        SendMessageToQueue($title,$leader_email,"AFIT_RMS",$body,$con);
        
        //update archive
        $aid = 0;
        $sql = "select id from attention where project_id=:id AND type=:type order by id DESC limit 1";
        $q = $con->select_query($sql,array(':id'=>$_GET['projectid'],':type'=>PROJECT_TYPE));
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