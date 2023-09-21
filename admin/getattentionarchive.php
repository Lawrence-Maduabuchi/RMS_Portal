<?php
include('../include/connection.php');
include('../include/app_config.php');

$sql = "select attention_note,date_created,close_date from attention where project_id=:id AND type=:type";
$q = $con->select_query($sql,array(':id'=>$_GET['projectid'],':type'=>$_GET['type']));
foreach($q as $r)
{
    echo '<div class="form-group">
            <p><span style="font-size: 11px;"><strong>Added: </strong>'.$r['date_created'].', <strong>Closed: </strong>'.$r['close_date'].'</span><br/>'.$r['attention_note'].'</p>
        </div>';
    echo '<hr/>';
        
}
?>