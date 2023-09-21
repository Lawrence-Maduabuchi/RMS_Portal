<?php 
session_start();
$group = "asettings";
$menu = "asettings";
$title = "Settings";
include('header.php');

if(!$authupdate)
{
    echo '<script>window.location="index"</script>';
}

$admin_email = "";
$sql = "select * from settings order by id DESC";
    $q = $con->select_query($sql);
    foreach ($q as $r)
    {
        $admin_email = $r['admin_email'];
    }
?>

<script>
function SaveUpdate()
{
	$('#msg').html('<img src="../app-assets/images/loading.gif"/>');
	var datastring = $("#settingsform").serialize();	
	$.ajax({
	            type: "POST",
	            url: "../include/update_ajax.php",
	            data: datastring,
	            dataType: 'json',
	            cache: false,
	            success: function(data) {
	            	$('#msg').html(data.msg);
	            },
	            error: function(){
	                alert('error handling here');
	            }
	        });
}
</script>

<section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Settings</h4>
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
                                    <div class="card-body">
                                        <form class="form" action="department_setup" method="post" id="settingsform">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div id="msg"></div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Admin Email</label>
                                                            <input type="text" class="form-control" value="<?php echo $admin_email?>" name="admin_email">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions"> 
                                            <input type="hidden" name="update" value="settings"/> 
                                                <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>                                               
                                                <button type="button" class="btn btn-primary" onclick="SaveUpdate()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>
               </section>

<?php 
include('footer.php');
?>