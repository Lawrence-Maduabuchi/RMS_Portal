<?php
include('../include/connection.php');
include('../include/app_config.php');
$success = 0;
$sql = 'update project set admin_status = 0, attention_note="",attention_date="",show_attn_team=0,attention_modify_date="",	attention_status=0 where id=:projectid';
$q = $con->update_query($sql,array(':projectid'=>$_POST['projectid']));
if($q)
{
    $success = 1;
    
    //delete from archive
    $aid = 0;
    $sql = "select id from attention where project_id=:id AND type=:type order by id DESC limit 1";
    $q = $con->select_query($sql,array(':id'=>$_POST['projectid'],':type'=>PROJECT_TYPE));
    foreach($q as $r)
    {
        $aid = $r['id'];
    }
    $sql = "delete from attention where id = :id";
    $con->update_query($sql,array(':id'=>$aid));
}
echo json_encode(array('success'=>$success));
?>