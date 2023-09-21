<?php
include('../include/connection.php');
$note = "";
$show_team = "";
$sql = "select attention_note,show_attn_team,attention_date,attention_modify_date from project where id=:id";
$q = $con->select_query($sql,array(':id'=>$_GET['projectid']));
foreach($q as $r)
{
    $note = $r['attention_note'];
    $show_team = $r['show_attn_team'];
    $date = $r['attention_date'];
    $modify_date = $r['attention_modify_date'];
}
echo json_encode(array('note'=>$note,'show_team'=>$show_team,'date'=>date('d F, Y',strtotime($date)),'modify_date'=>date('d F, Y',strtotime($modify_date))));
?>