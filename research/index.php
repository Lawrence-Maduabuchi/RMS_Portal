<?php 
session_start();
$menu = "dashboard";
$group = "dashboard";
include('header.php')?>

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
                                                    <?php $total_projects =  GetUserTotalNumberOfProjects($_SESSION['user_id'],$con);?>
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
                            </div></a>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <a href="project_list?status=<?php echo COMPLETED_PROJECT?>">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <?php $completed = GetUserNumberOfProjectsStatus($_SESSION['user_id'],COMPLETED_PROJECT,$con);?>
                                                <h3 class="success"><?php echo $completed?></h3>
                                                <span>Completed Projects</span>
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
                                                <?php $ongoing = GetUserNumberOfProjectsStatus($_SESSION['user_id'],ONGOING_PROJECT,$con);?>
                                                <h3 class="warning"><?php echo $ongoing?></h3>
                                                <span>Ongoing Projects</span>
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
                            <a href="project_list?status=<?php echo OVERDUE_PROJECT?>">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <?php $overdue = GetUserNumberOfProjectsStatus($_SESSION['user_id'],OVERDUE_PROJECT,$con);?>
                                                <h3 class="danger"><?php echo $overdue?></h3>
                                                <span>Overdue Projects</span>
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
                            <a href="task_list">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <?php $total_projects =  GetUserTotalNumberOfTask($_SESSION['user_id'],$con);?>
                                                <h3 class="info"><?php echo $total_projects?></h3>
                                                <span>Task</span>
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
                            <a href="task_list?status=<?php echo COMPLETED_PROJECT?>">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <?php $completed = GetUserNumberOfTaskStatus($_SESSION['user_id'],COMPLETED_PROJECT,$con);?>
                                                <h3 class="success"><?php echo $completed?></h3>
                                                <span>Completed Task</span>
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
                            <a href="task_list?status=<?php echo ONGOING_PROJECT?>">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <?php $ongoing = GetUserNumberOfTaskStatus($_SESSION['user_id'],ONGOING_PROJECT,$con);?>
                                                <h3 class="warning"><?php echo $ongoing?></h3>
                                                <span>Ongoing Task</span>
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
                            <a href="task_list?status=<?php echo OVERDUE_PROJECT?>">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <?php $overdue = GetUserNumberOfTaskStatus($_SESSION['user_id'],OVERDUE_PROJECT,$con);?>
                                                <h3 class="danger"><?php echo $overdue?></h3>
                                                <span>Overdue Task</span>
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
                </div>
                <!-- Candlestick Multi Level Control Chart -->
                


                <section class="row">
                        <div class="col-xl-8 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-header">
                                        <h4 class="card-title">Recent Task</h4>
                                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body table-responsive">
                                        <table class="table table-hover smaller">
                                                    <thead>
                                                        <tr>
                                                            <th>Task</th>
                                                            <th>Team</th>
                                                            <th>Due</th>
                                                            <th>Progress</th>  
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $sql="select distinct(tm.team_member_id),p.title as projecttitle,t.*,u.firstname,u.lastname,u.othernames,u.title as nametitle from task t left outer join task_members tm on t.id=tm.task_id left outer join users u on tm.team_member_id=u.id
                                                             left outer join project p on t.project_id=p.id where u.id=:id";
                                                        $sql .= " order by id desc limit 5";
                                                        $r=$con->select_query($sql, array(':id'=>$_SESSION['user_id']));
                                                        foreach($r as $value)
                                                        {
                                                            $team_member = "";
                                                            $team_member .= '<ul class="list-unstyled users-list m-0">';
                                                            $sql = "select u.photo,u.title,u.firstname,u.lastname,u.othernames from task_members t left outer join users u on t.team_member_id=u.id where task_id=:id";
                                                            $q = $con->select_query($sql,array(':id'=>$value['id']));
                                                            foreach ($q as $u)
                                                            {
                                                                $photo = DEFAULT_PHOTO_PATH;
                                                                if(!empty($u['photo']) && file_exists(UPLOADS_FOLDER.$u['photo']))
                                                                {
                                                                    $photo = UPLOADS_FOLDER.$u['photo'];
                                                                }
                                                                //$team_member .= '<span class="avatar avatar-busy" style="width: 40px!important;" title="'.$u['title'].' '.$u['firstname'].' '.$u['othernames'].' '.$u['lastname'].'"><img class="thumbnail" src="'.$photo.'"/></span>';
                                                                $team_member .= '<li data-toggle="tooltip" data-popup="tooltip-custom" title="'.$u['title'].' '.$u['firstname'].' '.$u['othernames'].' '.$u['lastname'].'" class="avatar avatar-sm pull-up">
                                                                                      <img class="media-object rounded-circle" src="'.$photo.'" alt="Avatar">
                                                                                 </li>';
                                                            }
                                                            $team_member .= '</ul>';
                                                            
                                                            echo '<tr>
                                                            <td class="table-link" style="max-width: 200px"><a href="task_summary?id='.$value['id'].'"><span class="text-warning">'.strtoupper($value['code']).'</span><br/><strong>'.$value['title'].'</strong></a><br/><strong>Project Title: </strong> '.$value['projecttitle'].'</td>
                                                            <td>'.$team_member.'</td>
                                                            <td><span class="badge badge-danger small">'.$value['due_date'].'</span></td>
                                                            <td>'.GetProjectProgress($value['percentage_completed']).'</td>
                                                         </tr>';
                                                        }
                                                        ?>
                                                        <tr><td colspan="4"><a href="task_list">See all</a></td></tr>
                                                    </tbody>
                                                </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Task Progress -->
                        <!-- Bug Progress -->
                        <div class="col-xl-4 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Upcoming Deadlines</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body table-responsive">
                                        <table class="table table-hover smaller">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2">Projects</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $sql="select p.*,u.firstname,u.lastname,u.othernames,u.title as nametitle,d.name as deptname from project p left outer join users u on p.team_leader_id=u.id left outer join department d on p.department_id=d.id";
                                                        $sql .= "  where u.id=:id AND p.status!=1 order by p.due_date DESC limit 3";
                                                        $r=$con->select_query($sql, array(':id'=>$_SESSION['user_id']));
                                                        foreach($r as $value)
                                                        {
                                                            echo '<tr>
                                                            <td class="table-link" style="max-width: 200px"><a href="project_summary?id='.$value['id'].'"><span class="text-warning">'.strtoupper($value['code']).'</span><br/><strong>'.$value['title'].'</strong></a></td>
                                                            <td><span class="badge badge-warning small"><i class="ft-alert-octagon"></i> '.$value['due_date'].'</span><br/><br/>'.GetProjectProgress($value['percentage_completed']).'</td>
                                                         </tr>';
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2">Task</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $sql="select distinct(tm.team_member_id),p.title as projecttitle,t.*,u.firstname,u.lastname,u.othernames,u.title as nametitle from task t left outer join task_members tm on t.id=tm.task_id left outer join users u on tm.team_member_id=u.id
                                                             left outer join project p on t.project_id=p.id where u.id=:id AND t.status!=1";
                                                        $sql .= " order by p.due_date DESC limit 3";
                                                        $r=$con->select_query($sql, array(':id'=>$_SESSION['user_id']));
                                                        foreach($r as $value)
                                                        {
                                                            echo '<tr>
                                                            <td class="table-link" style="max-width: 200px"><a href="project_summary?id='.$value['id'].'"><span class="text-warning">'.strtoupper($value['code']).'</span><br/><strong>'.$value['title'].'</strong></a></td>
                                                            <td><span class="badge badge-warning small"><i class="ft-alert-octagon"></i> '.$value['due_date'].'</span><br/><br/>'.GetProjectProgress($value['percentage_completed']).'</td>
                                                         </tr>';
                                                        }
                                                        ?>
                                                    </tbody>
                                               </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Bug Progress -->
                    </section>
                

    <?php include('footer.php')?>