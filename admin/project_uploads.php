<?php 
session_start();
$group = "aprojects";
$menu = "aprojects";
$title = "Project Uploads";
include('header.php');
?>

<div class="content-header row mb-1">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Project Uploads</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="project_list">Projects</a>
                                </li>
                                <li class="breadcrumb-item active">Uploads
                                </li>
                            </ol>
                        </div>
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
            include('../utility/projectuploads.php');
            ?>

<?php 
include('footer.php');
?>