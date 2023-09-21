<?php
require_once('phpmailer_5.2.4/class.phpmailer.php');
require ('phpmailer_5.2.4/class.smtp.php');
include('connection.php');
include('lib/app_stat.php');
include('lib/custom.php');

$sql = "select * from message";
$q = $con->select_query($sql);
foreach($q as $r)
{
    $send = SendMessage($r['title'], $r['recipient'], $r['sendername'], $r['body']);
    if($send)
    {
        $sql = "delete from message where id=:id";
        $con->delete_query($sql,array(':id'=>$r['id']));
    }
}
?>