<?php 
include('../include/connection.php');
include('../include/app_config.php');
require_once '../lib/dbconfig.php';
require_once '../lib/app_stat.php';
require_once '../lib/custom.php';



if(!$user->is_loggedin() || $_SESSION['user_role'] == USER_KEY)
{
    echo '<script>window.location="../login"</script>';
}
else 
{
    $username = $_SESSION['user_session'];
}

if(!$authview && $menu != "dashboard" && $menu != "")
{
    echo '<script>window.location="index"</script>';
}

date_default_timezone_set('Africa/Lagos');
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<?php 
$title =(isset($title)) ? $title : "Dashboard"; 
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title> <?php echo $title?> - Admin :: Research Management System</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../app-assets/images/ico/favicon.png"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/forms/icheck/custom.css">
     <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/forms/selects/select2.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/components.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/cryptocoins/cryptocoins.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/forms/checkboxes-radios.css">
    <!-- END: Page CSS-->

    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-fileupload/bootstrap-fileupload.css" />
    
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/project.css">
    
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/js/gallery/photo-swipe/photoswipe.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/js/gallery/photo-swipe/default-skin/default-skin.css">
    <!-- END: Vendor CSS-->
    
    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/gallery.css">
    <!-- END: Custom CSS-->
    
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="../app-assets/css-rtl/pages/app-email.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/fonts/simple-line-icons/style.min.css">
    
    <!-- Toastr style -->
<link href="../app-assets/css/toastr.min.css" rel="stylesheet">
    
    <link href="../app-assets/css/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
    <!-- BEGIN: Vendor JS-->
    <script src="../app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    
     <script type="text/javascript">
     function openMilestones(projectid)
     {
    	 $(".open-milestones"+projectid).slideToggle();
     }
     </script>
     
<script>
     function printContent(el) {
            //var restorepage = document.body.innerHTML;
            $(".hideprint").hide();
            $(".showprint").show();
            var printcontent = document.getElementById(el).innerHTML;
            document.getElementById('holdprint').innerHTML = printcontent
            window.print();
            document.getElementById('holdprint').innerHTML = "";
            $(".hideprint").show();
            $(".showprint").hide();
        }
</script>
    
    <style>
