<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');
require_once '../lib/dbconfig.php';
include('../lib/custom.php');
if(isset($_POST['update']))
{
    switch ($_POST['update'])
    {   
        
        case 'department_setup':
            $success = 0;
            $msg = "";
            $status = 0;
            if(isset($_POST['status']))
            {
                $status = 1;
            }
            if(!empty($_POST['name']) && !empty($_POST['code']))
            {
                $sql = "update department set code=:code,name=:name,status=:status where id=:id";
                $q = $con->insert_query($sql, array(':code'=>$_POST['code'], ':name'=>$_POST['name'], ':status'=>$status, ':id'=>$_POST['id']));
                if($q)
                {
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Institution successfully saved.
                            </div>';
                    $success = 1;
                }
            }
            else
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required fields.
                        </div>';
            }
            echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
        case 'member_setup':
            $status=0;
            $success = 0;
            $file_error = 0;
            $msg = "";
            if(isset($_POST['status']))
            {
                $status=1;
            }
            
            if(isset($_FILES['photo']) && !empty($_FILES['photo']))
            {
                $isvalidsize = filesize($_FILES['photo']['tmp_name']) <= MAX_FILE_SIZE;
                if(!$isvalidsize)
                {
                    $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Photo size cannot exceed 10MB.
                            </div>';
                    echo json_encode(array('success'=>$success,'msg'=>$msg));
                    return;
                }
            }
                        
            $sql="update users set title=:title,firstname=:firstname, lastname=:lastname, othernames=:onames, 
                phone=:phone,department_id=:deptid,is_active=:status where id=:id";
            $fields=array(
                ':title'=>$_POST['title'],
                ':firstname'=>$_POST['firstname'], 
                ':lastname'=>$_POST['lastname'], 
                ':onames'=>$_POST['othernames'],
                ':phone'=>$_POST['phone'],
                ':deptid'=>$_POST['dept_id'],
                ':status'=>$status,
                ':id'=>$_POST['id']
            );
            if($con->update_query($sql,$fields))
            {
                $success = 1;
                $user_id = $_POST['id'];
                if(isset($_FILES['photo']) && !empty($_FILES['photo']))
                {
                    $ext=pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                    if(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0 || strcasecmp($ext, "gif") == 0)
                    {
                        $photo = "member".$user_id.'.jpg';
                        move_uploaded_file($_FILES['photo']['tmp_name'], UPLOADS_FOLDER.$photo);
                        $sql = "update users set photo=:img where id=:id";
                        $con->update_query($sql,array(':img'=>$photo,':id'=>$user_id));
                    }
                    else
                    {
                        $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                        <strong>Error!</strong> Photo not in correct format (jpg, jpeg, png or gif).
                                    </div>';
                    }
                }
                else if(empty($_POST['oldphoto']))
                {
                   $msg .= '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Note:</strong> No photo uploaded.
                        </div>';
                }
                
                $msg .= '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Member successfully updated.
                            </div>';
            }
            echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
        case 'project_setup':
            $success = 0;
            $msg = "";
             
            if(!empty($_POST['code']) && !empty($_POST['title'])  && !empty($_POST['desc']) && !empty($_POST['startdate']) && !empty($_POST['duedate']) && !empty($_POST['dept_id']))
            {
                $sql = "update project set
                    code=:code,title=:title,description=:desc,start_date=:start,due_date=:due,
                    department_id=:dept,team_leader_id=:lead,co_leader_id=:co,max_team_members=:max,
                    priority=:priority where id=:id";
                $fields = array(
                    ':code'=>$_POST['code'],
                    ':title'=>$_POST['title'],
                    ':desc'=>$_POST['desc'],
                    ':start'=>$_POST['startdate'],
                    ':due'=>$_POST['duedate'],
                    ':dept'=>$_POST['dept_id'],
                    ':lead'=>$_POST['team_leader'],
                    ':co'=>$_POST['co_leader'],
                    ':max'=>$_POST['maxteam'],
                    ':priority'=>$_POST['priority'],
                    ':id'=>$_POST['id']
                );
                $q = $con->update_query($sql,$fields);
                if($q)
                {
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Project successfully updated.
                            </div>';
                    $success = 1;
            
                    if($_POST['old-team-lead'] != $_POST['team_leader']) //if team leader was changed
                    {
                        //send message to team leader
                        $fullname = GetUserFullName($_POST['team_leader'], $con);  
                        $body = "<p>Dear ".$fullname['firstname'].", <br/> a project has been assigned to you on AFIT-RMS. Login to view your new project.</p>";                      
                        
                        $body .= '<br/><br/><a href="'.APP_URL.'index" style="display: inline-block; color: #fff; text-decoration:none; text-align: center; background-color: #0053a6; padding: 8px;">Login</a>';
             
                        SendMessageToQueue("New Project Assigned to You",$fullname['email'],"AFIT_RMS",$body,$con);
                        
                    }
                    
                    if($_POST['old-co-lead'] != $_POST['co_leader'])
                    {
                        $fullname2 = GetUserFullName($_POST['co_leader'], $con);
                        $body2 = "<p>Dear ".$fullname2['firstname'].", <br/> You have been made a Co-Principa Investigator on a project in AFIT-RMS. Login to view.</p>";
                        $body2 .= '<br/><br/><a href="'.APP_URL.'index" style="display: inline-block; color: #fff; text-decoration:none; text-align: center; background-color: #0053a6; padding: 8px;">Login</a>';
                        SendMessageToQueue("Co-Principal Investigator on Project",$fullname2['email'],"AFIT_RMS",$body,$con);
                    }
                }
            }
            else
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required departments.
                        </div>';
            }
            
            echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
        case 'task_setup':
            $success = 0;
            $msg = "";
             
            if(!empty($_POST['code']) && !empty($_POST['title'])  && !empty($_POST['desc']) && !empty($_POST['startdate']) && !empty($_POST['duedate']) && !empty($_POST['teamlist']))
            {
                $sql = "update task set
                    code=:code,title=:title,description=:desc,start_date=:start,due_date=:due,
                    priority=:priority where id=:id";
                $fields = array(
                    ':code'=>$_POST['code'],
                    ':title'=>$_POST['title'],
                    ':desc'=>$_POST['desc'],
                    ':start'=>$_POST['startdate'],
                    ':due'=>$_POST['duedate'],
                    ':priority'=>$_POST['priority'],
                    ':id'=>$_POST['id']
                );
                $q = $con->update_query($sql,$fields);
                if($q)
                {
                    $task_id = $_POST['id'];
                    
                    $team_members = explode(',', $_POST['teamlist']);
                    $con->delete_query("delete from task_members where task_id=:id",array(':id'=>$task_id));

                    foreach($team_members as $member)
                    {
                        $sql = "insert into task_members (team_member_id,task_id) values (:member,:task)";
                        $sq=$con->insert_query($sql,array(':member'=>$member, ':task'=>$task_id));
                        if($sq)
                        {
                            //send message to team member
                            $fullname = GetUserFullName($member, $con);
                            $body = "<p>Dear ".$fullname['firstname'].", <br/> a task has been assigned to you on the project: ".$_SESSION['project_title']." in AFIT-RMS. Login to view your new task.</p>";
                            $body .= '<br/><br/><a href="'.APP_URL.'index" style="display: inline-block; color: #fff; text-decoration:none; text-align: center; background-color: #0053a6; padding: 8px;">Login</a>';
                            SendMessageToQueue("New Task Assigned to You",$fullname['email'],"AFIT_RMS",$body,$con);
                        }
                    }
                    
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Task successfully updated.
                            </div>';
                    $success = 1;
            
                }
            }
            else
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required departments.
                        </div>';
            }
            
            echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
        case 'milestone':
            $success = 0;
            $msg = "";
            $file_large_size = 0;
            for ($i = 1; $i <= $_POST['count']; $i++)
            {
                if(isset($_FILES['uploadfileedit'.$i]) && !empty($_FILES['uploadfileedit'.$i]))
                {
                    $isvalidsize = filesize($_FILES['uploadfileedit'.$i]['tmp_name']) <= MAX_FILE_SIZE;
                    if(!$isvalidsize)
                    {
                        $file_large_size++;  //big size
                    }
                }
             }
             $file_bad_format = 0;
             for ($i = 1; $i <= $_POST['photocount']; $i++)
             {
                if(isset($_FILES['photoedit'.$i]) && !empty($_FILES['photoedit'.$i]))
                {
                    $isvalidsize = filesize($_FILES['photoedit'.$i]['tmp_name']) <= MAX_FILE_SIZE;
                    if(!$isvalidsize)
                    {
                        $file_large_size++;  //big size
                    }
                    $ext=pathinfo($_FILES['photoedit'.$i]['name'], PATHINFO_EXTENSION);
                    if(!(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0 || strcasecmp($ext, "gif") == 0))
                    {
                        $file_bad_format++;
                    }
                 }
             }
            
             if($file_large_size > 0)
             {
                    $msg .= '<div class="alert alert-danger mb-2" role="alert">
                    <strong>Error!</strong> One or more files have sizes that exceed 10MB.
                    </div>';
                    echo json_encode(array('success'=>$success,'msg'=>$msg));
                    return;
             }
             if($file_bad_format > 0)
             {
                 $msg .= '<div class="alert alert-danger mb-2" role="alert">
                    <strong>Error!</strong> One or more photos is not in correct image format (jpg, jpeg, png or gif).
                    </div>';
                 echo json_encode(array('success'=>$success,'msg'=>$msg));
                 return;
             }
            
             $table = "";
            if(!empty($_POST['percentage']))
            {
                if($_POST['type']=="task")
                {
                        $sql = "update task_milestones set task_id=:pid,description=:desc,percentage=:perc where id=:id";
                        $table1 = "task";
                }
                else if($_POST['type'] == "project")
                {
                        $sql = "update project_milestones set project_id=:pid,description=:desc,percentage=:perc where id=:id";
                                $table1 = "project";
                }
            
                $fields = array(
                    ':pid'=>$_POST['project_id'],
                    ':desc'=>$_POST['description'],
                    ':perc'=>$_POST['percentage'],
                    ':id'=>$_POST['id']
                 );
                 $q = $con->update_query($sql,$fields);
                 if($q)
                 {
                                $milestone_id = $_POST['id'];           
            
                                //update project overall percentage
                                $sql = "update ".$table1." set percentage_completed = :perc where id=:id";
                                $con->update_query($sql,array(':perc'=>$_POST['percentage'],':id'=>$_POST['project_id']));
            
                                //upload photos
                                for ($i = 1; $i <= $_POST['count']; $i++)
                                {
                                    if(isset($_FILES['uploadfileedit'.$i]) && !empty($_FILES['uploadfileedit'.$i]) && (!empty($_POST['caption'.$i])))
                                        {
                                            $file = str_replace(" ","_",$_POST['caption'.$i]).'.jpg';
                                            move_uploaded_file($_FILES['uploadfileedit'.$i]['tmp_name'], UPLOADS_FOLDER.$file);
            
                                            if($_POST['type'] == "project")
                                            {
                                                $sql = "insert into project_uploads (project_id,caption,file,project_milestone_id)
                                                        values (:pid,:caption,:file,:pmid)";
                                                $fields = array(
                                                ':pid'=>$_POST['project_id'],
                                                ':caption'=>$_POST['caption'.$i],
                                                ':file'=>$file,
                                                ':pmid'=>$milestone_id
                                            );
                                            $con->insert_query($sql,$fields);
                                        }
                                        else if($_POST['type'] == "task")
                                        {
                                                $sql = "insert into task_uploads (task_id,caption,file,task_milestone_id)
                                                        values (:pid,:caption,:file,:pmid)";
                                                $fields = array(
                                                    ':pid'=>$_POST['project_id'],
                                                    ':caption'=>$_POST['caption'.$i],
                                                    ':file'=>$file,
                                                    ':pmid'=>$milestone_id
                                                );
                                                $con->insert_query($sql,$fields);
                                         }
                                      }
                                   }
                                   
                                   
                                   //upload photos
                                   for ($i = 1; $i <= $_POST['photocount']; $i++)
                                   {
                                       if(isset($_FILES['photoedit'.$i]) && !empty($_FILES['photoedit'.$i]))
                                       {
                                           $photo = $_FILES['photoedit'.$i]['name'];
                                           move_uploaded_file($_FILES['photoedit'.$i]['tmp_name'], UPLOADS_FOLDER.$photo);
                                       
                                           if($_POST['type'] == "project")
                                           {
                                               $sql = "insert into project_photos (project_id,photo,caption,project_milestone_id)
                                                   values (:pid,:photo,:caption,:pmid)";
                                               $fields = array(
                                                       ':pid'=>$_POST['project_id'],
                                                        ':photo'=>$photo,
                                                        ':caption'=>$_POST['photocaption'.$i],
                                                        ':pmid'=>$milestone_id
                                                       );
                                                $con->insert_query($sql,$fields);
                                            }
                                            else if($_POST['type'] == "task")
                                            {
                                                $sql = "insert into task_photos (task_id,photo,caption,task_milestone_id)
                                                        values (:pid,:photo,:caption,:pmid)";
                                                $fields = array(
                                                       ':pid'=>$_POST['project_id'],
                                                       ':photo'=>$photo,
                                                       ':caption'=>$_POST['photocaption'.$i],
                                                       ':pmid'=>$milestone_id
                                                   );
                                                $con->insert_query($sql,$fields);
                                            }
                                       }
                                   }
            
                                                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                                    <strong>Well done!</strong> Task milestone successfully updated.
                                                    </div>';
                                                    $success = 1;
                                            }
            }
            else
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required departments.
                                                    </div>';
                                }
                                echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
            
            case 'attention':
            case 'attentionupdate':
                $success = 0;
                if(!empty($_POST['note']))
                {
                    $showteam = 0;
                    if(isset($_POST['showteam']))
                    {
                        $showteam = 1;
                    }
                    $date = date('d-m-Y h:i A');
                    $attn_date = date('d-m-Y h:i A');
                    $project_title = "";
                    $leader_email = "";
                    $sql = "select p.title,attention_date,u.email from project p inner join users u on p.team_leader_id=u.id where p.id=:id";
                    $q = $con->select_query($sql,array(':id'=>$_POST['projectid']));
                    foreach($q as $r)
                    {
                        $project_title = $r['title'];
                        $leader_email = $r['email'];
                        
                        if($_POST['update'] == "attentionupdate")
                        {
                            $attn_date = $r['attention_date'];
                        }
                    }
                    
                    
                    
                    
                    $sql = "update project set attention_note=:note,attention_date=:date,attention_status=1,
                        attention_modify_date=:mdate,admin_status=:attn,show_attn_team=:showteam where id=:pid";
                    
                    $fields = array(
                        ':note'=>$_POST['note'],
                        ':date'=>$attn_date,
                        ':mdate'=>$date,
                        ':attn'=>ATTENTION_REQUIRED,
                        ':showteam'=>$showteam,
                        ':pid'=>$_POST['projectid']
                    );
                    
                    $q = $con->update_query($sql,$fields);
                    
                    $success = 1;
                    $body = "";
                    
                    //send message 
                    if($_POST['update'] == "attention")
                    {
                        $title = "Attention Required in Your Project";
                        $body = "Your attention is required in your project. Project details:<br/>";
                    }
                    else if($_POST['update'] == "attentionupdate")
                    {
                        $title = "Attention Has Been Modified";
                        $body = "Attention required added to your project has been modified by admin. Project details:<br/>";
                    }
                    $body.='<strong>Project Title</strong>: '.$project_title.'</br/><strong>Project Status</strong>: Attention Required';
                    
                    SendMessageToQueue($title,$leader_email,"AFIT_RMS",$body,$con);
                    
                    //save to archive
                    if($_POST['update'] == "attention")
                    {
                        $sql = "insert into attention (date_created,attention_note,attention_status,project_id,type)
                            values (:date,:note,:status,:project,:type)";
                        $fields = array(
                            ':date'=>date('d-m-Y H:i A'),
                            ':note'=>$_POST['note'],
                            ':status'=>1,
                            ':project'=>$_POST['projectid'],
                            ':type'=>PROJECT_TYPE
                        );
                        $con->insert_query($sql,$fields);
                    }
                    else if($_POST['update'] == "attentionupdate")
                    {
                        $aid = 0;
                        $sql = "select id from attention where project_id=:id AND type=:type order by id DESC limit 1";
                        $q = $con->select_query($sql,array(':id'=>$_POST['projectid'],':type'=>PROJECT_TYPE));
                        foreach($q as $r)
                        {
                            $aid = $r['id'];
                        }
                        $sql = "update attention set attention_note=:note,attention_status=1 where id = :id";
                        $fields = array(
                            ':note'=>$_POST['note'],
                            ':id'=>$aid
                        );
                        $con->update_query($sql,$fields);
                    }
                }
                else 
                {
                    $success = 3; //required fields
                }
                echo json_encode(array('success'=>$success));
                break;
                
            case 'attentiontask':
            case 'attentionupdatetask':
                $success = 0;
                if(!empty($_POST['note']))
                {
                    $date = date('d-m-Y h:i A');
                    $attn_date = date('d-m-Y h:i A');
                    $project_title = "";
                    $reciepients = array();
                    $sql = "select t.title,attention_date,u.email from task_members tm left outer join task t on tm.task_id=t.id left outer join users u on tm.team_member_id=u.id where t.id=:id";
                    $q = $con->select_query($sql,array(':id'=>$_POST['projectid']));
                    foreach($q as $r)
                    {
                        $project_title = $r['title'];
                        $reciepients[] = $r['email'];
                
                        if($_POST['update'] == "attentionupdatetask")
                        {
                            $attn_date = $r['attention_date'];
                        }
                    }
                
                
                
                
                    $sql = "update task set attention_note=:note,attention_date=:date,attention_status=1,
                        attention_modify_date=:mdate,leader_status=:attn where id=:pid";
                
                    $fields = array(
                        ':note'=>$_POST['note'],
                        ':date'=>$attn_date,
                        ':mdate'=>$date,
                        ':attn'=>ATTENTION_REQUIRED,
                        ':pid'=>$_POST['projectid']
                    );
                
                    $q = $con->update_query($sql,$fields);
                
                    $success = 1;
                
                    $body = "";
                    $title = "";
                    //send message
                    if($_POST['update'] == "attentiontask")
                    {
                        $title = "Attention Required in Your Task";
                        $body = "Your attention is required in one of your task. Task details:<br/>";
                    }
                    else if($_POST['update'] == "attentionupdatetask")
                    {
                        $title = "Attention Has Been Modified";
                        $body = "Attention required added to your task has been modified by your team leader. Task details:<br/>";
                    }
                
                    $body.='<strong>Task Title</strong>: '.$project_title.'</br/><strong>Task Status</strong>: Attention Required';
                
                    foreach($reciepients as $email)
                    {
                        SendMessageToQueue($title,$email,"AFIT_RMS",$body,$con);
                    }
                    
                    //save to archive
                    if($_POST['update'] == "attentiontask")
                    {
                        $sql = "insert into attention (date_created,attention_note,attention_status,project_id,type)
                            values (:date,:note,:status,:project,:type)";
                        $fields = array(
                            ':date'=>date('d-m-Y H:i A'),
                            ':note'=>$_POST['note'],
                            ':status'=>1,
                            ':project'=>$_POST['projectid'],
                            ':type'=>TASK_TYPE
                        );
                        $con->insert_query($sql,$fields);
                    }
                    else if($_POST['update'] == "attentionupdatetask")
                    {
                        $sql = "update attention set attention_note=:note,
                            attention_status=1 where id IN (select id from attention
                            where project_id=:id AND type=:type order by id DESC limit 1)";
                        $fields = array(
                            ':note'=>$_POST['note'],
                            ':id'=>$_POST['projectid'],
                            ':type'=>TASK_TYPE
                        );
                        $con->update_query($sql,$fields);
                    }
                }
                else
                {
                    $success = 3; //required fields
                }
                echo json_encode(array('success'=>$success));
                break;
                
                case 'user_setup':
                    $status=0;
                    $success = 0;
                    $msg = "";
                    if(isset($_POST['status']))
                    {
                        $status=1;
                    }
                
                    if($_POST['email'] != "")
                    {
                        $reg = $user->updateUser($_SESSION['userid'], $_POST['email'], $status, "admin", $_POST['firstname'], $_POST['lastname']);
                        if($reg)
                        {
                            //insert roles
                            $con->delete_query("delete from user_roles where userid=:id", array(':id'=>$_SESSION['userid']));
                            if(!empty($_POST['rolelist']))
                            {
                                $roles = explode(',', $_POST['rolelist']);
                                foreach($roles as $role)
                                {
                                    $sql = "insert into user_roles (userid,roleid) values (:user,:role)";
                                    $q=$con->insert_query($sql,array(':user'=>$_SESSION['userid'], ':role'=>$role));
                                }
                            }
                
                            $success = 1;  //success
                        }
                        else
                        {
                            foreach($user->errormsg as $error)
                            {
                                $msg .=$error.'.';
                            }
                            $success = 4;
                        }
                    }
                    else
                    {
                        $success = 3;  //empty required fields
                    }
                    echo json_encode(array('success'=>$success,'msg'=>$msg));
                    break;
                    
                case 'settings':
                    $success = 0;
                    $msg = "";
                    if(!empty($_POST['admin_email']))
                    {
                        $sql = "update settings set admin_email=:email";
                        $q = $con->update_query($sql,array(':email'=>$_POST['admin_email']));
                        if($q)
                        {
                            $success = 1;
                            $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Settings successfully updated.
                            </div>';
                        }
                        
                    }
                    echo json_encode(array('success'=>$success,'msg'=>$msg));
                    break;
                    
                    case 'change_password':
                        $success = 0;
                        $msg = "";
                        $status = 0;
                        if(isset($_POST['status']))
                        {
                            $status = 1;
                        }
                        if($_POST['newpassword'] == $_POST['repassword'])
                        {
                            $sql = "select email,pword from users where id=:id";
                            $q = $con->select_query($sql,array(':id'=>$_SESSION['user_id']));
                            foreach($q as $r)
                            {
                                if(sha1($_POST['oldpassword']) == $r['pword'] || (password_verify($_POST['oldpassword'], $r['pword'])))
                                {
                                    $reset = $user->ResetPassword($_POST['newpassword'], $r['email'], $con);
                                    if($reset)
                                    {
                                        $msg .= '<div class="alert alert-success" id="msg">
                            <i class="fa fa-check-circle fa-fw fa-lg"></i>
                            <strong>Well done!</strong> password updated successfully.
                            </div>';
                                        $success = 1;
                                    }
                                }
                                else
                                {
                                    $msg .= '<div class="alert alert-danger" id="msg">
                                        <i class="fa fa-times-circle fa-fw fa-lg"></i>
                                        <strong>Sorry</strong> Invalid old password</a>.
                                        </div>';
                                }
                            }
                    
                        }
                        else
                        {
                            $msg .= '<div class="alert alert-danger" id="msg">
                                        <i class="fa fa-times-circle fa-fw fa-lg"></i>
                                        <strong>Sorry</strong> Passwords do not match</a>.
                                        </div>';
                        }
                        echo json_encode(array('success'=>$success,'msg'=>$msg));
                        break;
                        
                    case JOURNAL:
                        $success = 0;
                        $msg = "";
                        if(!empty($_POST['title']) && !empty($_POST['authors']) && !empty($_POST['year']))
                        {
                            $sql = "update journal set title=:title,journal_title=:jtitle,authors=:authors,year=:year,
                                vol=:vol,issue=:issue,page_no=:page,quality=:qual where id=:id";
                            $fields = array(
                                ':title'=>$_POST['title'],
                                ':jtitle'=>$_POST['jtitle'],
                                ':authors'=>$_POST['authors'],
                                ':year'=>$_POST['year'],
                                ':vol'=>$_POST['vol'],
                                ':issue'=>$_POST['issue'],
                                ':page'=>$_POST['pageno'],
                                ':qual'=>$_POST['quality'],
                                ':id'=>$_POST['id']
                            );
                            $q = $con->update_query($sql, $fields);
                            if($q)
                            {
                                $msg = '<div class="alert alert-success mb-2" role="alert">
                                    <strong>Well done!</strong> Journal publication successfully updated.
                                </div>';
                                $success = 1;
                            }
                        }
                        else
                        {
                            $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Enter required fields.
                            </div>';
                        }
                        
                        echo json_encode(array('success'=>$success,'msg'=>$msg));
                        break;
                        
                    case CONFERENCE:
                        $success = 0;
                        $msg = "";
                        if(!empty($_POST['title']) && !empty($_POST['authors']) && !empty($_POST['year']))
                        {
                            $sql = "update conference set title=:title,conference_title=:ctitle,authors=:authors,year=:year,
                                location=:location,page_no=:page where id=:id";
                            $fields = array(
                                ':title'=>$_POST['title'],
                                ':ctitle'=>$_POST['ctitle'],
                                ':authors'=>$_POST['authors'],
                                ':year'=>$_POST['year'],
                                ':location'=>$_POST['location'],
                                ':page'=>$_POST['pageno'],
                                ':id'=>$_POST['id']
                            );
                            $q = $con->update_query($sql, $fields);
                            if($q)
                            {
                                $msg = '<div class="alert alert-success mb-2" role="alert">
                                    <strong>Well done!</strong> Conference publication successfully updated.
                                </div>';
                                $success = 1;
                            }
                        }
                        else
                        {
                            $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Enter required fields.
                            </div>';
                        }
                        
                        echo json_encode(array('success'=>$success,'msg'=>$msg));
                        break;
                        
                    case BOOK:
                    case BOOK_CHAPTER:
                        $success = 0;
                        $msg = "";
                        if(!empty($_POST['title']) && !empty($_POST['authors']) && !empty($_POST['year']))
                        {
                            $chapter_no = "";
                            if($_POST['update'] == BOOK_CHAPTER)
                            {
                                $chapter_no = $_POST['chapterno'];
                                $chapter_no = !empty($chapter_no) ? $chapter_no : '--';
                            }
                            
                            $sql = "update book set title=:title,authors=:authors,year=:year,
                                publisher=:pub,chapter_no=:chapter,page_no=:page where id=:id";
                            $fields = array(
                                ':title'=>$_POST['title'],
                                ':authors'=>$_POST['authors'],
                                ':year'=>$_POST['year'],
                                ':pub'=>$_POST['publisher'],
                                ':chapter'=>$chapter_no,
                                ':page'=>$_POST['pageno'],
                                ':id'=>$_POST['id']
                            );
                            $q = $con->update_query($sql, $fields);
                            if($q)
                            {
                                $msg = '<div class="alert alert-success mb-2" role="alert">
                                    <strong>Well done!</strong> Book publication successfully updated.
                                </div>';
                                $success = 1;
                            }
                        }
                        else
                        {
                            $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Enter required fields.
                            </div>';
                        }
                        
                        echo json_encode(array('success'=>$success,'msg'=>$msg));
                        break;
                        
                        
                    case PATENT:
                        $success = 0;
                        $msg = "";
                        if(!empty($_POST['title']) && !empty($_POST['authors']) && !empty($_POST['year']))
                        {
                            $sql = "update patent set title=:title,authors=:authors,year=:year,patent_no=:no where id=:id";
                            $fields = array(
                                ':title'=>$_POST['title'],
                                ':authors'=>$_POST['authors'],
                                ':year'=>$_POST['year'],
                                ':no'=>$_POST['patentno'],
                                ':id'=>$_POST['id']
                            );
                            $q = $con->update_query($sql, $fields);
                            if($q)
                            {
                                $msg = '<div class="alert alert-success mb-2" role="alert">
                                    <strong>Well done!</strong> Patent publication successfully updated.
                                </div>';
                                $success = 1;
                            }
                        }
                        else
                        {
                            $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Enter required fields.
                            </div>';
                        }
                        
                        echo json_encode(array('success'=>$success,'msg'=>$msg));
                        break;
            
    }
}
?>