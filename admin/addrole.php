<?php
session_start();
include('../include/connection.php');
    if(isset($_POST['roleid']))
    {
        $sql="select roleid from user_roles where roleid=:id AND username=:uname";
        $fields=array(':uname'=>$_GET['username'], ':id'=>$_POST['roleid']);
        $q=$con->select_query($sql,$fields);
        if(!$con->rowcount > 0)
        {
            $sql="insert into user_roles (username,roleid) values (:uname,:id)";
            $fields=array(':uname'=>$_GET['username'], ':id'=>$_POST['roleid']);
            $q=$con->insert_query($sql,$fields);
        }
        
    }
    
    if(isset($_POST['remove_roleid']))
    {
        $sql="delete from user_roles where id=:id";
        $fields=array(':id'=>$_POST['remove_roleid']);
        $q=$con->delete_query($sql,$fields);
    
    }
?>

<div class="col-md-6">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th colspan="3">Current User Roles</th>
                                </tr>
                                <tr>
                                    <th>S/N</th>
                                    <th>Role</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $sql="select u.*,r.name from user_roles u left outer join roles r on u.roleid=r.id where u.username = :uname";
                                    $field=array(':uname'=>$_GET['username']);
                                    $r=$con->select_query($sql,$field);
                                    $sn=1;
                                    foreach($r as $value)
                                    {
                                       
                                        echo '<tr>
                                                <td style="font-size:12px;">'.$sn.'</td>
                                                <td>'.$value['name'].'</td>
                                                <td><input type="button" onclick="RemoveRole('.$value['id'].',\''.$_GET['username'].'\')" name="removerole" value="Remove" class="btn btn-danger btn-xs"/>
                                                </td>
                                            </tr>';
                                        $sn++;
                                    } 

                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6" id ="allroles" style="display:none">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th colspan="4">Add Roles</th>
                                </tr>
                                <tr>
                                    <th>S/N</th>
                                    <th>Code</th>
                                    <th>Role Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $sql="select * from roles where status=1 order by code";
                                    $r=$con->run_select_query($sql);
                                    $sn=1;
                                    foreach($r as $value)
                                    {
                                        $sql1="select * from user_roles where username=:uname AND roleid=:id";
                                        $fields1=array(':uname'=>$_GET['username'], ':id'=>$value['id']);
                                        $q1=$con->select_query($sql1,$fields1);
                                        if(!count($q1) > 0)
                                        {
                                            echo '<tr>
                                                <td style="font-size:12px;">'.$sn.'</td>
                                                <td>'.$value['code'].'</td>
                                                <td>'.$value['name'].'</td>
                                                <td><input type="button" onclick="AddRole('.$value['id'].',\''.$_GET['username'].'\')" name="addrole" value="Add" class="btn btn-warning btn-xs"/>
                                                </td>
                                            </tr>';
                                            $sn++;
                                        }
                                        
                                    } 

                                ?>
                            </tbody>
                        </table>
                    </div>