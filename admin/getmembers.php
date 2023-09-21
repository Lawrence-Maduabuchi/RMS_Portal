<?php
include('../include/connection.php');

$sql = "select id,firstname,lastname,othernames from users where is_active = 1 AND department_id=:id order by firstname";
$q = $con->select_query($sql,array(':id'=>$_GET['department_id']));
foreach($q as $r)
{
    $othername = $r['othernames'] != "" ? ' '.$r['othernames'].' ' : " ";
    echo '<option value="'.$r['id'].'">'.$r['firstname'].$othername.$r['lastname'].'</option>';
}
?>