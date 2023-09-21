<?php
if(isset($_GET['delete']))
{
    session_start();
    include('../include/connection.php');
    switch ($_GET['delete'])
    {
        case 'mda_list':
            $sql = "delete from mda where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_GET['id']));
            if($q)
            {
                echo '<script>window.location="../admin/mda_list"</script>';
            }
            break;
            
        case 'contractor_setup':
            $sql = "delete from contractors where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_GET['id']));
            if($q)
            {
                echo '<script>window.location="../admin/contractor_list"</script>';
            }
            break;
            
            
         
    }
}

if(isset($_POST['delete']))
{
    switch ($_POST['delete'])
    {
        case 'lawmakers':
            $sql = "delete from lawmakers where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['lawmakerid']));
            if($q)
            {
                echo '<script>window.location="../admin/lawmakers_list"</script>';
            }
            break;
            
        case 'projects':
            $sql = "delete from projects where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['projectid']));
            if($q)
            {
                echo '<script>window.location="../admin/project_list"</script>';
            }
            break;
            case 'deleteuser':
                $sql="delete from users where id=:id";
                $fields=array(':id'=>$_POST['userid']);
                if($con->delete_query($sql,$fields))
                {
                    echo '<script>window.location="../admin/users"</script>';
                }
                break;
    }
}
?>