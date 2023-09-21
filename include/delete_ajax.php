<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
if(isset($_POST['delete']))
{
    switch($_POST['delete'])
    {
        case 'department_list':
            $success = 0;
            $sql = "delete from department where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;                
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'member_list':
            $success = 0;
            $sql = "delete from users where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
     
        case 'project_list':
            $success = 0;
            $sql = "delete from project where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'task_list':
            $success = 0;
            $sql = "delete from task where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'task_uploads':
            $success = 0;
            $sql = "delete from task_uploads where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                if(file_exists(UPLOADS_FOLDER.$_POST['file']))
                {
                    unlink(UPLOADS_FOLDER.$_POST['file']);
                }
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
        case 'task_photos':
            $success = 0;
            $sql = "delete from task_photos where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                if(file_exists(UPLOADS_FOLDER.$_POST['file']))
                {
                    unlink(UPLOADS_FOLDER.$_POST['file']);
                }
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'task_milestone':
            $success = 0;
            $sql = "delete from task_milestones where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $sql = "select file from task_uploads where task_id=:id";
                $q=$con->select_query($sql,array(':id'=>$_POST['id']));
                foreach($q as $r)
                {
                    if(file_exists(UPLOADS_FOLDER.$r['file']))
                    {
                        unlink(UPLOADS_FOLDER.$r['file']);
                    }
                }
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'project_uploads':
            $success = 0;
            $sql = "delete from project_uploads where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                if(file_exists(UPLOADS_FOLDER.$_POST['file']))
                {
                    unlink(UPLOADS_FOLDER.$_POST['file']);
                }
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'project_photos':
            $success = 0;
            $sql = "delete from project_photos where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                if(file_exists(UPLOADS_FOLDER.$_POST['file']))
                {
                    unlink(UPLOADS_FOLDER.$_POST['file']);
                }
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'project_milestone':
            $success = 0;
            $sql = "delete from project_milestones where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $sql = "select file from project_uploads where project_id=:id";
                $q=$con->select_query($sql,array(':id'=>$_POST['id']));
                foreach($q as $r)
                {
                    if(file_exists(UPLOADS_FOLDER.$r['file']))
                    {
                        unlink(UPLOADS_FOLDER.$r['file']);
                    }
                }
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'journal_list':
            $success = 0;
            $sql = "delete from journal where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'conference_list':
            $success = 0;
            $sql = "delete from conference where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'book_list':
            $success = 0;
            $sql = "delete from book where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'patent_list':
            $success = 0;
            $sql = "delete from patent where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
   
    }
}
?>