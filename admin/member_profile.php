<?php 
session_start();
$group = "amembers";
$menu = "amembers";
$title = "Member Profile";
include('header.php');
?>
<style>
@media print {
  body, page {
    margin: 0;
    box-shadow: 0;
  }
  .hideprint
  {
  	display: none!important;
    }
body.vertical-layout.vertical-menu.menu-expanded .content, body.vertical-layout.vertical-menu.menu-expanded .footer {
    margin-left: 0px;
}
.card .card-title {
    font-weight: bold!important;
    letter-spacing: 0.05rem;
    font-size: 1.8rem!important;
}
.col-xl-6
{
	max-width: 46%!important;
	float: left!important;
}
html body {
    background-color: #fff;
}
.mb-1, .my-1 {
    margin-bottom: 0 !important;
}
html body .content .content-wrapper {
    padding: 0!important;
}
  .col-lg-3
  {
  	max-width: 22%!important;
  	float: left!important;
  }
  .content-detached, .sidebar-detached
  {
  	margin-top: -20px!important;
  }
  .insights
  {
  	max-width: 50%!important;
  	width: 50%!important;
  }
  .team
  {
  	max-width: 100%!important;
  	width: 100%!important;
  	display: block;
  }
  .team-leader, .team-members
  {
  	max-width: 50%!important;
  	width: 50%!important;
  }
  .uploads
  {
  	max-width: 100%!important;
  	float: none!important;
  	display: block!important;
  }
  .uploads .project-sidebar-content
  {
  	max-width: 100%!important;
  	width: 100%!important;
  	float: none!important;
  }
  a{text-decoration: none!important}
  .badge{border: none!important}
  .milestones{margin-top: -20px!important;}
  .leader-img{max-width: 30%!important; margin-top: 30px;}
}
</style>
<div class="content-header row mb-1 hideprint">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Member Profile</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="project_list">Members</a>
                                </li>
                                <li class="breadcrumb-item active">Member Profile
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <button class="btn btn-info round pull-right box-shadow-2 px-2" onclick="window.print()" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-printer icon-left"></i> Print</button>
                </div>
            </div>

            <?php 
            include('../utility/memberprofile.php');
            ?>

<?php 
include('footer.php');
?>