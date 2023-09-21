<?php 
session_start();
$group = "acategory";
$menu = "acategory";
$title = "Category Setup";
include('header.php');

if(!$authupdate && !$authaddnew)
{
    echo '<script>window.location="index"</script>';
}

$code = "";
$name = "";
$status = "";
if(isset($_GET['id']))
{
    $sql = "select * from department where id=:id";
    $q = $con->select_query($sql, array(':id'=>$_GET['id']));
    foreach ($q as $r)
    {
        $name = $r['name'];
        $code = $r['code'];
        $status = $r['status'];
    }
}
?>

<script>

function SaveInsert()
{
	$('#msg').html('<img src="../app-assets/images/loading.gif"/>');
	var datastring = $("#departmentform").serialize();	
	$.ajax({
	            type: "POST",
	            url: "../include/insert_ajax.php",
	            data: datastring,
	            dataType: 'json',
	            cache: false,
	            success: function(data) {
	            	$('#msg').html(data.msg);
	            	if(data.success == 1)
	            	{
		            	$("input[type='text'], textarea, input[type='password']").val("");
	            	}
	            },
	            error: function(){
	                  alert('error handling here');
	            }
	        });
}

function SaveUpdate()
{
	$('#msg').html('<img src="../app-assets/images/loading.gif"/>');
	var datastring = $("#departmentform").serialize();	
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
                                    <h4 class="card-title" id="basic-layout-form">Department Setup</h4>
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
                                        <form class="form" action="department_setup" method="post" id="departmentform">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div id="msg"></div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Code</label>
                                                            <input type="text" id="projectinput1" class="form-control" value="<?php echo $code?>" name="code">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Name</label>
                                                            <input type="text" id="projectinput1" class="form-control" value="<?php echo $name?>" name="name">
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <departmentset>
                                                                <input type="checkbox" id="input-11" name="status" <?php echo $status == 1 ? "checked" : ""?>/>
                                                                <label for="input-11">Active</label>
                                                            </departmentset>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions"> 
                                            <?php 
                                            if(isset($_GET['id']) && !empty($_GET['id']))
                                            {
                                            ?>
                                                <input type="hidden" name="update" value="department_setup"/> 
                                                <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>                                               
                                                <button type="button" class="btn btn-primary" onclick="SaveUpdate()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            else 
                                            {
                                            ?>
                                                <input type="hidden" name="insert" value="department_setup"/>                                               
                                                <button type="button" class="btn btn-success" onclick="SaveInsert()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            ?>
                                                <a href="department_list" class="btn btn-warning mr-1">
                                                    <i class="ft-x"></i> Cancel
                                                </a>
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