<?php 
session_start();
$group = "cv";
$menu = "amembers";
$title = "Members";
include('header.php');

if(!$authupdate && !$authaddnew)
{
    echo '<script>window.location="index"</script>';
}

$title = "";
$firstname = "";
$lastname = "";
$othernames = "";
$email = "";
$phone = "";
$status = "";
$photo = "";
if(isset($_GET['id']))
{
    $sql = "select * from users where id=:id";
    $q = $con->select_query($sql, array(':id'=>$_GET['id']));
    foreach ($q as $r)
    {
        $title = $r['title'];
        $firstname = $r['firstname'];
        $lastname = $r['lastname'];
        $othernames = $r['othernames'];
        $email = $r['email'];
        $dept = $r['department_id'];
        $status = $r['is_active'];
        $photo = $r['photo'];
        $phone = $r['phone'];
    }
}
?>

<script>

function SaveInsert()
{
	$('html,body').animate({ scrollTop: 0 }, 'fast');
	$('#msg').html('<img src="../app-assets/images/loading.gif"/>');

	var fileUpload = $("#photo").get(0);
    var files = fileUpload.files;
    var data = new FormData();
    for (var i = 0; i < files.length ; i++) {
        data.append('photo',files[i],files[i].name);
    }
	var datastring = $("#memberform").serializeArray();

	$.each(datastring,function(key,input){
        data.append(input.name,input.value);
    });	
		
	$.ajax({
	            type: "POST",
	            url: "../include/insert_ajax.php",
	            contentType: false,
	            processData: false,
	            data: data,
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
	$('html,body').animate({ scrollTop: 0 }, 'fast');
	$('#msg').html('<img src="../app-assets/images/loading.gif"/>');

	var fileUpload = $("#photo").get(0);
    var files = fileUpload.files;
    var data = new FormData();
    for (var i = 0; i < files.length ; i++) {
        data.append('photo',files[i],files[i].name);
    }
	var datastring = $("#memberform").serializeArray();

	$.each(datastring,function(key,input){
        data.append(input.name,input.value);
    });	
		
	$.ajax({
	            type: "POST",
	            url: "../include/update_ajax.php",
	            contentType: false,
	            processData: false,
	            data: data,
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
                                    <h4 class="card-title" id="basic-layout-form">Member Setup</h4>
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
                                        <form class="form" action="member_setup" method="post" id="memberform">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div id="msg" class="member-msg"></div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="form-group col-md-3">
                                                                <label for="projectinput1">Title</label>
                                                                <select name="title" class="form-control" id="member-title" required>
                                                                    <option value="">--select title--</option>
                                                                    <option>Prof.</option>
                                                                    <option>Dr.</option>
                                                                    <option>Mr.</option>
                                                                    <option>Mrs.</option>
                                                                </select>
                                                                <?php 
                                                                if(!empty($title))
                                                                {
                                                                    echo '<script>document.getElementById("member-title").value="'.$title.'"</script>';
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="projectinput1">First Name</label>
                                                                <input type="text" class="form-control" value="<?php echo $firstname?>" name="firstname">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="projectinput1">Last Name</label>
                                                                <input type="text" class="form-control" value="<?php echo $lastname?>" name="lastname">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="projectinput1">Other Names</label>
                                                                <input type="text" class="form-control" value="<?php echo $othernames?>" name="othernames">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <?php 
                                                            $readonly = "";
                                                            if(isset($_GET['id']))
                                                            {
                                                                $readonly = "readonly";
                                                            }
                                                            ?>
                                                            <div class="form-group col-md-4">
                                                                <label for="projectinput1">Email</label>
                                                                <input type="text" class="form-control" value="<?php echo $email?>" name="email" <?php echo $readonly?>>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="projectinput1">Phone</label>
                                                                <input type="text" class="form-control" value="<?php echo $phone?>" name="phone">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="projectinput1">Category</label>
                                                                <select name="dept_id" class="form-control" id="dept_id" required>
                                                                    <option value="">--select category--</option>
                                                                    <?php 
                                                                    $sql = "select id,name from department where status = 1";
                                                                    $q = $con->select_query($sql);
                                                                    foreach($q as $r)
                                                                    {
                                                                        echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <?php 
                                                                if(!empty($dept))
                                                                {
                                                                    echo '<script>document.getElementById("dept_id").value="'.$dept.'"</script>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                            <label for="projectinput1">Photo</label>
                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                              <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                                    <?php 
                                                                        if($photo != "")
                                                                        {
                                                                            echo '<img src="'.UPLOADS_FOLDER.$photo.'" alt="" />';
                                                                        }
                                                                        else 
                                                                        {
                                                                            echo '<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />';
                                                                        }
                                                                    ?>
                                                                  
                                                              </div>
                                                              <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                              <div>
                                                               <span class="btn btn-white btn-file">
                                                               <span class="fileupload-new"><i class="icon-paper-clip"></i> Select image</span>
                                                               <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                               <input type="hidden" name="oldphoto" value="<?php echo $photo?>"/>
                                                               <input type="file" id="photo" name="photo" class="default" />
                                                               </span>
                                                                  <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="icon-trash"></i> Remove</a>
                                                              </div>
                                                          </div>
                                                        </div>
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <memberset>
                                                                <input type="checkbox" id="input-11" name="status" <?php echo $status == 1 ? "checked" : ""?>/>
                                                                <label for="input-11">Active</label>
                                                            </memberset>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions"> 
                                            <?php 
                                            if(isset($_GET['id']) && !empty($_GET['id']))
                                            {
                                            ?>
                                                <input type="hidden" name="update" value="member_setup"/> 
                                                <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>                                               
                                                <button type="button" class="btn btn-primary" onclick="SaveUpdate()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            else 
                                            {
                                            ?>
                                                <input type="hidden" name="insert" value="member_setup"/>                                               
                                                <button type="button" class="btn btn-success" onclick="SaveInsert()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            ?>
                                                <a href="member_list" class="btn btn-warning mr-1">
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