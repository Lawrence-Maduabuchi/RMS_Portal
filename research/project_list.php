<?php 
session_start();
$group = "aprojects";
$menu = "aprojects";
$title = "Your Projects";
include('header.php');
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


function loadProjects(showloading) {
	if(showloading == 1)		
	document.getElementById('load').innerHTML='<img src="../app-assets/images/loading.gif"/>';
	var searchkey = document.getElementById('searchkey').value;
	var status =  document.getElementById('status').value;
	var department =  document.getElementById('department').value;
	var strURL="../load/load_userprojects.php?searchkey="+searchkey+"&status="+status+"&department="+department;

	var req = getXMLHTTP();
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {		
					var result = JSON.parse(req.responseText)		
					document.getElementById('load').innerHTML=result.text;	
					document.getElementById('no_result').innerHTML	= result.no_results;		
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}		
}

function addFile() {
	var count = document.getElementById('uploadCount').value;
	count = parseInt(count) + 1;
	var strURL="addfile.php?count="+count;

	var req = getXMLHTTP();
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {		
					$('#uploaddiv').append(req.responseText);	
					document.getElementById('uploadCount').value = count;		
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}		
}

function addPhoto() {
	var count = document.getElementById('uploadPhotoCount').value;
	count = parseInt(count) + 1;
	var strURL="addphoto.php?count="+count;

	var req = getXMLHTTP();
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {		
					$('#photouploaddiv').append(req.responseText);	
					document.getElementById('uploadPhotoCount').value = count;		
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}		
}

function DeleteFile(id,file)
{
	var datastring = {'id':id,'file':file,'delete':'project_uploads'};
	$.ajax({
        type: "POST",
        url: "../include/delete_ajax.php",
        data: datastring,
        dataType: 'json',
        cache: false,
        success: function(data) {
        	if(data.success == 1)
        	{
            	$("#taskupload"+id).remove();
        	}
        },
        error: function(){
              alert('error handling here');
        }
    });	
}

function DeletePhoto(id,file)
{
	var datastring = {'id':id,'file':file,'delete':'project_photos'};
	$.ajax({
        type: "POST",
        url: "../include/delete_ajax.php",
        data: datastring,
        dataType: 'json',
        cache: false,
        success: function(data) {
        	if(data.success == 1)
        	{
            	$("#taskphoto"+id).remove();
        	}
        },
        error: function(){
              alert('error handling here');
        }
    });	
}

function addPhotoEdit() {
	var count = document.getElementById('uploadPhotoCountEdit').value;
	count = parseInt(count) + 1;
	var strURL="addphotoedit.php?count="+count;

	var req = getXMLHTTP();
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {							
					$('#photouploaddivedit').append(req.responseText);	
					document.getElementById('uploadPhotoCountEdit').value = count;		
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}		
}


function DeleteMileStone(id)
{
	if(confirm("Are your sure?"))
	{
    	var datastring = {'id':id,'delete':'project_milestone'};
    	$.ajax({
            type: "POST",
            url: "../include/delete_ajax.php",
            data: datastring,
            dataType: 'json',
            cache: false,
            success: function(data) {
            	if(data.success == 1)
            	{
            		loadProjects(0);
            	}
            },
            error: function(){
                  alert('error handling here');
            }
        });	
	}
}


function addFileEdit() {
	var count = document.getElementById('uploadCountEdit').value;
	count = parseInt(count) + 1;
	var strURL="addfile.php?count="+count;

	var req = getXMLHTTP();
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {							
					$('#uploaddivedit').append(req.responseText);	
					document.getElementById('uploadCountEdit').value = count;		
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}		
}

function loadEditMilestone(milestone_id,projecttitle,projectid) {
	document.getElementById('loadedit').innerHTML='<img src="../app-assets/images/loading.gif"/>';
	var strURL="edit_milestone.php?milestone_id="+milestone_id+"&type=project";

	var req = getXMLHTTP();
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {			
					document.getElementById('loadedit').innerHTML=req.responseText;	
					$('#projecttitle_task').html(projecttitle);
					$('#milestonetaskid').val(projectid);	
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}		
}

