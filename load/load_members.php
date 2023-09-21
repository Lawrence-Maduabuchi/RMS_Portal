<?php
session_start();
$menu = "amembers";
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');
include('../lib/dbconfig.php');

$sql="select u.*,d.name as deptname from users u left outer join department d on u.department_id=d.id";

$conditions = array();
$filter=array();

$conditions[] = "role=:role";
$filter[':role'] = USER_KEY;

if(isset($_GET['status']) && $_GET['status'] !="") {
    $conditions[] = "status=:status";
    $filter[':status']=$_GET['status'];
}

if(isset($_GET['department']) && $_GET['department'] !="") {
    $conditions[] = "department_id=:department";
    $filter[':department']=$_GET['department'];
}

if(isset($_GET['searchkey']) && $_GET['searchkey'] !="") {
    $conditions[] = "(firstname like :searchkey OR lastname like :searchkey OR othernames like :searchkey OR email like :searchkey)";
    $keyword = '%'.$_GET['searchkey'].'%';
    $filter[':searchkey'] = $keyword;
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " order by firstname";
$r=$con->select_query($sql,$filter);
$sn=1;
$text = "";
$no_results = count($r);
foreach($r as $value)
{
        if($value['is_active']==1)
        {
            $status="<span class='badge badge-success'>Active</span>";
        }
        else
        {
            $status="<span class='badge badge-secondary'>In-active</span>";
        }
        
        $photo = "../app-assets/images/icon-user-default.png";
        if(!empty($value['photo']) && file_exists(UPLOADS_FOLDER.$value['photo']))
        {
            $photo = UPLOADS_FOLDER.$value['photo'];
        }
        
        $fullname = $value['firstname'].' '.$value['othernames'].' '.$value['lastname'];
        
        $text.= '<tr>
                <td>'.$sn.'</td>
                <td><span class="avatar avatar-busy" style="width: 40px!important;"><img class="thumbnail" src="'.$photo.'"/></span></td>
                <td>'.$value['title'].' '.$fullname.'</td>               
                <td>'.$value['email'].'</td>
                <td>'.$value['phone'].'</td>
                <td>'.$value['deptname'].'</td>
                <td>'.$status.'</td>
                <td>
                    <div class="dropdown">
                         <button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm dropdown-toggle"><i class="la la-cog align-middle"></i></button>
                         <div aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                <a href="member_profile?id='.$value['id'].'" class="dropdown-item"><i class="ft-eye"></i> View Details</a>';
                                if($authupdate)
                                {
                                    $text.='<a href="member_setup?id='.$value['id'].'" class="dropdown-item"><i class="ft-edit-2"></i> Edit</a>';
                                }
                                if($authorize)
                                {
                                    $text.='<a href="javascript:;" onclick="SaveId(\''.$value['id'].'\',\''.$fullname.'\', \''.$value['email'].'\')" data-toggle="modal" data-target="#resetmodal" class="dropdown-item"><i class="ft-unlock"></i> Reset Password</a>';
                                }
                                if($authdelete)
                                {
                                    $text .= '<div class="dropdown-divider"></div>
                                    <a href="javascript:;" onclick="Delete('.$value['id'].')" class="dropdown-item"><i class="ft-trash"></i> Delete Member</a>';
                                }
                         $text .=  '</div>
                   </div>    
                </td>
             </tr>';
        $sn++;

}
echo json_encode(array('text'=>$text,'no_results'=>$no_results));
?>