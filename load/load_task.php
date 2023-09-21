<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');

$sql="select * from task";

$conditions = array();
$filter=array();

$conditions[] = "project_id=:project";
$filter[':project']=$_GET['project_id'];

if(isset($_GET['status']) && $_GET['status'] !="") {
    $conditions[] = "status=:status";
    $filter[':status']=$_GET['status'];
}

if(isset($_GET['searchkey']) && $_GET['searchkey'] !="") {
    $conditions[] = "(u.firstname like :searchkey OR u.lastname like :searchkey OR u.othernames like :searchkey OR u.email like :searchkey OR p.title like :searchkey OR p.description like :searchkey OR p.code like :searchkey OR d.name like :searchkey)";
    $keyword = '%'.$_GET['searchkey'].'%';
    $filter[':searchkey'] = $keyword;
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " order by id desc";
$r=$con->select_query($sql,$filter);
$sn=1;
$text = "";
$no_results = count($r);
$team_member = "";
foreach($r as $value)
{
    
        $sql = "select u.photo,u.title,u.firstname,u.lastname,u.othernames from task_members t left outer join users u on t.team_member_id=u.id where task_id=:id";
        $q = $con->select_query($sql,array(':id'=>$value['id']));
        $team_member = "";
        $team_member .= '<ul class="list-unstyled users-list m-0">';
        $no_members = count($q);
        $count = 0;
        foreach ($q as $u)
        {
            if($count < 4)
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
                $count++;
            }
            
        }
        
        $attn_req = "";
        if($value['leader_status'] == ATTENTION_REQUIRED && $value['attention_status'] == OPEN_ATTENTION)
        {
            $attn_req = "<br/><span class='text-danger'><i class='ft-alert-triangle'></i> Attn. Req.</span>";
        }
        $confirmed = "";
        if($value['leader_status'] == CONFIRMED)
        {
            $confirmed = "<br/><strong><span class='text-info'><i class='ft-check-circle'></i> Confirmed</span></strong>";
            $status_onclick = "";
        }
        
        if($no_members > $count)
        {
            $no_members = $no_members - $count;
            $team_member .= '<li class="avatar avatar-sm">
                                <span class="badge badge-info">+'.$no_members.' more</span>
                            </li>';
        }
        $team_member .= '</ul>';
        
        
        $text.= '<tr>
                <td>'.$sn.'</td>
                <td class="table-link"><a href="task_summary?id='.$value['id'].'"><span class="text-warning">'.strtoupper($value['code']).'</span><br/><strong>'.$value['title'].'</strong></a></td>               
                <td>'.$team_member.'</td>
                <td style="min-width: 180px;"><span class="badge badge-info small">'.$value['start_date'].'</span> - <span class="badge badge-info small">'.$value['due_date'].'</span></td>
                <td>'.GetProirityText($value['priority']).'</td>
                <td>'.GetProjectStatusText($value['status']).$attn_req.$confirmed.'</td>
                <td>'.GetProjectProgress($value['percentage_completed']).'</td>
                <td>
                    <div class="dropdown">
                         <button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm dropdown-toggle"><i class="la la-cog align-middle"></i></button>
                         <div aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                <a href="task_summary?id='.$value['id'].'" class="dropdown-item"><i class="ft-eye"></i> Task Summary</a>
                                <a href="task_setup?id='.$value['id'].'" class="dropdown-item"><i class="ft-edit-2"></i> Edit</a>
                                <a href="task_uploads?id='.$value['id'].'" class="dropdown-item"><i class="ft-upload-cloud"></i> Uploads</a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:;" onclick="Delete('.$value['id'].')" class="dropdown-item"><i class="ft-trash"></i> Delete Task</a>
                          </div>
                   </div>    
                </td>
             </tr>';
        
        //get milestones
        $sql = 'select * from task_milestones where task_id=:id order by id desc';
        $sq = $con->select_query($sql,array(':id'=>$value['id']));
        if(count($sq) > 0)
        {
            $text.= '<tr class="group" id="milestones" onclick="openMilestones('.$value['id'].')">
                <td></td>
                <td colspan="8">
                    <h6 class="mb-0">Milestones in <span class="text-bold-600">'.$value['title'].'</span><span class="ft-chevron-down pull-right"></span></h6></td></tr>';
        }
        foreach($sq as $r)
        {
            $desc = $r['description'] == "" ? DEFAULT_MILESTONE_TEXT : $r['description'];
            $text .= '<tr class="open-milestones open-milestones'.$value['id'].'">
                    <td><span class="ft-check-circle text-success" style="font-size: 16px"></span></td>
                    <td colspan="2">'.$desc.'</td>
                    <td>'.$r['date_created'].'</td>
                    <td><i class="ft-arrow-up text-info"></i> <strong>'.$r['percentage'].'%</strong></td>
                    <td><a href="javascript:;" class="btn btn-info btn-sm" onclick="getTaskMilestoneUploads('.$r['id'].')" title="Uploads on this milestone"><span class="ft-upload-cloud"></span></a></td>
                    <td><a href="javascript:;" class="btn btn-warning btn-sm" title="Edit"><span class="ft-edit"></span></a></td>
                    <td><a href="javascript:;" class="btn btn-danger btn-sm" title="Delete"><span class="ft-trash"></span></a></td>
                </tr>';
        }
        $sn++;

}
echo json_encode(array('text'=>$text,'no_results'=>$no_results));
?>