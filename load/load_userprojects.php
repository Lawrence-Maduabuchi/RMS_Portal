<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');

$sql="select p.*,u.firstname,u.lastname,u.othernames,u.title as nametitle,
    up.firstname,up.lastname,up.othernames,up.title as co_title, d.name as deptname from project p 
    left outer join users u on p.team_leader_id=u.id 
    left outer join users up on p.co_leader_id=up.id
    left outer join department d on p.department_id=d.id";

$conditions = array();
$filter=array();

$conditions[] = "u.id=:id OR up.id=:id";
$filter[':id']=$_SESSION['user_id'];

if(isset($_GET['status']) && $_GET['status'] !="") {
    $conditions[] = "p.status=:status";
    $filter[':status']=$_GET['status'];
}

if(isset($_GET['department']) && $_GET['department'] !="") {
    $conditions[] = "department_id=:department";
    $filter[':department']=$_GET['department'];
}

if(isset($_GET['searchkey']) && $_GET['searchkey'] !="") {
    $conditions[] = "(u.firstname like :searchkey OR u.lastname like :searchkey OR u.othernames like :searchkey OR u.email like :searchkey OR p.title like :searchkey OR p.description like :searchkey OR p.code like :searchkey OR d.name like :searchkey)";
    $keyword = '%'.$_GET['searchkey'].'%';
    $filter[':searchkey'] = $keyword;
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " order by p.id DESC";
$r=$con->select_query($sql,$filter);
$sn=1;
$text = "";
$no_results = count($r);
foreach($r as $value)
{
    $attn_req = "";
    if($value['admin_status'] == ATTENTION_REQUIRED && $value['attention_status'] == OPEN_ATTENTION)
    {
        $attn_req = "<br/><span class='text-danger'><i class='ft-alert-triangle'></i> Attn. Req.</span>";
    }
    
    $status_onclick=' onclick="setTitleStatus(\''.$value['title'].'\','.$value['id'].')" data-toggle="modal" data-target="#statusmodal" title="Click to change"';
    
    $confirmed = "";
    if($value['admin_status'] == CONFIRMED)
    {
        $confirmed = "<br/><strong><span class='text-info'><i class='ft-check-circle'></i> Confirmed</span></strong>";
        $status_onclick = "";
        
    }
    
    $co = "";
    if($value['co_leader_id'] == $_SESSION['user_id'])
    {
        $co = '<i class="text-info"><strong>Co-PI</strong></i>';
    }
    
        $text.= '<tr>
                <td>'.$sn.'</td>
                <td class="table-link"><a href="project_summary?id='.$value['id'].'"><span class="text-warning">'.strtoupper($value['code']).'</span> '.$co.'<br/><strong>'.$value['title'].'</strong></a> ('.GetProjectNumberOfTask($value['id'],$con).' Task)<br/><i>'.$value['deptname'].'</i></td>
                <td>'.$value['date_created'].'</td>               
                <td style="min-width: 180px;"><span class="badge badge-info small">'.$value['start_date'].'</span> - <span class="badge badge-info small">'.$value['due_date'].'</span></td>
                <td>'.GetProirityText($value['priority']).'</td>
                <td>'.GetProjectStatusText($value['status'],$status_onclick).$attn_req.$confirmed.'</td>
                <td>'.GetProjectProgress($value['percentage_completed']).'</td>
                <td>
                    <div class="dropdown">
                         <button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm dropdown-toggle"><i class="la la-cog align-middle"></i></button>
                         <div aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                <a href="project_summary?id='.$value['id'].'" class="dropdown-item"><i class="ft-eye"></i> Project Summary</a>
                                <a href="project_uploads?id='.$value['id'].'" class="dropdown-item"><i class="ft-upload-cloud"></i> Uploads</a>';
        if($value['admin_status'] != CONFIRMED)
        {
            if($value['team_leader_id'] == $_SESSION['user_id'])
            {
                                $text .= '<a href="project_task?id='.$value['id'].'" class="dropdown-item"><i class="ft-briefcase"></i> View/Add Task</a>';
            }
                                $text .= '<a href="publication_list?id='.$value['id'].'" class="dropdown-item"><i class="ft-briefcase"></i> View/Add Publication</a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:;" data-toggle="modal" data-target="#milestonemodal" onclick="setTitle(\''.$value['title'].'\','.$value['id'].')" class="dropdown-item"><i class="ft-check-circle"></i> Add Milestones</a>';
        }
        else 
        {
            $text .= '<a href="project_task?id='.$value['id'].'" class="dropdown-item"><i class="ft-briefcase"></i> View Task</a>';
        }
                                
                          $text .= '</div>
                   </div>    
                </td>
             </tr>';
        
        //get milestones
        $sql = 'select * from project_milestones where project_id=:id order by id desc';
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
                    <td><a href="javascript:;" class="btn btn-info btn-sm" onclick="getProjectMilestoneUploads('.$r['id'].')" title="Uploads on this milestone"><span class="ft-upload-cloud"></span></a></td>
                    <td><a href="javascript:;" data-toggle="modal" data-target="#editmilestonemodal" onclick="loadEditMilestone('.$r['id'].',\''.$value['title'].'\','.$value['id'].')" class="btn btn-warning btn-sm" title="Edit"><span class="ft-edit"></span></a></td>
                    <td><a href="javascript:;" onclick="DeleteMileStone('.$r['id'].')" class="btn btn-danger btn-sm" title="Delete"><span class="ft-trash"></span></a></td>
                </tr>';
        }
        $sn++;

}
echo json_encode(array('text'=>$text,'no_results'=>$no_results));
?>