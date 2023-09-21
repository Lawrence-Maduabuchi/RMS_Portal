<?php 
session_start();
$group = "aprofile";
$menu = "aprofile";
$title = "Your Profile";
include('header.php');
?>

<div class="content-header row mb-1">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Your Profile</h3>
                    <div class="row breadcrumbs-top">
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                        <button class="btn btn-info round dropdown-toggle dropdown-menu-right box-shadow-2 px-2" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-printer icon-left"></i> Print</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Print PDF</a><a class="dropdown-item" href="component-buttons-extended.html">Print</a></div>
                    </div>
                </div>
            </div>

            <?php 
            include('../utility/memberprofile.php');
            ?>

<?php 
include('footer.php');
?>