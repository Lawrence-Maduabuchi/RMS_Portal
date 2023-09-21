<?php 
include('connection.php');
include('include/app_config.php');
require_once 'lib/app_stat.php';
require_once 'lib/dbconfig.php';
require_once('phpmailer_5.2.4/class.phpmailer.php');
require ('phpmailer_5.2.4/class.smtp.php');
require_once 'lib/custom.php';

date_default_timezone_set('Africa/Lagos');

?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<?php 
$title = isset($title) ? $title : "";
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Airforce Institute of Technology, Quest for Excellence. Research Management System">
    <meta name="keywords" content="AFIT, Airforce, Institute, of, Technology, Research, Management, System">
    <meta name="author" content="PIXINVENT">
    <title><?php echo $title?> :: AFIT- Research Management System</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="app-assets/images/ico/favicon.png"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/weather-icons/climacons.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/fonts/meteocons/style.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/charts/morris.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/charts/chartist.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/charts/chartist-plugin-tooltip.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/timeline.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/dashboard-ecommerce.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- END: Custom CSS-->

    <style>
.header-navbar .navbar-header .navbar-brand .brand-logo {
    width: 250px;
}
page {
  background: white;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
}
page[size="A4"] {  
  width: 21cm;
  height: 29.7cm; 
}
page[size="A4"][layout="landscape"] {
  width: 29.7cm;
  height: 21cm;  
}
page[size="A3"] {
  width: 29.7cm;
  height: 42cm;
}
page[size="A3"][layout="landscape"] {
  width: 42cm;
  height: 29.7cm;  
}
page[size="A5"] {
  width: 14.8cm;
  height: 21cm;
}
page[size="A5"][layout="landscape"] {
  width: 21cm;
  height: 14.8cm;  
}
@media print {
  body, page {
    margin: 0;
    box-shadow: 0;
  }
}
.form-group .form-control
{
	border: none;
	caret-color: rgb(33, 150, 243);
    background-color: rgb(242, 245, 250);
	font-size: 13px!important;
}
.btn {
    font-size: 18px;
    line-height: 22px;
    font-weight: 600;
    display: inline-block;
    -webkit-appearance: none;
    text-align: center;
    color: rgb(255, 255, 255)!important;
    background-color: rgb(33, 150, 243);
    cursor: pointer;
    user-select: none;
    pointer-events: auto;
    outline: none;
    padding: 10px 18px;
    border-radius: 4px;
    transition: background-color 0.1s ease 0s, box-shadow 0.1s ease 0s;
    border-width: 0px;
}
 
.btn-sm
{
	padding: 6px 10px;
	font-size: 12px;
}
</style>
    
    <script type="text/javascript">
        $(document).ready(function(){
            var _group = '<?php echo $group; ?>';
            var _menu = '<?php echo $menu; ?>';
            
            
            $('#' + _group).addClass('active');
            $('#' + _menu).addClass('active');
        });
</script>
    <script>
        function logout()
        {
        	$(document).ready(function(){
        		var datastring = {'id' : 1};
        		$.ajax({
        		            type: "POST",
        		            url: "utility/logout.php",
        		            data: datastring,
        		            cache: false,
        		            success: function(data) {
        		                window.location.href="index";
        		                //alert(data);
        		            },
        		            error: function(){
        		                  alert('error handling here');
        		            }
        		        });
        		
        	});
        }
    </script>
    
    <script>
    $(document).ready(function(){
        $('.form-control').change(function(){
            $('#msg').html('');
        });

        $(".select2").select2();
    });    
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
</head>
<!-- END: Head-->

<body class="horizontal-layout horizontal-menu horizontal-menu-padding 2-columns" data-open="click" data-menu="horizontal-menu" data-col="2-columns">
<div id="holdprint"></div>

