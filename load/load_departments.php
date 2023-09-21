<?php
session_start();
$menu = "acategory";
include('../include/connection.php');
include('../include/app_config.php');
require_once '../lib/dbconfig.php';
include('../lib/app_stat.php');

$sql="select * from department";

$conditions = array();
$departments=array();
if(isset($_GET['status']) && $_GET['status'] !="") {
    $conditions[] = "status=:status";
    $departments[':status']=$_GET['status'];
}

if(isset($_GET['searchkey']) && $_GET['searchkey'] !="") {
    $conditions[] = "(code like :searchkey OR name like :searchkey)";
    $keyword = '%'.$_GET['searchkey'].'%';
    $departments[':searchkey'] = $keyword;
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " order by name";
$r=$con->select_query($sql,$departments);
$sn=1;
foreach($r as $value)
{
        if($value['status']==1)
        {
            $status="<span class='badge badge-success'>Active</span>";
        }
        else
        {
            $status="<span class='badge badge-secondary'>Not Published</span>";
        }
        
        
        echo '<tr>
                <td style="font-size:12px;">'.$sn.'</td>
                <td>'.$value['code'].'</td>
                <td>'.$value['name'].'</td>
                <td>'.$status.'</td>
                <td>'.$value['date_created'].'</td>';
        if($authupdate)
        {
             echo '<td><a href="department_setup?id='.$value['id'].'" class="btn btn-warning btn-sm">Edit</a></td>';
        }
        if($authdelete)
        {
             echo '<td><button onclick="Delete('.$value['id'].')" class="btn btn-danger btn-sm">Delete</button></td>';
        }
             echo '</tr>';
        $sn++;

}

?>