function saveMileStone()
{
	$('#milestonemodal').animate({ scrollTop: 0 }, 'fast');
	$('#msgupload').html('<img src="../app-assets/images/loading.gif"/>');

	var count = $('#uploadCount').val();

	var fileUpload;
	var files;
	var data = new FormData();
	for(var j = 1; j <= count; j++)
	{
    	fileUpload = $("#uploadfile"+j).get(0);
        files = fileUpload.files;        
        for (var i = 0; i < files.length ; i++) {
            data.append('uploadfile'+j,files[i],files[i].name);
        }
	}

	count = $('#uploadPhotoCount').val();
	for(var j = 1; j <= count; j++)
	{
    	fileUpload = $("#photo"+j).get(0);
        files = fileUpload.files;        
        for (var i = 0; i < files.length ; i++) {
            data.append('photo'+j,files[i],files[i].name);
        }
	}
	
	var datastring = $("#milestoneform").serializeArray();

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
	            	$('#msgupload').html(data.msg);
	            	loadProjects(0);
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

function editMileStone()
{
	$('#editmilestonemodal').animate({ scrollTop: 0 }, 'fast');
	$('#msguploadedit').html('<img src="../app-assets/images/loading.gif"/>');

	var count = $('#uploadCountEdit').val();

	var fileUpload;
	var files;
	var data = new FormData();
	for(var j = 1; j <= count; j++)
	{
    	fileUpload = $("#uploadfileedit"+j).get(0);
        files = fileUpload.files;        
        for (var i = 0; i < files.length ; i++) {
            data.append('uploadfileedit'+j,files[i],files[i].name);
        }
	}

	count = $('#uploadPhotoCountEdit').val();
	for(var j = 1; j <= count; j++)
	{
    	fileUpload = $("#photoedit"+j).get(0);
        files = fileUpload.files;        
        for (var i = 0; i < files.length ; i++) {
            data.append('photoedit'+j,files[i],files[i].name);
        }
	}	
	
	var datastring = $("#editmilestoneform").serializeArray();

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
	            	$('#msguploadedit').html(data.msg);
	            	loadProjects(0);
	            },
	            error: function(){
	                  alert('error handling here');
	            }
	        });
}

$(document).ready(function(){
	loadProjects(1);
	$('.filter').change(function(){
		loadProjects(1);
	})
});

function setTitle(projecttitle,projectid)
{
	$('#projecttitle').html(projecttitle);
	$('#milestoneprojectid').val(projectid);
}

function setTitleStatus(projecttitle,projectid)
{
	$('#sprojecttitle').html(projecttitle);
	$('#sprojectid').val(projectid);
	
}

function changeStatus()
{
	var status = $('#pstatus').val();
	var projectid = $('#sprojectid').val();
	var datastring = {'projectid':projectid, 'status' : status};
	
	$.ajax({
	            type: "GET",
	            url: "changestatus.php",
	            data: datastring,
	            dataType: 'json',
	            cache: false,
	            success: function(data) {
	            	loadProjects(0);
	            	setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            departmentClass: "toast-top-full-width",
                            showMethod: 'slideDown',
                            timeOut: 7000
                        };
                        toastr.success('Status changed successfully');
                        
                    }, 1300);
	            },
	            error: function(){
	                  //alert('error handling here');
	            }
	        });
}
</script>

