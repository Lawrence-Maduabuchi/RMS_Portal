<?php session_start();
$group="asecurity";
$menu="arole";
$menuid="arole";
$title="Roles";
$submenu="";

include('../admin/header.php'); 
$_SESSION['isEdit']=false;
?>
<script>
function confirmDelete()
{
	if(!confirm("Are you sure you want to delete this Role?"))
	{
		return false;
	}
	return true;
}
</script>

<section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Roles</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body" style="overflow: auto">
                                        <div class="row row-pad">
                                        <?php 
                                        if($authaddnew)
                                        {
                                        ?>
                                            <div class="col-md-12">
                                                <a href="role_setup" class="btn btn-success pull-right">Add New</a>
                                            </div>
                                        <?php 
                                        }
                                        ?>
                                        </div>
                                        <div class="row row-pad">
                                            <div class="col-md-12 table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Code</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th colspan="3"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $sql="select * from roles order by Code";
                                                        $r=$con->run_select_query($sql);
                                                        $sn=1;
                                                        foreach($r as $value)
                                                        {
                                                            if($value['status']==1)
                                                            {
                                                                $status="<span class='active'>Active</span>";
                                                            }
                                                            else
                                                            {
                                                                $status="<span class='inactive'>Inactive</span>";
                                                            }
                                                           
                                                            echo '<tr>
                                                                    <td style="font-size:12px;">'.$sn.'</td>
                                                                    <td>'.$value['code'].'</td>
                                                                    <td>'.$value['name'].'</td>
                                                                    <td>'.$status.'</td>';
                                                            if($authupdate)
                                                            {
                                                                    echo '<td>
                                                                        <form method="post" action="../admin/role_setup">
                                                                            <input type="hidden" name="roleid" value="'.$value['id'].'"/>
                                                                            <input type="submit" name="role" value="Edit" class="btn btn-warning btn-xs"/>
                                                                        </form>
                                                                    </td>';
                                                            }
                                                            if($authorize)
                                                            {
                                                                    echo '<td>
                                                                        <form method="post" action="../admin/authorize">
                                                                            <input type="hidden" name="roleid" value="'.$value['id'].'"/>
                                                                            <input type="submit" name="role" value="Authorize" class="btn btn-success btn-xs"/>
                                                                        </form>
                                                                    </td>';
                                                            }
                                                            if($authdelete)
                                                            {
                                                                    echo '<td>
                                                                        <form method="post" action="../admin/role_list" onsubmit="return confirmDelete()">
                                                                            <input type="hidden" name="roleid" value="'.$value['id'].'"/>
                                                                            <input type="hidden" name="delete" value="deleterole"/>
                                                                            <input type="submit" name="role" value="Delete" class="btn btn-danger btn-xs"/>
                                                                        </form>
                                                                    </td>';
                                                            }
                                                               echo '</tr>';
                                                            $sn++;
                                                        } 
                    
                                                        include('../include/delete.php');
                                                    ?>
                                                </tbody>
                                            </table>
                                           </div>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>
               </section>
    
<?php include('../admin/footer.php'); ?>