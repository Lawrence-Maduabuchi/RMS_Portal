<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');
require_once '../lib/dbconfig.php';
include('../lib/custom.php');

if(isset($_POST['insert']))
{
    switch ($_POST['insert'])
    {
            
        case 'department_setup':
            $success = 0;
            $msg = "";
            $status = 0;
            $lastid = 0;
            if(isset($_POST['status']))
            {
                $status = 1;
            }
            if(!empty($_POST['name']) && !empty($_POST['code']))
            {
                $sql = "insert into department (code,name,status,date_created) values (:code,:name,:status,:date)";
                $q = $con->insert_query($sql, array(':code'=>$_POST['code'], ':name'=>$_POST['name'], ':status'=>$status,':date'=>date('d-m-Y H:i A')));
                if($q)
                {
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Field successfully added.
                            </div>';
                    $success = 1;
                }
                $lastid = $con->lastID;
            }
            else
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required fields.
                        </div>';
            }
            
            echo json_encode(array('success'=>$success,'msg'=>$msg,'id'=>$lastid,'name'=>$_POST['name']));
            break;  

        case 'member_setup':
            $success = 0;
            $msg = "";
            $status = 0;
            $lastid = 0;
            if(isset($_POST['status']))
            {
                $status = 1;
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
            if(!empty($_POST['title']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['dept_id']) && !empty($_POST['email']) && !empty($_POST['phone']))
            {
                $password = RandomString(10);
                $add_user = $user->register($_POST['email'], $password, $password, $_POST['phone'], $status, USER_KEY, $_POST['firstname'], $_POST['lastname']);
                if($add_user)
                {
                    $last_user = $user->lastuser;
                    $sql = "update users set department_id=:deptid,title=:title,othernames=:onames where id=:id";
                    $q = $con->update_query($sql,array(':deptid'=>$_POST['dept_id'],':title'=>$_POST['title'],':onames'=>$_POST['othernames'], ':id'=>$last_user));
                    if($q)
                    {
                        $success = 1;
                        if(isset($_FILES['photo']) && !empty($_FILES['photo']))
                        {
                            $ext=pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                            if(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0 || strcasecmp($ext, "gif") == 0)
                            {
                                $photo = "member".$last_user.'.jpg';
                                move_uploaded_file($_FILES['photo']['tmp_name'], UPLOADS_FOLDER.$photo);
                                $sql = "update users set photo=:img where id=:id";
                                $con->update_query($sql,array(':img'=>$photo,':id'=>$last_user));
                            }
                            else
                            {
                                $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                        <strong>Error!</strong> Photo not in correct format (jpg, jpeg, png or gif).
                                    </div>';
                            }
                        }
                        else
                        {
                            $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Note:</strong> No photo uploaded.
                            </div>';
                        }
                        
                        $body = "<p>Dear ".$_POST['firstname']."<br/><br/>
                            You have successfully been registered on AFIT Research Management System. Your login details below.<br/><br/>
                            <strong>Username: </strong> ".$_POST['email']."<br/>
                            <strong>Password: </strong> ".$password."<br/>
                            Please change password after login.                          
                            <br/><br/>
                            Regards,
                            <br/><br/>
                            AFIT-RMS.</p>";
                        $body .= '<a href="'.APP_URL.'" style="display: inline-block; color: #fff; text-decoration:none; text-align: center; background-color: #0053a6; padding: 8px;">Login</a>';
                        SendMessageToQueue("AFIT_RMS Registration", $_POST['email'], "AFIT-RMS", $body, $con);
                        
                        $msg .= '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Member successfully added.<br/><br/>
                                <strong>Username: </strong> '.$_POST['email'].'<br/>
                                <strong>Password: </strong> '.$password.'<br/>
                                Login details have been sent to \''.$_POST['email'].'\'
                            </div>';
                    }
                }
                else 
                {
                    $msg .= '<div class="alert alert-danger mb-2" role="alert">';
                    foreach($user->errormsg as $error)
                    {
                        $msg .= "<span>".$error."</span>";
                    }
                    $msg .= '</div>';
                }
            }
            else
            {
                $msg .= '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required departments.
                        </div>';
            }
            echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
        case 'project_setup':
            $success = 0;
            $msg = "";
           
            if(!empty($_POST['code']) && !empty($_POST['title'])  && !empty($_POST['desc']) && !empty($_POST['startdate']) && !empty($_POST['duedate']) && !empty($_POST['dept_id']))
            {
                $sql = "insert into project 
                    (code,title,description,start_date,due_date,department_id,team_leader_id,co_leader_id,max_team_members,status,priority,date_created) values 
                    (:code,:title,:desc,:start,:due,:dept,:lead,:co,:max,:status,:priority,:date)";
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
                    ':status'=>0,
                    ':priority'=>$_POST['priority'],
                    ':date'=>date('d-m-Y H:i A')
                );
                $q = $con->insert_query($sql,$fields);
                if($q)
                {
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Project successfully added.
                            </div>';
                    $success = 1;
                    
                    //send message to team leader
                    $fullname = GetUserFullName($_POST['team_leader'], $con);
                    $body = "<p>Dear ".$fullname['firstname'].", <br/> a project has been assigned to you on AFIT-RMS. Login to view your new project.</p>";
                    $body .= '<br/><br/><a href="'.APP_URL.'index" style="display: inline-block; color: #fff; text-decoration:none; text-align: center; background-color: #0053a6; padding: 8px;">Login</a>';
                    SendMessageToQueue("New Project Assigned to You",$fullname['email'],"AFIT_RMS",$body,$con);
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
                $sql = "insert into task
                    (project_id,code,title,description,start_date,due_date,status,priority,date_created) values
                    (:pid,:code,:title,:desc,:start,:due,:status,:priority,:date)";
                $fields = array(
                    ':pid'=>$_SESSION['project_id'],
                    ':code'=>$_POST['code'],
                    ':title'=>$_POST['title'],
                    ':desc'=>$_POST['desc'],
                    ':start'=>$_POST['startdate'],
                    ':due'=>$_POST['duedate'],
                    ':status'=>0,
                    ':priority'=>$_POST['priority'],
                    ':date'=>date('d-m-Y H:i A')
                );
                $q = $con->insert_query($sql,$fields);
                if($q)
                {
                    $task_id = $con->lastID;
                    
                    $team_members = explode(',', $_POST['teamlist']);
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
                                <strong>Well done!</strong> Task successfully added.
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
                if(isset($_FILES['uploadfile'.$i]) && !empty($_FILES['uploadfile'.$i]))
                {
                    $isvalidsize = filesize($_FILES['uploadfile'.$i]['tmp_name']) <= MAX_FILE_SIZE;
                    if(!$isvalidsize)
                    {
                        $file_large_size++;  //big size
                    }
                }
            }
            $file_bad_format = 0;
            for ($i = 1; $i <= $_POST['photocount']; $i++)
            {
                if(isset($_FILES['photo'.$i]) && !empty($_FILES['photo'.$i]))
                {
                    $isvalidsize = filesize($_FILES['photo'.$i]['tmp_name']) <= MAX_FILE_SIZE;
                    if(!$isvalidsize)
                    {
                        $file_large_size++;  //big size
                    }
                    
                    $ext=pathinfo($_FILES['photo'.$i]['name'], PATHINFO_EXTENSION);
                    if(!(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0 || strcasecmp($ext, "gif") == 0))
                    {
                        $file_bad_format++;
                    }
                }
            }
            
            if($file_large_size > 0)
            {
                $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                    <strong>Error!</strong> One or more files/photos have sizes that exceed 10MB.
                                </div>';
                echo json_encode(array('success'=>$success,'msg'=>$msg));
                return;
            }
            
            $table1 = "";
            if(!empty($_POST['percentage']))
            {
                if($_POST['type']=="task")
                {
                    $sql = "insert into task_milestones (task_id,description,percentage,team_member_id,date_created)
                            values (:pid,:desc,:perc,:user,:date)";
                    $table1 = "task";
                }
                else if($_POST['type'] == "project")
                {
                    $sql = "insert into project_milestones (project_id,description,percentage,team_leader_id,date_created)
                            values (:pid,:desc,:perc,:user,:date)";
                    $table1 = "project";
                }
                
                $fields = array(
                    ':pid'=>$_POST['project_id'],
                    ':desc'=>$_POST['description'],
                    ':perc'=>$_POST['percentage'],
                    ':user'=>$_SESSION['user_id'],
                    ':date'=>date('d-m-Y H:i A')
                );
                $q = $con->insert_query($sql,$fields);
                if($q)
                {
                    $milestone_id = $con->lastID;
                    
                    $sql = "select status from ".$table1." where id=:id";
                    $q = $con->select_query($sql,array(':id'=>$_POST['project_id']));
                    foreach($q as $r)
                    {
                        if($r['status'] == PENDING_PROJECT)
                        {
                            $sql = "update ".$table1." set status=:ongoing where id=:id";
                            $con->update_query($sql,array(':ongoing'=>ONGOING_PROJECT,':id'=>$_POST['project_id']));
                        }
                    }
                    
                    //update project overall percentage
                    $sql = "update ".$table1." set percentage_completed = :perc where id=:id";
                    $con->update_query($sql,array(':perc'=>$_POST['percentage'],':id'=>$_POST['project_id']));
                    
                    //upload files
                    for ($i = 1; $i <= $_POST['count']; $i++)
                    {
                        if(isset($_FILES['uploadfile'.$i]) && !empty($_FILES['uploadfile'.$i]) && (!empty($_POST['caption'.$i])))
                        {
                            $file = str_replace(" ","_",$_POST['caption'.$i]).'.jpg';
                            move_uploaded_file($_FILES['uploadfile'.$i]['tmp_name'], UPLOADS_FOLDER.$file);
                            
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
                    if(isset($_FILES['photo'.$i]) && !empty($_FILES['photo'.$i]))
                    {
                        $photo = "photo".$_POST['type'].$milestone_id.$i.'.jpg';
                        move_uploaded_file($_FILES['photo'.$i]['tmp_name'], UPLOADS_FOLDER.$photo);
                    
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
                                <strong>Well done!</strong> Task milestone successfully added.
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
            
            case 'user_setup':
                $status=0;
                $success = 0;
                $msg = "";
                if(isset($_POST['status']))
                {
                    $status=1;
                }
                $sql = "select id from users where email=:email";
                $q=$con->select_query($sql,array(':email'=>$_POST['email']));
                if(count($q) > 0)
                {
                    $success = 2;  //code exist
                    echo json_encode(array('success'=>$success));
                    return;
                }
            
                if($_POST['email'] != "" && $_POST['password'] != "" && $_POST['repassword'] != "")
                {
                    $reg = $user->register($_POST['email'], $_POST['password'], $_POST['repassword'], "", $status, "admin", $_POST['firstname'], $_POST['lastname']);
                    if($reg)
                    {
                        //insert roles
                        if(!empty($_POST['rolelist']))
                        {
                            $roles = explode(',', $_POST['rolelist']);
                            foreach($roles as $role)
                            {
                                $sql = "insert into user_roles (userid,roleid) values (:user,:role)";
                                $q=$con->insert_query($sql,array(':user'=>$user->lastuser, ':role'=>$role));
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
                
                
            case JOURNAL:
                $success = 0;
                $msg = "";
                if(!empty($_POST['title']) && !empty($_POST['authors']) && !empty($_POST['year']))
                {
                    $sql = "insert into journal (title,journal_title,authors,year,vol,issue,page_no,date_created,project_id,user_id,quality) 
                        values (:title,:jtitle,:authors,:year,:vol,:issue,:page,:date,:project,:user,:qual)";
                    $fields = array(
                        ':title'=>$_POST['title'],
                        ':jtitle'=>$_POST['jtitle'],
                        ':authors'=>$_POST['authors'],
                        ':year'=>$_POST['year'],
                        ':vol'=>$_POST['vol'],
                        ':issue'=>$_POST['issue'],
                        ':page'=>$_POST['pageno'],
                        ':date'=>date('d-m-Y H:i A'),
                        ':project'=>$_SESSION['project_id'],
                        ':user'=>$_SESSION['user_id'],
                        ':qual'=>$_POST['quality']
                    );
                    $q = $con->insert_query($sql, $fields);
                    if($q)
                    {
                        $msg = '<div class="alert alert-success mb-2" role="alert">
                                    <strong>Well done!</strong> Journal publication successfully added.
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
                    $sql = "insert into conference (title,conference_title,authors,year,location,page_no,date_created,project_id,user_id)
                        values (:title,:ctitle,:authors,:year,:location,:page,:date,:project,:user)";
                    $fields = array(
                        ':title'=>$_POST['title'],
                        ':ctitle'=>$_POST['ctitle'],
                        ':authors'=>$_POST['authors'],
                        ':year'=>$_POST['year'],
                        ':location'=>$_POST['location'],
                        ':page'=>$_POST['pageno'],
                        ':date'=>date('d-m-Y H:i A'),
                        ':project'=>$_SESSION['project_id'],
                        ':user'=>$_SESSION['user_id']
                    );
                    $q = $con->insert_query($sql, $fields);
                    if($q)
                    {
                        $msg = '<div class="alert alert-success mb-2" role="alert">
                                    <strong>Well done!</strong> Conference publication successfully added.
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
                    $pageno = "";
                    if($_POST['insert'] == BOOK_CHAPTER)
                    {
                        $chapter_no = $_POST['chapterno'];
                        $chapter_no = !empty($chapter_no) ? $chapter_no : '--';
                        
                        $pageno = $_POST['pageno'];
                    }
                    
                    $sql = "insert into book (title,authors,year,publisher,page_no,chapter_no,date_created,project_id,user_id)
                        values (:title,:authors,:year,:pub,:page,:chapter,:date,:project,:user)";
                    $fields = array(
                        ':title'=>$_POST['title'],
                        ':authors'=>$_POST['authors'],
                        ':year'=>$_POST['year'],
                        ':pub'=>$_POST['publisher'],
                        ':page'=>$pageno,
                        ':chapter'=>$chapter_no,
                        ':date'=>date('d-m-Y H:i A'),
                        ':project'=>$_SESSION['project_id'],
                        ':user'=>$_SESSION['user_id']
                    );
                    $q = $con->insert_query($sql, $fields);
                    if($q)
                    {
                        $msg = '<div class="alert alert-success mb-2" role="alert">
                                    <strong>Well done!</strong> Book publication successfully added.
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
                    $sql = "insert into patent (title,authors,year,patent_no,date_created,project_id,user_id)
                        values (:title,:authors,:year,:no,:date,:project,:user)";
                    $fields = array(
                        ':title'=>$_POST['title'],
                        ':authors'=>$_POST['authors'],
                        ':year'=>$_POST['year'],
                        ':no'=>$_POST['patentno'],
                        ':date'=>date('d-m-Y H:i A'),
                        ':project'=>$_SESSION['project_id'],
                        ':user'=>$_SESSION['user_id']
                    );
                    $q = $con->insert_query($sql, $fields);
                    if($q)
                    {
                        $msg = '<div class="alert alert-success mb-2" role="alert">
                                    <strong>Well done!</strong> Patent publication successfully added.
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