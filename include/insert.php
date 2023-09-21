<?php
$date_created = date('d-m-Y');
if(isset($_POST['insert']))
{
    switch ($_POST['insert'])
    {
        case 'sign-up':
            if($user->register($_POST['email'], $_POST['password'], $_POST['repassword'], "", 0, USER_KEY, $_POST['firstname'],$_POST['lastname']))
            {
                $id = $user->lastuser;
                $key = RandomString(12).$id;
                //$user->login($_POST['email'], $_POST['password']);
                $sql = "update users set reset_key=:key where id=:id";
                $con->update_query($sql,array(':key'=>$key,':id'=>$id));
                    //send message
                    /*$body = "<p>Thank you for registering on ConsTrack. Click the link below to login.</p>";
                    $body .= '<a href="'.APP_URL.'login" style="display: inline-block; color: #fff; text-decoration:none; text-align: center; background-color: #0053a6; padding: 8px;">Login</a>';
                    $sent = SendMessage("Sign Up successful", $_POST['email'], "ConsTrack", $body, $con);*/
                
                $body = "<p>Dear ".$_POST['firstname']."<br/><br/>
                            Welcome to CoporateCareer! Please confirm your email address by clicking the button below.<br/><br/>
                            If you didn't create a CorporateCareer account, don’t worry, it's likely someone mistyped their email address. Just ignore this email and the link will expire.
                            <br/><br/>
                            Best wishes,
                            <br/><br/>
                            The CorporateCareer team.</p>";
                $body .= '<a href="'.APP_URL.'activate_account?key='.$key.'" style="display: inline-block; color: #fff; text-decoration:none; text-align: center; background-color: #0053a6; padding: 8px;">Activate Account</a>';
                $messagetitle = "Activate your account";
                include('utility/messagetemplate.php');
                $body = $msg;
                $sent = SendMessage($messagetitle, $_POST['email'], "CorporateCareer", $body, $con);
                if($sent)
                {
                    echo '<div class="alert alert-success" style="width: 100%">Sign up successfull. Confirm your email address with the activation link sent to your email. Check junk/spam folder too.</div>';
                    //echo '<script>window.location="index"</script>';
                }
            }
            else
            {
                echo '<div class="alert alert-danger" style="width: 100%">';
                foreach($user->errormsg as $error)
                {
                    echo "<span>".$error."</span>";
                }
                echo '</div>';
            }
            break;
            
        case 'menu_group_setup':
                $hasmenu=0;
                if(isset($_POST['hasmenu']))
                    $hasmenu=1;
                $status = 0;
                if(isset($_POST['status']))
                {
                    $status = 1;
                }
                $sql="insert into menugroup (Code,Text,Url,HasMenuItems,Icon,MenuGroupOrder,status) values (:code,:text,:url,:hasmenu,:icon,:order,:status)";
                $fields=array(
                    ':code'=>$_POST['code'],
                    ':text'=>$_POST['text'],
                    ':url'=>$_POST['url'],
                    ':hasmenu'=>$hasmenu,
                    ':icon'=>$_POST['icon'],
                    ':order'=>$_POST['order'],
                    ':status'=>$status
                );
                $q=$con->insert_query($sql,$fields);
                if($q)
                {
                    if(isset($_POST['savecontinue']))
                    {
                        echo '<div class="alert alert-success" id="msg">
                            <i class="fa fa-check-circle fa-fw fa-lg"></i>
                            <strong>Well done!</strong> Menu group successfully added
                            </div>';
                    }
                    else if(isset($_POST['save']))
                    {
                        echo '<script>window.location="../admin/menu_group_list"</script>';
                    }
                }
                break;
            
            case 'menu_item_setup':
                $hasmenu=0;
                if(isset($_POST['hasmenu']))
                    $hasmenu=1;
                $status = 0;
                if(isset($_POST['status']))
                {
                    $status = 1;
                }
                $sql="insert into menuitem (GroupCode,Code,Text,Url,HasMenuItems,TopMenuCode,MenuItemOrder,status) values (:grpcode,:code,:text,:url,:hasmenu,:topmenu,:order,:status)";
                $fields=array(
                    ':grpcode'=>$_SESSION['groupcode'],
                    ':code'=>$_POST['code'],
                    ':text'=>$_POST['text'],
                    ':url'=>$_POST['url'],
                    ':hasmenu'=>$hasmenu,
                    ':topmenu'=>$_POST['topmenu'],
                    ':order'=>$_POST['order'],
                    ':status'=>$status
                );
                $q=$con->insert_query($sql,$fields);
                if($q)
                {
                    if(isset($_POST['savecontinue']))
                    {
                        echo '<div class="alert alert-success" id="msg">
                            <i class="fa fa-check-circle fa-fw fa-lg"></i>
                            <strong>Well done!</strong> Menu item successfully added
                            </div>';
                    }
                    else if(isset($_POST['save']))
                    {
                        echo '<script>window.location="../admin/menu_item_list?groupcode='.$_SESSION['groupcode'].'"</script>';
                    }
                }
                break;
            
            case 'role_setup':
                $status=0;
                if(isset($_POST['status']))
                {
                    $status=1;
                }
                $sql="select code from roles where code=:code";
                $field=array(':code'=>$_POST['code']);
                $q=$con->select_query($sql,$field);
                if(count($q) > 0)
                {
                    echo '<div class="alert alert-danger" id="msg">
                            <i class="fa fa-times-circle fa-fw fa-lg"></i>
                            <strong>Sorry</strong> Role code \''.$_POST['code'].'\' already in use</a>.
                            </div>';
                }
                else
                {
                    $sql="insert into roles (code,name,status) values (:code,:name,:status)";
                    $fields=array(':code'=>strtoupper($_POST['code']), ':name'=>$_POST['name'], ':status'=>$status);
                    $q=$con->insert_query($sql,$fields);
                    if($q)
                    {
                        if(isset($_POST['savecontinue']))
                        {
                            echo '<div class="alert alert-success" id="msg">
                            <i class="fa fa-check-circle fa-fw fa-lg"></i>
                            <strong>Well done!</strong> Role successfully added
                            </div>';
                        }
                        else if(isset($_POST['save']))
                        {
                            echo '<script>window.location="../admin/role_list"</script>';
                        }
                    }
                }
            
                break;
            
            case 'authorize':
                $new=0;
                $update=0;
                $delete=0;
                $view=0;
                $authorize=0;
                $isempty = false;
                $sql="delete from roleauth where roleid=:roleid";
                $field=array(':roleid'=>$_SESSION['roleid']);
                $q=$con->delete_query($sql,$field);
               
            
                for($i=0; $i<sizeof($_SESSION['menuitem']); $i++)
                {
                $isempty = false;
                    $menucode=$_SESSION['menuitem'][$i];
                    $groupcode=GetGroupCode($menucode, $con);
                        if(!isset($_POST['new'.$menucode]) && !isset($_POST['update'.$menucode]) && !isset($_POST['delete'.$menucode]) && !isset($_POST['view'.$menucode]) && !isset($_POST['auth'.$menucode]))
                        {
                        $isempty = true;
                }
                else
                {
                    if(isset($_POST['new'.$menucode]))
                    {
                        $new=1;
                    }
                    else
                    {
                        $new=0;
                    }
                     
                    if(isset($_POST['update'.$menucode]))
                    {
                        $update=1;
                    }
                        else
                        {
                        $update=0;
                    }
                     
                    if(isset($_POST['delete'.$menucode]))
                    {
                        $delete=1;
                    }
                    else
                    {
                        $delete=0;
                    }
                     
                    if(isset($_POST['view'.$menucode]))
                    {
                        $view=1;
                    }
                    else
                    {
                        $view=0;
                    }
                     
                    if(isset($_POST['auth'.$menucode]))
                    {
                       $authorize=1;
                    }
                    else
                    {
                        $authorize=0;
                    }
                    }
                    $query = "select id from roleauth where roleid=:roleid AND groupcode=:gcode AND menucode=:mcode";
                    $fields=array(
                        ':roleid'=>$_SESSION['roleid'],
                        ':gcode'=>$groupcode,
                        ':mcode'=>$_SESSION['menuitem'][$i]
                    );
                            $mq = $con->select_query($query,$fields);
                            $id = 0;
                            if(count($mq) > 0)
                            {
                                foreach($mq as $r)
                                {
                                $id = $r['id'];
                    }
                    $sql="update roleauth set roleid = :role, groupcode = :group,
                    menucode = :menu, allow_new = :new, allow_update = :update,
                    allow_delete = :delete, allow_view = :view, allow_auth = :auth where id = :id";
                    $fields=array(
                        ':role'=>$_SESSION['roleid'],
                        ':group'=>$groupcode,
                        ':menu'=>$_SESSION['menuitem'][$i],
                        ':new'=>$new,
                            ':update'=>$update,
                            ':delete'=>$delete,
                                ':view'=>$view,
                                ':auth'=>$authorize,
                                ':id'=>$id
                    );
                    $r=$con->update_query($sql,$fields);
                    }
                    else if(!$isempty)
                    {
                        $sql="Insert Into roleauth(roleid, groupcode, menucode, allow_new, allow_update, allow_delete, allow_view, allow_auth)
                          			  values (:role, :group, :menu, :new, :update, :delete, :view, :auth)";
                        $fields=array(
                             ':role'=>$_SESSION['roleid'],
                             ':group'=>$groupcode,
                             ':menu'=>$_SESSION['menuitem'][$i],
                            ':new'=>$new,
                            ':update'=>$update,
                            ':delete'=>$delete,
                            ':view'=>$view,
                            ':auth'=>$authorize
                        );
                        $r=$con->insert_query($sql,$fields);
                    }
                 }
                    echo '<div class="alert alert-success" id="msg">
                        <i class="fa fa-check-circle fa-fw fa-lg"></i>
                        <strong>Well done!</strong> Role authorization saved successfully.
                                    </div>';
                    //}
                    break;
            
        case 'user_setup':
            $status=0;
            if(isset($_POST['status']))
            {
                $status=1;
            }
            $sql = "select id from users where email=:email";
            $q=$con->select_query($sql,array(':email'=>$_POST['email']));
            if(count($q) > 0)
            {
                echo '<div class="alert bg-danger" role="alert">
    					<svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Sorry, email already exist. <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
    				</div>';
                return;
            }
            
            if($_POST['email'] != "" && $_POST['password'] != "" && $_POST['repassword'] != "")
            {
                $reg = $user->register($_POST['email'], $_POST['password'], $_POST['repassword'], $status, $_POST['role'], "", "");
                if($reg)
                {
                    echo '<div class="alert bg-success" role="alert">
        					<svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"></use></svg> Admin user added successfully <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
        				</div>';
                }
                else
                {
                    foreach($user->errormsg as $error)
                    {
                        $msg .=$error.'.';
                    }
                    echo '<div class="alert bg-danger" role="alert">
        					<svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> '.$msg.' <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
        				</div>';
                }
            }
            break;
    }
}
?>