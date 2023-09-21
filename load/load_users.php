<?php
session_start();
$menu = "tuser";
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');
include('../lib/dbconfig.php');

$sql="select * from users where role =:admin order by email";
$r=$con->select_query($sql, array(':admin'=>ADMIN_USER_KEY));
$sn=1;
foreach($r as $value)
{
    if($value['is_active']==1)
    {
        $status="<span class='label label-primary'>Active</span>";
    }
    else
    {
        $status="<span class='label label-default'>Inactive</span>";
    }
    $role_list = $auth->GetRoleNames($value['id']);
    $user_role = "";
    foreach($role_list as $role)
    {
        $user_role = $role.', ';
    }
     
    echo '<tr>
                                                                <td style="font-size:12px;">'.$sn.'</td>
                                                                <td>'.$value['email'].'</td>
                                                                <td>'.$value['firstname'].' '.$value['lastname'].'</td>
                                                                <td>'.$user_role.'</td>
                                                                <td>'.$value['date_created'].'</td>
                                                                <td>'.$status.'</td>';
    if($value['email'] != "admin")
    {
        if($authupdate)
        {
            echo '<td>
                                                                    <form method="post" action="../admin/user_setup">
                                                                        <input type="hidden" name="userid" value="'.$value['id'].'"/>
                                                                        <input type="submit" name="user" value="Edit" class="btn btn-warning btn-sm"/>
                                                                    </form>
                                                                </td>';
        }
        if($authdelete)
        {
                                                               echo '<td><button onclick="Delete('.$value['id'].')" class="btn btn-danger btn-sm">Delete</button>
                                                                </td>';
        }
    }
    else
    {
        if($authupdate)
        {
                echo '<td>
                                                                    <input type="button" value="Edit" class="btn btn-warning btn-sm disabled"/>
                                                                </td>';
        }
        if($authdelete)
        {
                                                               echo '<td>
                                                                    <input type="button" value="Delete" class="btn btn-danger btn-sm disabled"/>
                                                                </td>';
        }
    }
    echo '</tr>';
    $sn++;
}
?>