<section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Your Projects</h4>
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
                                            <div class="col-md-3">
                                                <select class="form-control filter" id="status">
                                                    <option value="">--All--</option>
                                                    <option value="<?php echo PENDING_PROJECT?>">Pending</option>
                                                    <option value="<?php echo ONGOING_PROJECT?>">Ongoing</option>
                                                    <option value="<?php echo COMPLETED_PROJECT?>">Completed</option>
                                                    <option value="<?php echo OVERDUE_PROJECT?>">Overdue</option>
                                                </select>
                                                <?php 
                                                if(isset($_GET['status']))
                                                {
                                                    echo '<script>document.getElementById("status").value="'.$_GET['status'].'"</script>';
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control filter" id="department">
                                                    <option value="">--All Categories--</option>
                                                    <?php 
                                                                    $sql = "select id,name from department where status = 1";
                                                                    $q = $con->select_query($sql);
                                                                    foreach($q as $r)
                                                                    {
                                                                        echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
                                                                    }
                                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control filter" placeholder="search..." id="searchkey"/>
                                            </div>
                                        </div>
                                        <div class="row row-pad">
                                            <div class="col-md-12 table-responsive">                                                
                                                <table class="table table-bordered table-striped table-hover smaller">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="8" style="padding: 0.5rem 0.5rem;"><span id="no_result">0</span> Results</th>
                                                         </tr>
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>Project</th>
                                                            <th>Date Created</th>
                                                            <th>Duration</th>
                                                            <th>Priority</th>
                                                            <th>Status</th>
                                                            <th>Progress</th>                                                           
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="load"></tbody>
                                                </table>
                                           </div>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>
               </section>
               
               <!-- Milestone Modal start -->

              <div class="modal fade text-left" id="milestonemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Add Milestone
                                                                    <br/>
                                                                    <span style="font-size: 11px"><strong>PROJECT TITLE:</strong> <span style="color: #ff0000; text-transform: uppercase" id="projecttitle"></span></span>
                                                                    </h4>
                                                                    
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="post" id="milestoneform"> 
                                                                <div class="modal-body">
                                                                     
                                                                            <div class="row row-pad">
                                                                                <div class="col-md-12" id="msgupload"></div>
                                                                            </div>   
                                                                          <div class="row row-pad">
                                                                                <div class="form-group col-md-12">
                                                                                    <label class="control-label required">Description</label>
                                                                                    <textarea class="form-control" name="description"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row row-pad">
                                                                                <div class="form-group col-md-12">
                                                                                    <label class="control-label required">Current Progress Percentage*</label>
                                                                                    <div class="input-group">
                                                                                        <input type="text" class="form-control" name="percentage" placeholder="Progress Percentage" aria-describedby="basic-addon4">
                                                                                        <div class="input-group-append">
                                                                                            <span class="input-group-text"><i class="ft-percent"></i></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="row row-pad">
                                                                                <div class="form-group col-md-12">
                                                                                    <label class="control-label required">Upload Supporting Documents</label>
                                                                                    <div class="row" id="uploaddiv">
                                                                                        <div class="col-md-4">
                                                                                         <div class="upload-file">
                                                                                            <input type="text" class="form-control" placeholder="Caption*" name="caption1">
                                                                                            <div class="fileupload fileupload-new" data-provides="fileupload" style="margin-top: 10px">
                                                                                                <span class="btn btn-white btn-file">
                                                                                                <span class="fileupload-new"><i class="icon-paper-clip"></i> Select file</span>
                                                                                                <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                                                                <input type="file" class="default" name="uploadfile1" id="uploadfile1"/>
                                                                                                </span>
                                                                                                  <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                                                                  <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                                                              </div>
                                                                                           </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <input type="hidden" name="count" id="uploadCount" value="1"/>
                                                                                    <a href="javascript:;" class="add-file" onclick="addFile()"><i class="ft-plus"></i> Add File</a>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="row row-pad">
                                                                                <div class="form-group col-md-12">
                                                                                    <label class="control-label required">Upload Project Photos</label>
                                                                                    <div class="row" id="photouploaddiv">
                                                                                        <div class="col-md-4">
                                                                                            <div class="bordered">
                                                                                                <input type="text" class="form-control" name="photocaption1" placeholder="caption" style="margin-bottom: 5px;"/>
                                                                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                                                      <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                                                                           <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                                                                                      </div>
                                                                                                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                                                                      <div>
                                                                                                       <span class="btn btn-white btn-file">
                                                                                                       <span class="fileupload-new"><i class="icon-paper-clip"></i> Select image</span>
                                                                                                       <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                                                                       <input type="file" id="photo1" name="photo1" class="default" />
                                                                                                       </span>
                                                                                                          <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="icon-trash"></i> Remove</a>
                                                                                                      </div>
                                                                                                  </div>
                                                                                          </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <input type="hidden" name="photocount" id="uploadPhotoCount" value="1"/>
                                                                                    <a href="javascript:;" class="add-file" onclick="addPhoto()"><i class="ft-plus"></i> Add Photo</a>
                                                                                </div>
                                                                            </div>
                                                                
                                                                
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="hidden" name="project_id" id="milestoneprojectid"/>
                                                                    <input type="hidden" name="type" value="project"/>
                                                                    <input type="hidden" name="insert" value="milestone"/>
                                                                    <input type="button" onclick="saveMileStone()" class="btn btn-success" name="resetbtn" value="Save Milestone"/>
                                                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Milestone Modal end -->
                                                    
                                                    
                                                    <!-- Edit Milestone Modal start -->
                                                     <div class="modal fade text-left" id="editmilestonemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit Milestone
                                                                    <br/>
                                                                    <span style="font-size: 11px"><strong>PROJECT TITLE:</strong> <span style="color: #ff0000; text-transform: uppercase" id="projecttitle_task"></span></span>
                                                                    </h4>
                                                                    
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div id="loadedit"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Edit Milestone Modal end -->
                                                    
                                                    <!-- Change status modal -->
                                                    <div class="modal fade text-left" id="statusmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Change Status - <i id="sprojecttitle"></i></h4>
                                                                    
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <select name="status" class="form-control" id="pstatus"> 
                                                                            <option value="">--select status--</option>
                                                                            <option value="<?php echo PENDING_PROJECT?>">Pending</option>
                                                                            <option value="<?php echo ONGOING_PROJECT?>">Ongoing</option>
                                                                            <option value="<?php echo COMPLETED_PROJECT?>">Completed</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="hidden" name="project_id" id="sprojectid"/>
                                                                    <input type="button" onclick="changeStatus()" class="btn btn-success" name="resetbtn"  data-dismiss="modal" value="Change Status"/>
                                                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   <!-- Change status modal end -->

<?php 
include('footer.php');
?>