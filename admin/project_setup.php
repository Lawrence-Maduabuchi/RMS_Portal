<?php 
session_start();
$group = "cv";
$menu = "aprojects";
$title = "Projects";
include('header.php');

$title = "";
$code = "";
$description = "";
$start = "";
$end = "";
$team_leader_id = "";
$co_leader = "";
$max_team_members = 0;
$status = "";
$department_id = "";
$completion_date = "";
$percentage_completed = "";
$priority = "";

if(isset($_GET['id']))
{
    $sql = "select * from project where id=:id";
    $q = $con->select_query($sql, array(':id'=>$_GET['id']));
    foreach ($q as $r)
    {
        $title = $r['title'];
        $code = $r['code'];
        $description = $r['description'];
        $start = $r['start_date'];
        $end = $r['due_date'];
        $team_leader_id = $r['team_leader_id'];
        $co_leader = $r['co_leader_id'];
        $max_team_members = $r['max_team_members'];
        $status = $r['status'];
        $department_id = $r['department_id'];
        $priority = $r['priority'];
    }
}
?>

<script>
function getXMLHTTP() { //fuction to return the xml http object
	var xmlhttp=false;	
	try{
		xmlhttp=new XMLHttpRequest();
	}
	catch(e)	{		
		try{			
			xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			try{
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e1){
				xmlhttp=false;
			}
		}
	}
	 	
	return xmlhttp;
}


function getMembers(deptid) 
{
	document.getElementById('team_leader').innerHTML = "<option value=''>Loading...</option>";
	var strURL="getmembers.php?dt=" + (+new Date())+"&department_id="+deptid;
    
	var req = getXMLHTTP();
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {				
					document.getElementById('team_leader').innerHTML=req.responseText;	
					team_lead = "<?php echo $team_leader_id?>";

					document.getElementById('co_leader').innerHTML=req.responseText;	
					co_lead = "<?php echo $co_leader?>";
					if(co_lead != "")
						   document.getElementById('co_leader').value=co_lead;
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}		
}
</script>

<script type="text/javascript" src="../tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: "textarea",
    theme: "modern",
    content_style: 'body {background: rgb(255, 255, 255)!important; caret-color: rgb(33, 150, 243); color: #333!important; font-family: Open sans!important; font-size: 13pt!important;}',
    menubar: false,
    toolbar1: "undo redo | bold italic underline | bullist numlist",
    image_advtab: true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
});
</script>
<script>

function SaveInsert()
{
	$('html,body').animate({ scrollTop: 0 }, 'fast');
	$('#msg').html('<img src="../app-assets/images/loading.gif"/>');

	var ed = tinyMCE.get('desc-alt');
	$('#desctxt').val(ed.getContent());

	var datastring = $("#projectform").serialize();

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
	$('html,body').animate({ scrollTop: 0 }, 'fast');
	$('#msg').html('<img src="../app-assets/images/loading.gif"/>');

	var ed = tinyMCE.get('desc-alt');
	$('#desctxt').val(ed.getContent());
	
	var datastring = $("#projectform").serialize();

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

<?php 
if(isset($_GET['id']))
{
?>
$(document).ready(function(){
	var deptid = <?php echo $department_id;?>;
	getMembers(deptid);
	
})
<?php 
}
?>
</script>

<section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Project Setup</h4>
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
                                        <form class="form" action="project_setup" method="post" id="projectform">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <div id="msg" class="project-msg"></div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="projectinput1">Code</label>
                                                                <input type="text" class="form-control" value="<?php echo $code?>" name="code">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="projectinput1">Title</label>
                                                                <input type="text" class="form-control" value="<?php echo $title?>" name="title">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="projectinput1">Description</label>
                                                                <input type="hidden" name="desc" id="desctxt"/> 
                                                                <textarea class="form-control" style="height: 250px;" name="desc-alt" id="desc-alt"><?php echo $description?></textarea>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="projectinput1">Start Date</label>
                                                                        <input type="text" class="form-control datepicker" name="startdate" id="startdate" value="<?php echo $start?>"/>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="projectinput1">Due Date</label>
                                                                        <input type="text" class="form-control datepicker" name="duedate" id="duedate" value="<?php echo $end?>"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="projectinput1">Category</label>
                                                                <select name="dept_id" class="form-control" id="dept_id" onchange="getMembers(this.value)" required>
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
                                                                if(!empty($department_id))
                                                                {
                                                                    echo '<script>document.getElementById("dept_id").value="'.$department_id.'"</script>';
                                                                }
                                                                ?>
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="projectinput1">Principal Investigator</label>
                                                                <select name="team_leader" class="form-control" id="team_leader" required>
                                                                    <option value="">--select PI--</option>
                                                                </select>
                                                                <input type="hidden" name="old-team-lead" value="<?php echo $team_leader_id?>"/>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="projectinput1">Co-Principal Investigator</label>
                                                                <select name="co_leader" class="form-control" id="co_leader" required>
                                                                    <option value="">--select Co-PI--</option>
                                                                </select>
                                                                <input type="hidden" name="old-co-lead" value="<?php echo $co_leader?>"/>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="projectinput1">Max. Number of Team Members</label>
                                                                <input type="text" class="form-control" value="<?php echo $max_team_members?>" name="maxteam">
                                                                <span class="text-danger" style="font-size: 12px;">*Leave at 0 to remove such restriction</span>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="projectinput1">Priority</label>
                                                                <select name="priority" class="form-control" id="priority" required>
                                                                    <option value="<?php echo CRITICAL_PRIORITY?>">Critical</option>
                                                                    <option value="<?php echo HIGH_PRIORITY?>" selected>High</option>
                                                                    <option value="<?php echo MEDIUM_PRIORITY?>">Medium</option>
                                                                    <option value="<?php echo LOW_PRIORITY?>">Low</option>
                                                                </select>
                                                                <?php 
                                                                if(!empty($priority))
                                                                {
                                                                    echo '<script>document.getElementById("priority").value="'.$priority.'"</script>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions"> 
                                            <?php 
                                            if(isset($_GET['id']) && !empty($_GET['id']))
                                            {
                                            ?>
                                                <input type="hidden" name="update" value="project_setup"/> 
                                                <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>                                               
                                                <button type="button" class="btn btn-primary" onclick="SaveUpdate()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            else 
                                            {
                                            ?>
                                                <input type="hidden" name="insert" value="project_setup"/>                                               
                                                <button type="button" class="btn btn-success" onclick="SaveInsert()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            ?>
                                                <a href="project_list" class="btn btn-warning mr-1">
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