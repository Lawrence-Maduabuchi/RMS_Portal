<?php 
session_start();
$menu = "dashboard";
$group = "dashboard";
include('header.php')?>

<script>
$(document).ready(function(){
	getProjectColumnChart();
	getProjectPieChart();
});
</script>

<style>
.col-xl-3 a
{
	color: inherit!important;
}
</style> 
    
    
                <div id="crypto-stats-3" class="row">
                    <div class="col-xl-3 col-md-6 col-12">
                            <a href="project_list">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <?php $total_projects =  GetTotalNumberProjects($con);?>
                                                <h3 class="info"><?php echo $total_projects?></h3>
                                                <span>Projects</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="icon-rocket info font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                        <div class="progress mt-1 mb-0" style="height: 7px;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <a href="project_list?status=<?php echo COMPLETED_PROJECT?>">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <?php $completed = GetNumberOfProjectsStatus(COMPLETED_PROJECT,$con);?>
                                                <h3 class="success"><?php echo $completed?></h3>
                                                <span>Completed</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="ft-check-circle success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                        <div class="mt-1 mb-0" style="height: 7px;">
                                            <?php 
                                            $percentage = $total_projects > 0 ? $completed/$total_projects * 100 : 0;
                                            echo GetProjectProgress($percentage);
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <a href="project_list?status=<?php echo ONGOING_PROJECT?>">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <?php $ongoing = GetNumberOfProjectsStatus(ONGOING_PROJECT,$con);?>
                                                <h3 class="warning"><?php echo $ongoing?></h3>
                                                <span>Ongoing</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="ft-layers warning font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                        <div class="mt-1 mb-0" style="height: 7px;">
                                            <?php 
                                            $percentage = $total_projects > 0 ? $ongoing/$total_projects * 100 : 0;
                                            echo GetProjectProgress(round($percentage,2));
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <a href="project_list?status=<?php echo PENDING_PROJECT?>">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <?php $pending = GetNumberOfProjectsStatus(PENDING_PROJECT,$con);?>
                                                <h3 class="default"><?php echo $pending?></h3>
                                                <span>Pending</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="ft-activity default font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                        <div class="mt-1 mb-0" style="height: 7px;">
                                            <?php 
                                            $percentage = $total_projects > 0 ? $pending/$total_projects * 100 : 0;
                                            echo GetProjectProgress(round($percentage,2));
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 col-12">
                            <a href="project_list?status=<?php echo OVERDUE_PROJECT?>">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <?php $overdue = GetNumberOfProjectsStatus(OVERDUE_PROJECT,$con);?>
                                                <h3 class="danger"><?php echo $overdue?></h3>
                                                <span>Overdue   </span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="ft-alert-triangle danger font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                        <div class="mt-1 mb-0" style="height: 7px;">
                                            <?php 
                                            $percentage = $total_projects > 0 ? $overdue/$total_projects * 100 : 0;
                                            echo GetProjectProgress(round($percentage,2));
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="warning"><?php echo GetNumberOfProjectsAdminStatus(ATTENTION_REQUIRED,$con)?></h3>
                                                <span>Attention Req.</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="ft-alert-circle warning font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                        <div class="mt-1 mb-0" style="height: 7px;">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                          
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <?php $attention = GetTotalMembers($con);?>
                                                <h3 class="info"><?php echo $attention?></h3>
                                                <span>Active Members</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="ft-users info font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                        <div class="mt-1 mb-0" style="height: 7px;">
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="success"><?php echo GetTotalAdminUsers($con);?></h3>
                                                <span>Admins</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="ft-user-check success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                        <div class="mt-1 mb-0" style="height: 7px;">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- Candlestick Multi Level Control Chart -->
                
                <!-- Task Progress -->
                    <section class="row">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-header">
                                        <h4 class="card-title">Project Progress (Column Chart)</h4>
                                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <canvas id="projectcolumnchart" width="400" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Task Progress -->
                        <!-- Bug Progress -->
                        <div class="col-xl-6 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Projects Progress (Pie Chart)</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <canvas id="projectpiechart" width="400" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Bug Progress -->
                    </section>


    <?php include('footer.php')?>