.row-pad
{
	padding-bottom: 10px;
}
.mg-down
{
	margin-bottom: 10px;
}
.smaller .table-list li, .smaller th, .smaller td
{
	font-size: 12px;
}
.table-list
{
	margin-left: -50px!important;
}
.table-list li
{
	display: block;
	background-color: #1E9FF2;
	padding: 4px 6px;
	border-radius: 4px;
	line-height: 15px;
	margin-bottom: 4px;
	color: #fff;
	list-style-type: disc!important;
	webkit-box-shadow: 10px 15px 30px 1px rgba(0, 0, 0, 0.1);
    box-shadow: 2px 4px 4px 1px rgba(0, 0, 0, 0.1);
}
.table-list li span
{
	float: right;
	font-size: 9px;
	cursor: pointer;
}
.btn-white
{
	border-color: #ddd;
	color: #333;
}
.btn-white:hover
{
	color: #000!important;
}
.member-msg .alert, #msg .alert
{
	background: #fff!important;
	border-left-width: 4px!important; 
}
table.smaller th,table.smaller td
{
	font-size: 12px;
	padding: 1rem 0.5rem;
}
.mce-widget
{
	background: transparent!important;
}
.mce-statusbar
{
	display: none!important;
}
.mce-container
{
	border-radius: 5px;
}
.mce-container-body,body.mce-content-body,.mce-edit-area,.mce-edit-area iframe,.mce-edit-area iframe body, .mce-container
{
    background-color: rgb(255, 255, 255)!important;
	font-size: 20px;
}
.badge
{
	font-size: 13px!important;
	padding: 6px 10px!important;
}
.badge.small
{
	font-size: 11px!important;
	padding: 5px 5px!important;
}
.badge-default
{
	background: #707070;
	color: #fff;
}
.table tr td
{
	vertical-align: middle!important;
}
.group#milestones
{
	cursor: pointer;
}
.open-milestones
{
	display: none;
}
.upload-link
{
	display: inline-block;
	padding: 7px;
	webkit-box-shadow: 10px 15px 30px 1px rgba(0, 0, 0, 0.1);
    box-shadow: 2px 4px 4px 1px rgba(0, 0, 0, 0.1);
	text-align: center;
	margin-bottom: 7px;
	border: 1px solid #ffcc00;
	color: #333!important;
	float: left;
	width: 85%;
}
.img-responsive-gallery {
    width: 140px;
    height: 140px;
    margin-bottom: 4px;
    margin-left: 0px!important;
    object-fit: cover!important;
    overflow: hidden!important;
    border: none!important!important;
}
.img-responsive-summary
{
	width: 80px;
    height: 80px;
    margin-bottom: 4px;
    margin-left: 0px!important;
    object-fit: cover!important;
    overflow: hidden!important;
    border: none!important!important;
}
.modal.attention ul li
{
	list-style-type: disc!important
}
.table .table-link a
{
	color: inherit;
}
.table .table-link a:hover
{
	text-decoration: underline;
}
.leader-photo-wrap
{
	width: 40px;
	height: 40px;
}
.img-responsive {
    /* max-width: 200px; */
	width: 100%;
    height: 100%;
    margin-left: 0px!important;
    object-fit: cover!important;
    overflow: hidden!important;
    border: none!important!important;
}
.header-navbar .navbar-container ul.nav li a.dropdown-user-link .avatar {
    margin-right: 0.5rem;
    width: 36px;
    height: 36px !important;
}
.avatar img {
    width: 100%;
    max-width: 100%;
    height: 100%;
    border: 0 none;
    border-radius: 1000px;
}
</style>
    
    <script>
        function getProjectMilestoneUploads(milestoneid)
        {
        	$("#milestonemodal").modal('show', {}, 500);
        	document.getElementById('milestoneuploads').innerHTML='<img src="../app-assets/images/loading.gif"/>';
        	$(document).ready(function(){
        		var datastring = {'id' : milestoneid};
        		$.ajax({
        		            type: "GET",
        		            url: "../utility/project_milestoneuploads.php",
        		            data: datastring,
        		            dataType: 'html',
        		            cache: false,
        		            success: function(data) {
        		                $('#milestoneuploads').html(data);
        		            },
        		            error: function(){
        		                  alert('error handling here');
        		            }
        		        });
        		
        	});
        }
    </script>
</head>
<!-- END: Head-->
<style>
.header-navbar .navbar-header .navbar-brand .brand-logo {
    width: 200px;
}
</style>
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu 2-columns fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

<!-- milestone view modal -->
              <div class="modal fade text-left" id="milestonemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title text-info"><i class="ft-upload-cloud"></i> Milestone Uploads</h4>                                                                    
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="post"> 
                                                                <div class="modal-body">
                                                                  <div id="milestoneuploads"></div>
                                                                
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
            <!-- milestone uploads modal end -->