<?php 
if(isset($menu) && $menu == "login")
{
    
}
else {
?>
    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow navbar-static-top navbar-light navbar-brand-center">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item"><a class="navbar-brand" href="index"><img class="brand-logo" alt="modern admin logo" src="app-assets/images/logo/logo.png">
                            <!-- <h3 class="brand-text">Corporate Career</h3> -->
                        </a></li>
                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container container center-layout">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
                        
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <?php 
                        if($user->is_loggedin())
                        {
                            $fullname = GetUserFullName($_SESSION['user_id'], $con);
                        ?>
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="mr-1 user-name text-bold-700"><?php echo $fullname['firstname'].' '.$fullname['lastname']?></span></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="resumes"><i class="ft-user"></i> Resumes</a>
                                <a class="dropdown-item" href="#"><i class="ft-check-square"></i> Cover Letters</a>
                                <a class="dropdown-item" href="#"><i class="ft-message-square"></i> Change Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:;" onclick="logout()"><i class="ft-power"></i> Logout</a>
                            </div>
                        </li>
                        <?php 
                        }
                        else
                        {
                            echo '<li class="nav-item"><a class="nav-link" href="login"><span class="mr-1 user-name text-bold-700">Login</span></a>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->

    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow" role="navigation" data-menu="menu-wrapper">
        <div class="navbar-container main-menu-content container center-layout" data-menu="menu-container">
            <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="index.html" data-toggle="dropdown"><i class="la la-home"></i><span>Dashboard</span></a>
                    <ul class="dropdown-menu">
                        <li class="active" data-menu=""><a class="dropdown-item" href="dashboard-ecommerce.html" data-toggle=""><i class="la la-cart-plus"></i><span>eCommerce</span></a>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="dashboard-crypto.html" data-toggle=""><i class="la la-sitemap"></i><span>Crypto</span></a>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="dashboard-sales.html" data-toggle=""><i class="la la-dollar"></i><span>Sales</span></a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-television"></i><span>Templates</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-arrows-v"></i><span>Vertical</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="../vertical-menu-template" data-toggle=""><span>Classic Menu</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="../vertical-modern-menu-template" data-toggle=""><span>Modern Menu</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="../vertical-compact-menu-template" data-toggle=""><span>Compact Menu</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="../vertical-content-menu-template" data-toggle=""><span>Content Menu</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="../vertical-overlay-menu-template" data-toggle=""><span>Overlay Menu</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-arrows-h"></i><span>Horizontal</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="../horizontal-menu-template" data-toggle=""><span>Classic</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="../horizontal-menu-template-nav" data-toggle=""><span>Full Width</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-mobile"></i><span>Apps</span></a>
                    <ul class="dropdown-menu">
                        <li data-menu=""><a class="dropdown-item" href="app-todo.html" data-toggle=""><i class="la la-check-square"></i><span>ToDo</span></a>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="app-contacts.html" data-toggle=""><i class="la la-users"></i><span>Contacts</span></a>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="app-email.html" data-toggle=""><i class="la la-envelope"></i><span>Email Application</span></a>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="app-chat.html" data-toggle=""><i class="la la-comments"></i><span>Chat Application</span></a>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-briefcase"></i><span>Project</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="project-summary.html" data-toggle=""><span>Project Summary</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="project-tasks.html" data-toggle=""><span>Project Task</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="project-bugs.html" data-toggle=""><span>Project Bugs</span></a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="scrumboard.html" data-toggle=""><i class="la la-edit"></i><span>Scrumboard</span></a>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-calendar"></i><span>Calendars</span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><span>Full Calendar</span></a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="full-calender-basic.html" data-toggle=""><span>Basic</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="full-calender-events.html" data-toggle=""><span>Events</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="full-calender-advance.html" data-toggle=""><span>Advance</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="full-calender-extra.html" data-toggle=""><span>Extra</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="calendars-clndr.html" data-toggle=""><span>CLNDR</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-file-text"></i><span>Pages</span></a>
                    <ul class="dropdown-menu">
                        <li data-menu=""><a class="dropdown-item" href="news-feed.html" data-toggle=""><i class="la la-newspaper-o"></i><span>News Feed</span></a>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="social-feed.html" data-toggle=""><i class="la la-share-alt"></i><span>Social Feed</span></a>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-clipboard"></i><span>Invoice</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="invoice-summary.html" data-toggle=""><span>Invoice Summary</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="invoice-template.html" data-toggle=""><span>Invoice Template</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="invoice-list.html" data-toggle=""><span>Invoice List</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-film"></i><span>Timelines</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="timeline-center.html" data-toggle=""><span>Timelines Center</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="timeline-left.html" data-toggle=""><span>Timelines Left</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="timeline-right.html" data-toggle=""><span>Timelines Right</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="timeline-horizontal.html" data-toggle=""><span>Timelines Horizontal</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-user"></i><span>Users</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="user-profile.html" data-toggle=""><span>Users Profile</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="user-cards.html" data-toggle=""><span>Users Cards</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="users-contacts.html" data-toggle=""><span>Users List</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-image"></i><span>Gallery</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="gallery-grid.html" data-toggle=""><span>Gallery Grid</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="gallery-grid-with-desc.html" data-toggle=""><span>Gallery Grid with Desc</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="gallery-masonry.html" data-toggle=""><span>Masonry Gallery</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="gallery-masonry-with-desc.html" data-toggle=""><span>Masonry Gallery with Desc</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="gallery-hover-effects.html" data-toggle=""><span>Hover Effects</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-search"></i><span>Search</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="search-page.html" data-toggle=""><span>Search Page</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="search-website.html" data-toggle=""><span>Search Website</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="search-images.html" data-toggle=""><span>Search Images</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="search-videos.html" data-toggle=""><span>Search Videos</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-unlock"></i><span>Authentication</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="login-simple.html" data-toggle=""><span>Login Simple</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="login-with-bg.html" data-toggle=""><span>Login with Bg</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="login-with-bg-image.html" data-toggle=""><span>Login with Bg Image</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="login-with-navbar.html" data-toggle=""><span>Login with Navbar</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="login-advanced.html" data-toggle=""><span>Login Advanced</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="register-simple.html" data-toggle=""><span>Register Simple</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="register-with-bg.html" data-toggle=""><span>Register with Bg</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="register-with-bg-image.html" data-toggle=""><span>Register with Bg Image</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="register-with-navbar.html" data-toggle=""><span>Register with Navbar</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="register-advanced.html" data-toggle=""><span>Register Advanced</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="unlock-user.html" data-toggle=""><span>Unlock User</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="recover-password.html" data-toggle=""><span>recover-password</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-warning"></i><span>Error</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="error-400.html" data-toggle=""><span>Error 400</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-400-with-navbar.html" data-toggle=""><span>Error 400 with Navbar</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-401.html" data-toggle=""><span>Error 401</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-401-with-navbar.html" data-toggle=""><span>Error 401 with Navbar</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-403.html" data-toggle=""><span>Error 403</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-403-with-navbar.html" data-toggle=""><span>Error 403 with Navbar</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-404.html" data-toggle=""><span>Error 404</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-404-with-navbar.html" data-toggle=""><span>Error 404 with Navbar</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-500.html" data-toggle=""><span>Error 500</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-500-with-navbar.html" data-toggle=""><span>Error 500 with Navbar</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-file-text"></i><span>Others</span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><span>Coming Soon</span></a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="coming-soon-flat.html" data-toggle=""><span>Flat</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="coming-soon-bg-image.html" data-toggle=""><span>Bg image</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="coming-soon-bg-video.html" data-toggle=""><span>Bg video</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="under-maintenance.html" data-toggle=""><span>Maintenance</span></a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="pricing.html" data-toggle=""><i class="la la-money"></i><span>Pricing</span></a>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="checkout-form.html" data-toggle=""><i class="la la-credit-card"></i><span>Checkout</span></a>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="faq.html" data-toggle=""><i class="la la-question"></i><span>FAQ</span></a>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="knowledge-base.html" data-toggle=""><i class="la la-database"></i><span>Knowledge Base</span></a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-columns"></i><span>Layouts</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-columns"></i><span>Page layouts</span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><span>Content Det. Sidebar</span></a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="layout-content-detached-left-sidebar.html" data-toggle=""><span>Detached left sidebar</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="layout-content-detached-left-sticky-sidebar.html" data-toggle=""><span>Detached sticky left sidebar</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="layout-content-detached-right-sidebar.html" data-toggle=""><span>Detached right sidebar</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="layout-content-detached-right-sticky-sidebar.html" data-toggle=""><span>Detached sticky right sidebar</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li data-menu=""><a class="dropdown-item" href="layout-fixed-navigation.html" data-toggle=""><span>Fixed navigation</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="layout-fixed.html" data-toggle=""><span>Fixed layout</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="layout-boxed.html" data-toggle=""><span>Boxed layout</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="layout-static.html" data-toggle=""><span>Static layout</span></a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li data-menu=""><a class="dropdown-item" href="layout-light.html" data-toggle=""><span>Light layout</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="layout-dark.html" data-toggle=""><span>Dark layout</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-navicon"></i><span>Navbars</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="navbar-light.html" data-toggle=""><span>Navbar Light</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="navbar-dark.html" data-toggle=""><span>Navbar Dark</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="navbar-semi-dark.html" data-toggle=""><span>Navbar Semi Dark</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="navbar-brand-center.html" data-toggle=""><span>Brand Center</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="navbar-fixed-top.html" data-toggle=""><span>Fixed Top</span></a>
                                </li>
                                <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><span>Hide on Scroll</span></a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="navbar-hide-on-scroll-top.html" data-toggle=""><span>Hide on Scroll Top</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="navbar-hide-on-scroll-bottom.html" data-toggle=""><span>Hide on Scroll Bottom</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="navbar-components.html" data-toggle=""><span>Navbar Components</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="navbar-styling.html" data-toggle=""><span>Navbar Styling</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-arrows-v"></i><span>Vertical Nav</span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><span>Navigation Types</span></a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="../vertical-menu-template" data-toggle=""><span>Vertical Menu</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="../vertical-overlay-menu-template" data-toggle=""><span>Vertical Overlay</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="../vertical-compact-menu-template" data-toggle=""><span>Vertical Compact</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="../vertical-content-menu-template" data-toggle=""><span>Vertical Content</span></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-arrows-h"></i><span>Horizontal Nav</span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><span>Navigation Types</span></a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="../horizontal-menu-template" data-toggle=""><span>Left Icon Navigation</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="../horizontal-menu-template-nav" data-toggle=""><span>Full Width Navigation</span></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-header"></i><span>Page Headers</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="headers-breadcrumbs-basic.html" data-toggle=""><span>Breadcrumbs basic</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="headers-breadcrumbs-top.html" data-toggle=""><span>Breadcrumbs top</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="headers-breadcrumbs-bottom.html" data-toggle=""><span>Breadcrumbs bottom</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="headers-breadcrumbs-top-with-description.html" data-toggle=""><span>Breadcrumbs top with desc</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="headers-breadcrumbs-with-button.html" data-toggle=""><span>Breadcrumbs with button</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="headers-breadcrumbs-with-round-button.html" data-toggle=""><span>Breadcrumbs with button 2</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="headers-breadcrumbs-with-button-group.html" data-toggle=""><span>Breadcrumbs with buttons</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="headers-breadcrumbs-with-description.html" data-toggle=""><span>Breadcrumbs with desc</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="headers-breadcrumbs-with-search.html" data-toggle=""><span>Breadcrumbs with search</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="headers-breadcrumbs-with-stats.html" data-toggle=""><span>Breadcrumbs with stats</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-download"></i><span>Footers</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="footer-light.html" data-toggle=""><span>Footer Light</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="footer-dark.html" data-toggle=""><span>Footer Dark</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="footer-transparent.html" data-toggle=""><span>Footer Transparent</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="footer-fixed.html" data-toggle=""><span>Footer Fixed</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="footer-components.html" data-toggle=""><span>Footer Components</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-folder-open"></i><span>General</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-paint-brush"></i><span>Color Palette</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="color-palette-primary.html" data-toggle=""><span>Primary palette</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-danger.html" data-toggle=""><span>Danger palette</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-success.html" data-toggle=""><span>Success palette</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-warning.html" data-toggle=""><span>Warning palette</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-info.html" data-toggle=""><span>Info palette</span></a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-red.html" data-toggle=""><span>Red palette</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-pink.html" data-toggle=""><span>Pink palette</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-purple.html" data-toggle=""><span>Purple palette</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-blue.html" data-toggle=""><span>Blue palette</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-cyan.html" data-toggle=""><span>Cyan palette</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-teal.html" data-toggle=""><span>Teal palette</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-yellow.html" data-toggle=""><span>Yellow palette</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-amber.html" data-toggle=""><span>Amber palette</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-blue-grey.html" data-toggle=""><span>Blue Grey palette</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-puzzle-piece"></i><span>Starter kit</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="starter-kit/ltr/horizontal-menu-template/horizontal-layout-1-column.html" data-toggle=""><span>1 column</span></a>
                                </li>
                                <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><span>Content Det. Sidebar</span></a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="starter-kit/ltr/horizontal-menu-template/layout-content-detached-left-sidebar.html" data-toggle=""><span>Detached left sidebar</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="starter-kit/ltr/horizontal-menu-template/layout-content-detached-left-sticky-sidebar.html" data-toggle=""><span>Detached sticky left sidebar</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="starter-kit/ltr/horizontal-menu-template/layout-content-detached-right-sidebar.html" data-toggle=""><span>Detached right sidebar</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="starter-kit/ltr/horizontal-menu-template/layout-content-detached-right-sticky-sidebar.html" data-toggle=""><span>Detached sticky right sidebar</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li data-menu=""><a class="dropdown-item" href="starter-kit/ltr/horizontal-menu-template/layout-fixed-navigation.html" data-toggle=""><span>Fixed navigation</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="starter-kit/ltr/horizontal-menu-template/layout-fixed.html" data-toggle=""><span>Fixed layout</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="starter-kit/ltr/horizontal-menu-template/layout-boxed.html" data-toggle=""><span>Boxed layout</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="starter-kit/ltr/horizontal-menu-template/layout-static.html" data-toggle=""><span>Static layout</span></a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li data-menu=""><a class="dropdown-item" href="starter-kit/ltr/horizontal-menu-template/layout-light.html" data-toggle=""><span>Light layout</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="starter-kit/ltr/horizontal-menu-template/layout-dark.html" data-toggle=""><span>Dark layout</span></a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="changelog.html" data-toggle=""><i class="la la-copy"></i><span>Changelog</span></a>
                        </li>
                        <li class="disabled" data-menu=""><a class="dropdown-item" href="#" data-toggle=""><i class="la la-eye-slash"></i><span>Disabled Menu</span></a>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-android"></i><span>Menu levels</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="#" data-toggle=""><span>Second level</span></a>
                                </li>
                                <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><span>Second level child</span></a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="#" data-toggle=""><span>Third level</span></a>
                                        </li>
                                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><span>Third level child</span></a>
                                            <ul class="dropdown-menu">
                                                <li data-menu=""><a class="dropdown-item" href="#" data-toggle=""><span>Fourth level</span></a>
                                                </li>
                                                <li data-menu=""><a class="dropdown-item" href="#" data-toggle=""><span>Fourth level</span></a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-pencil"></i><span>UI</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-tablet"></i><span>Cards</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="card-bootstrap.html" data-toggle=""><span>Bootstrap</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-headings.html" data-toggle=""><span>Headings</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-options.html" data-toggle=""><span>Options</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-actions.html" data-toggle=""><span>Action</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-draggable.html" data-toggle=""><span>Draggable</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-fire"></i><span>Advance Cards</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="card-statistics.html" data-toggle=""><span>Statistics</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-weather.html" data-toggle=""><span>Weather</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-charts.html" data-toggle=""><span>Charts</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-interactive.html" data-toggle=""><span>Interactive</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-maps.html" data-toggle=""><span>Maps</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-social.html" data-toggle=""><span>Social</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-ecommerce.html" data-toggle=""><span>E-Commerce</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-compass"></i><span>Content</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="content-grid.html" data-toggle=""><span>Grid</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="content-typography.html" data-toggle=""><span>Typography</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="content-text-utilities.html" data-toggle=""><span>Text utilities</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="content-syntax-highlighter.html" data-toggle=""><span>Syntax highlighter</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="content-helper-classes.html" data-toggle=""><span>Helper classes</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-server"></i><span>Components</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="component-alerts.html" data-toggle=""><span>Alerts</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-callout.html" data-toggle=""><span>Callout</span></a>
                                </li>
                                <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><span>Buttons</span></a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="component-buttons-basic.html" data-toggle=""><span>Basic Buttons</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="component-buttons-extended.html" data-toggle=""><span>Extended Buttons</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-carousel.html" data-toggle=""><span>Carousel</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-collapse.html" data-toggle=""><span>Collapse</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-dropdowns.html" data-toggle=""><span>Dropdowns</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-list-group.html" data-toggle=""><span>List Group</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-modals.html" data-toggle=""><span>Modals</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-pagination.html" data-toggle=""><span>Pagination</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-navs-component.html" data-toggle=""><span>Navs Component</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-tabs-component.html" data-toggle=""><span>Tabs Component</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-pills-component.html" data-toggle=""><span>Pills Component</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-tooltips.html" data-toggle=""><span>Tooltips</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-popovers.html" data-toggle=""><span>Popovers</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-badges.html" data-toggle=""><span>Badges</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-pill-badges.html" data-toggle=""><span>Pill Badges</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-progress.html" data-toggle=""><span>Progress</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-media-objects.html" data-toggle=""><span>Media Objects</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-scrollable.html" data-toggle=""><span>Scrollable</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-spinners.html" data-toggle=""><span>Spinners</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="components-toast.html" data-toggle=""><span>Toast &amp; Custom Switch</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="components-bootstrap-spinner.html" data-toggle=""><span>Bootstrap Spinner</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-diamond"></i><span>Extra Components</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="ex-component-sweet-alerts.html" data-toggle=""><span>Sweet Alerts</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-tree-views.html" data-toggle=""><span>Tree Views</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-toastr.html" data-toggle=""><span>Toastr</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-ratings.html" data-toggle=""><span>Ratings</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-noui-slider.html" data-toggle=""><span>NoUI Slider</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-date-time-dropper.html" data-toggle=""><span>Date Time Dropper</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-lists.html" data-toggle=""><span>Lists</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-toolbar.html" data-toggle=""><span>Toolbar</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-knob.html" data-toggle=""><span>Knob</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-long-press.html" data-toggle=""><span>Long Press</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-offline.html" data-toggle=""><span>Offline</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-zoom.html" data-toggle=""><span>Zoom</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-eye"></i><span>Icons</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="icons-feather.html" data-toggle=""><span>Feather</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="icons-line-awesome.html" data-toggle=""><span>Line Awesome</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="icons-meteocons.html" data-toggle=""><span>Meteocons</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="icons-simple-line-icons.html" data-toggle=""><span>Simple Line Icons</span></a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="animation.html" data-toggle=""><i class="la la-spinner spinner"></i><span>Animation</span></a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-th-list"></i><span>Forms</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-terminal"></i><span>Form Elements</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="form-inputs.html" data-toggle=""><span>Form Inputs</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-input-groups.html" data-toggle=""><span>Input Groups</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-input-grid.html" data-toggle=""><span>Input Grid</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-extended-inputs.html" data-toggle=""><span>Extended Inputs</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-checkboxes-radios.html" data-toggle=""><span>Checkboxes &amp; Radios</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-switch.html" data-toggle=""><span>Switch</span></a>
                                </li>
                                <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><span>Select</span></a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="form-select2.html" data-toggle=""><span>Select2</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="form-selectize.html" data-toggle=""><span>Selectize</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="form-selectivity.html" data-toggle=""><span>Selectivity</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="form-select-box-it.html" data-toggle=""><span>Select Box It</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-dual-listbox.html" data-toggle=""><span>Dual Listbox</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-tags-input.html" data-toggle=""><span>Tags Input</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-validation.html" data-toggle=""><span>Validation</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-file-text"></i><span>Form Layouts</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="form-layout-basic.html" data-toggle=""><span>Basic Forms</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-layout-horizontal.html" data-toggle=""><span>Horizontal Forms</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-layout-hidden-labels.html" data-toggle=""><span>Hidden Labels</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-layout-form-actions.html" data-toggle=""><span>Form Actions</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-layout-row-separator.html" data-toggle=""><span>Row Separator</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-layout-bordered.html" data-toggle=""><span>Bordered</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-layout-striped-rows.html" data-toggle=""><span>Striped Rows</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-layout-striped-labels.html" data-toggle=""><span>Striped Labels</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-paste"></i><span>Form Wizard</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="form-wizard-circle-style.html" data-toggle=""><span>Circle Style</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-wizard-notification-style.html" data-toggle=""><span>Notification Style</span></a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="form-repeater.html" data-toggle=""><i class="la la-repeat"></i><span>Form Repeater</span></a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-table"></i><span>Tables</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-table"></i><span>Bootstrap Tables</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="table-basic.html" data-toggle=""><span>Basic Tables</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="table-border.html" data-toggle=""><span>Table Border</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="table-sizing.html" data-toggle=""><span>Table Sizing</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="table-styling.html" data-toggle=""><span>Table Styling</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="table-components.html" data-toggle=""><span>Table Components</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-th"></i><span>DataTables</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="dt-basic-initialization.html" data-toggle=""><span>Basic Initialisation</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-advanced-initialization.html" data-toggle=""><span>Advanced initialisation</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-styling.html" data-toggle=""><span>Styling</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-data-sources.html" data-toggle=""><span>Data Sources</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-api.html" data-toggle=""><span>API</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-th-large"></i><span>DataTables Ext.</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-autofill.html" data-toggle=""><span>AutoFill</span></a>
                                </li>
                                <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><span>Buttons</span></a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="dt-extensions-buttons-basic.html" data-toggle=""><span>Basic Buttons</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="dt-extensions-buttons-html-5-data-export.html" data-toggle=""><span>HTML 5 Data Export</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="dt-extensions-buttons-flash-data-export.html" data-toggle=""><span>Flash Data Export</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="dt-extensions-buttons-column-visibility.html" data-toggle=""><span>Column Visibility</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="dt-extensions-buttons-print.html" data-toggle=""><span>Print</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="dt-extensions-buttons-api.html" data-toggle=""><span>API</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-column-reorder.html" data-toggle=""><span>Column Reorder</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-fixed-columns.html" data-toggle=""><span>Fixed Columns</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-key-table.html" data-toggle=""><span>Key Table</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-row-reorder.html" data-toggle=""><span>Row Reorder</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-select.html" data-toggle=""><span>Select</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-fix-header.html" data-toggle=""><span>Fix Header</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-responsive.html" data-toggle=""><span>Responsive</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-column-visibility.html" data-toggle=""><span>Column Visibility</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-th-list"></i><span>Handson Table</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="handson-table-appearance.html" data-toggle=""><span>Appearance</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="handson-table-rows-columns.html" data-toggle=""><span>Rows Columns</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="handson-table-rows-only.html" data-toggle=""><span>Rows Only</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="handson-table-columns-only.html" data-toggle=""><span>Columns Only</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="handson-table-data-operations.html" data-toggle=""><span>Data Operations</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="handson-table-cell-features.html" data-toggle=""><span>Cell Features</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="handson-table-cell-types.html" data-toggle=""><span>Cell Types</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="handson-table-integrations.html" data-toggle=""><span>Integrations</span></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="handson-table-utilities.html" data-toggle=""><span>Utilities</span></a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="table-jsgrid.html" data-toggle=""><i class="la la-table"></i><span>jsGrid</span></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="javascript:;" onclick="printContent('cv-block')"><i class="la la-print"></i><span>Print</span></a></li>
            </ul>
        </div>
    </div>

    <!-- END: Main Menu-->
  <?php }?> 
    <!-- BEGIN: Body-->


    <!-- BEGIN: Content-->
    <div class="app-content container center-layout mt-2">
        <div class="content-wrapper">
            <div class="content-header row mb-1">
            </div>
            <div class="content-body">