<!-- <div id="holdprint"></div> -->
<div>
    <!-- BEGIN: Header-->
    <nav class="hideprint header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light bg-info navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item"><a class="navbar-brand" href="index"><img class="brand-logo" alt="modern admin logo" style="max-width: 140px;" src="../app-assets/images/logo/logo.png">
                            
                        </a></li>
                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                       
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        
                        
                        
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="mr-1 user-name text-bold-700"><?php echo $username?></span><span class="avatar avatar-online"><img src="../app-assets/images/icon-user-default.png" alt="avatar"><i></i></span></a>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#"><i class="ft-user"></i> Profile</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:;" onclick="logout()"><i class="ft-power"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->

    <div class="hideprint main-menu menu-fixed menu-light menu-accordion   menu-shadow " data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

                <li class=" nav-item" id="dashboard"><a href="index"><i class="la la-home"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
                </li>
                <?php 
            
                $sql="select * from menugroup where status=1 AND MenuGroupOrder > 0 order by MenuGroupOrder";
                $q=$con->run_select_query($sql);
                foreach($q as $r)
                {
                    if($auth->HasGroupView($r['Code']) || $_SESSION['user_session']==ADMIN_USERNAME)
                    {
                        echo '<li class="nav-item" id="'.$r['Code'].'">
                                <a href="'.$r['Url'].'">
                                    <i class="'.$r['Icon'].'"></i>
                                    <span class="menu-title" data-i18n="">'.$r['Text'].'</span></a>';
                        if($r['HasMenuItems']==1)
                        {    
                           $sq="select * from menuitem where GroupCode=:code AND TopMenuCode='' AND MenuItemOrder > 0 AND status=1 Order by MenuItemOrder";
                           $f=$con->select_query($sq, array(':code'=>$r['Code']));
                           if(count($f)>0)
                           {
                               echo '<ul class="menu-content">';

                               foreach($f as $v)
                               {
                                   if($auth->HasView($v['Code']) || $_SESSION['user_session']==ADMIN_USERNAME)
                                   {
                                       echo '<li id="'.$v['Code'].'">'; 
                                       
                                       if($v['HasMenuItems']==1)
                                       {
                                           echo '<a href="'.$v['Url'].'" id="'.$v['Code'].'"  class="dropdown-toggle">
                                                '.$v['Text'];
                                           echo '<i class="fa fa-angle-right drop-icon"></i>
                                                 </a>';
                                           $query="select * from menuitem where TopMenuCode=:code AND status=1 MenuGroupOrder > 0 Order by MenuItemOrder";
                                           $h=$con->select_query($query,array(':code'=>$v['Code']));
                                           if(count($h)>0)
                                           {
                                               echo '<ul class="submenu">';
                                               foreach($h as $k)
                                               {
                                                   if($auth->HasView($k['Code']) || $_SESSION['user_session']==ADMIN_USERNAME)
                                                   {
                                                       echo '<li>
                        									<a href="'.$k['Url'].'" id="'.$k['Code'].'">
                        										'.$k['Text'].'
                        									</a>
                        								</li>';
                                                   } 
                                               }
                                               echo '</ul>';
                                           }
                                           
                                       }
                                       else 
                                       {
                                           echo '<a class="menu-item" href="'.$v['Url'].'" id="'.$v['Code'].'">
                                               '.$v['Text'];
                                           echo '</a>';
                                       }
                                      echo '</li>'; 
                                   }
                                   
                               }
                               echo '</ul>';
                           }
                        }
                        else 
                        {
                            echo '</a>';
                        }
                               
                           echo '</li>';
                    }
                }
            ?>
            
                <li class=" nav-item"><a href="javascript:;" onclick="logout()"><i class="la la-power-off"></i><span class="menu-title" data-i18n="">Logout</span></a>
                </li>
               
                <!-- <li class=" nav-item"><a href="#"><i class="la la-briefcase"></i><span class="menu-title" data-i18n="nav.project.main">Project</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="project-summary.html"><i></i><span data-i18n="nav.project.project_summary">Project Summary</span></a>
                        </li>
                        <li><a class="menu-item" href="project-tasks.html"><i></i><span data-i18n="nav.project.project_tasks">Project Task</span></a>
                        </li>
                        <li><a class="menu-item" href="project-bugs.html"><i></i><span data-i18n="nav.project.project_bugs">Project Bugs</span></a>
                        </li>
                    </ul>
                </li> -->
               
               
                
                
               
            </ul>
        </div>
    </div>

    <!-- END: Main Menu-->
    
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row mb-1">
            </div>
            <!-- BEGIN: Content-->
            <div class="content-body">            