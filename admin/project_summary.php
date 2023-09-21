<?php 
session_start();
$group = "aprojects";
$menu = "aprojects";
$title = "Project Summary";
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


function loadSummary(projectid,showloading=0) {
	if(showloading == 1)		
		   document.getElementById('load').innerHTML='<img src="../app-assets/images/loading.gif"/>';

	var strURL="../utility/projectsummary.php?dt=" + (+new Date())+"&id="+projectid;

	var req = getXMLHTTP();
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {				
					document.getElementById('load').innerHTML=req.responseText;	
					loadPublications(1);			
				} else {
					//alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}		
}

function loadPublications(showloading) {  
 	if(showloading == 1)		
 		   document.getElementById('loadpub').innerHTML='<img src="../app-assets/images/loading.gif"/>';
 	
 	var searchkey = "";
 	var type =  document.getElementById('ptype').value;
 	var project_id = "<?php echo $_GET['id']?>";

 	var strURL = "../load/load_journal.php?page=summary&searchkey="+searchkey+"&project_id="+project_id;
 	
 	if(type == "<?php echo JOURNAL?>")
 	{
 		   strURL="../load/load_journal.php?page=summary&searchkey="+searchkey+"&project_id="+project_id;
 	}
 	else if(type == "<?php echo CONFERENCE?>")
 	{
 		   strURL="../load/load_conference.php?page=summary&searchkey="+searchkey+"&project_id="+project_id;
 	}
 	else if(type == "<?php echo BOOK?>" || type == "<?php echo BOOK_CHAPTER?>")
 	{
 		   strURL="../load/load_book.php?page=summary&searchkey="+searchkey+"&project_id="+project_id+"&type="+type;
 	}
 	else if(type == "<?php echo PATENT?>")
 	{
 		   strURL="../load/load_patent.php?page=summary&searchkey="+searchkey+"&project_id="+project_id;
 	}

 	var req = getXMLHTTP();
 	
 	if (req) {
 		
 		req.onreadystatechange = function() {
 			if (req.readyState == 4) {
 				// only if "OK"
 				if (req.status == 200) {		
 					document.getElementById('loadpub').innerHTML=req.responseText;				
 				} else {
 					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
 				}
 			}				
 		}			
 		req.open("GET", strURL, true);
 		req.send(null);
 	}		
 }

$(document).ready(function(){
	loadSummary(<?php echo $_GET['id']?>,1);
})

function confirmComplete(id,leader_email,firstname,project_title)
{	
	if(confirm("You are about to confirm that this project has been completed, continue?"))
	{
		$('#confirmbtn').append(' <img src="../app-assets/images/loading.gif"/>');
    	var datastring = {'id':id,'leader_email': leader_email,'firstname':firstname,'title':project_title};
    	$.ajax({
    	            type: "POST",
    	            url: "confirmproject.php",
    	            data: datastring,
    	            dataType: 'json',
    	            cache: false,
    	            success: function(data) {
    	            	if(data.success == 1)
    	            	{       
    	            		loadSummary(<?php echo $_GET['id']?>,0);    		
    	            		setTimeout(function() {
    	                        toastr.options = {
    	                            closeButton: true,
    	                            progressBar: true,
    	                            departmentClass: "toast-top-full-width",
    	                            showMethod: 'slideDown',
    	                            timeOut: 7000
    	                        };
    	                        toastr.success('Project has been confirmed as completed successfully');
    	                        
    	                    }, 1300);
    	            	}
    	            	else
    	            	{
        	            	
    	            		setTimeout(function() {
    	                        toastr.options = {
    	                            closeButton: true,
    	                            progressBar: true,
    	                            positionClass: "toast-top-full-width",
    	                            showMethod: 'slideDown',
    	                            timeOut: 7000
    	                        };
    	                        toastr.error('Error');
    
    	                    }, 1300);
    	            	}
    	            },
    	            error: function(){
    	                  alert('error handling here');
    	            }
    	        });
	}
}

function setDefaultAttention()
{
	tinymce.get('note-alt').setContent("");
    if(data.show_team == 1)
        $("#showteam").prop("checked", false); 

    $('#modalattentionbtn').val("Send");
    $('#modalupdate').val("attention");
}

function getAttention(type="")
{
	var projectid = "<?php echo $_GET['id']?>";
	var datastring = {'projectid': projectid};
	$.ajax({
        type: "GET",
        url: "getattention.php",
        data: datastring,
        dataType: 'json',
        cache: false,
        success: function(data) {
            if(type == "view")
            {
                $('#viewattn').html(data.note);
                if(data.show_team == 1)
                {
                    $('#viewshowteam').html('<i class="ft-check-circle text-info"></i>');
                }
                else
                {
                	$('#viewshowteam').html('<i class="ft-x-circle text-danger"></i>');
                }
                $('#attndetails').html('<i class="ft-calendar"></i> <strong>Date Added</strong>: '+data.date+
                                        '<br/><i class="ft-calendar"></i> <strong>Date Modified</strong>: '+data.modify_date)
            }
            else
            {
                //$('#attentionmodal').modal('show');
                tinymce.get('note-alt').setContent(data.note);
                if(data.show_team == 1)
                    $("#showteam").prop("checked", true); 
    
                $('#modalattentionbtn').val("Update");
                $('#modalupdate').val("attentionupdate");
            }
        },
	    error: function(){
	        //alert('error handling here');
    }
	});
}

function getAttentionArchive()
{
	var projectid = "<?php echo $_GET['id']?>";
	var type = "<?php echo PROJECT_TYPE?>"
	var datastring = {'projectid': projectid, 'type':type};
	$.ajax({
        type: "GET",
        url: "getattentionarchive.php",
        data: datastring,
        dataType: 'html',
        cache: false,
        success: function(data) {
        	$('#loadarchive').html(data);
        },
	    error: function(){
	        //alert('error handling here');
    }
	});
}


function saveAttention()
{
	$('#attentionbtn').append(' <img src="../app-assets/images/loading.gif"/>');

	var ed = tinyMCE.get('note-alt');
	$('#notetxt').val(ed.getContent());
	
	var datastring = $('#attentionform').serialize();
	$.ajax({
	            type: "POST",
	            url: "../include/update_ajax.php",
	            data: datastring,
	            dataType: 'json',
	            cache: false,
	            success: function(data) {
	            	if(data.success == 1)
	            	{       
	            		loadSummary(<?php echo $_GET['id']?>,0);    		
	            		setTimeout(function() {
	                        toastr.options = {
	                            closeButton: true,
	                            progressBar: true,
	                            departmentClass: "toast-top-full-width",
	                            showMethod: 'slideDown',
	                            timeOut: 7000
	                        };
	                        toastr.success('Attention has been saved successfully');
	                        
	                    }, 1300);
	            	}
	            	else if(data.success == 3)
	            	{
	            		setTimeout(function() {
	                        toastr.options = {
	                            closeButton: true,
	                            progressBar: true,
	                            positionClass: "toast-top-full-width",
	                            showMethod: 'slideDown',
	                            timeOut: 7000
	                        };
	                        toastr.error('Please enter a note!');

	                    }, 1300);
	            	}
	            },
	            error: function(){
	                  alert('error handling here');
	            }
	        });
}

function deleteAttention()
{
	if(confirm("Delete attention?"))
	{
    	var datastring = {'projectid': '<?php echo $_GET['id']?>'};
    	$.ajax({
	            type: "POST",
	            url: "deleteattention.php",
	            data: datastring,
	            dataType: 'json',
	            cache: false,
	            success: function(data) {
	            	if(data.success == 1)
	            	{       
	            		loadSummary(<?php echo $_GET['id']?>,0);    		
	            		setTimeout(function() {
	                        toastr.options = {
	                            closeButton: true,
	                            progressBar: true,
	                            departmentClass: "toast-top-full-width",
	                            showMethod: 'slideDown',
	                            timeOut: 7000
	                        };
	                        toastr.success('Attention has been deleted successfully');
	                        
	                    }, 1300);
	            	}
	            	else
	            	{
	            		setTimeout(function() {
	                        toastr.options = {
	                            closeButton: true,
	                            progressBar: true,
	                            positionClass: "toast-top-full-width",
	                            showMethod: 'slideDown',
	                            timeOut: 7000
	                        };
	                        toastr.error('Error!');

	                    }, 1300);
	            	}
	            },
	            error: function(){
	                  alert('error handling here');
	            }
	        });
	}
}

function closeAttention()
{
	if(confirm("Close attention?"))
	{
    	var datastring = {'projectid': '<?php echo $_GET['id']?>', 'type': 'close'};
    	$.ajax({
	            type: "GET",
	            url: "closeattention.php",
	            data: datastring,
	            dataType: 'json',
	            cache: false,
	            success: function(data) {
		            //alert(data);
	            	if(data.success == 1)
	            	{       
	            		loadSummary(<?php echo $_GET['id']?>,0);    		
	            		setTimeout(function() {
	                        toastr.options = {
	                            closeButton: true,
	                            progressBar: true,
	                            departmentClass: "toast-top-full-width",
	                            showMethod: 'slideDown',
	                            timeOut: 7000
	                        };
	                        toastr.success('Attention has been closed successfully');
	                        
	                    }, 1300);
	            	}
	            	else
	            	{
	            		setTimeout(function() {
	                        toastr.options = {
	                            closeButton: true,
	                            progressBar: true,
	                            positionClass: "toast-top-full-width",
	                            showMethod: 'slideDown',
	                            timeOut: 7000
	                        };
	                        toastr.error('Error!');

	                    }, 1300);
	            	}
	            },
	            error: function(){
	                  alert('error handling here');
	            }
	        });
	}
}

function openAttention()
{
	if(confirm("Open attention?"))
	{
    	var datastring = {'projectid': '<?php echo $_GET['id']?>', 'type': 'open'};
    	$.ajax({
	            type: "GET",
	            url: "closeattention.php",
	            data: datastring,
	            dataType: 'json',
	            cache: false,
	            success: function(data) {
		            //alert(data);
	            	if(data.success == 1)
	            	{       
	            		loadSummary(<?php echo $_GET['id']?>,0);    		
	            		setTimeout(function() {
	                        toastr.options = {
	                            closeButton: true,
	                            progressBar: true,
	                            departmentClass: "toast-top-full-width",
	                            showMethod: 'slideDown',
	                            timeOut: 7000
	                        };
	                        toastr.success('Attention has been opened successfully');
	                        
	                    }, 1300);
	            	}
	            	else
	            	{
	            		setTimeout(function() {
	                        toastr.options = {
	                            closeButton: true,
	                            progressBar: true,
	                            positionClass: "toast-top-full-width",
	                            showMethod: 'slideDown',
	                            timeOut: 7000
	                        };
	                        toastr.error('Error!');

	                    }, 1300);
	            	}
	            },
	            error: function(){
	                  alert('error handling here');
	            }
	        });
	}
}
</script>
    
<script>
$(document).ready(function(){
	var project_id = "<?php echo $_GET['id']?>";
	getTaskStatusChart(project_id);
	getTaskProgressChart(project_id);
 })
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

<div class="content-header row mb-1 hideprint">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Project Summary</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="project_list">Project</a>
                                </li>
                                <li class="breadcrumb-item active">Project Summary
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <button class="btn btn-info round pull-right dropdown-menu-right box-shadow-2 px-2" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="window.print()"><i class="ft-printer icon-left"></i> Print</button>
                </div>
            </div>

            <div id="load">
            
            </div>
            
            
            <!-- Attention required modal -->
              <div class="modal fade text-left" id="attentionmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title text-danger"><i class="ft-alert-triangle"></i> Attention Required</h4>                                                                    
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="post" id="attentionform"> 
                                                                <div class="modal-body">
                                                                  
                                                                             <div class="form-group">
                                                                                <label for="projectinput1">Note:</label>
                                                                                <input type="hidden" name="note" id="notetxt"/> 
                                                                                <textarea class="form-control" name="note-alt" id="note-alt" style="height: 150px;"></textarea>
                                                                            </div>
                                                                            
                                                                            <div class="form-group skin skin-square">
                                                                                <fieldset>
                                                                                    <input type="checkbox"  name="showteam" id="showteam"/>
                                                                                    <label for="showteam">Show to Team Members</label>
                                                                                </fieldset>
                                                                            </div>
                                                                
                                                                
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="hidden" name="projectid" value="<?php echo $_GET['id']?>"/>
                                                                    <input type="hidden" name="update" id="modalupdate" value="attention"/>
                                                                    <input type="button" onclick="saveAttention()" id="modalattentionbtn" class="btn btn-success" data-dismiss="modal" name="resetbtn" value="Send"/>
                                                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                      
                      
                      
                      <!-- Attention view modal -->
              <div class="modal fade text-left attention" id="viewattentionmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title text-danger"><i class="ft-alert-triangle"></i> View Attention Required</h4>                                                                    
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="post"> 
                                                                <div class="modal-body">
                                                                  
                                                                             <div class="form-group">
                                                                                <label for="projectinput1"><strong>Note:</strong></label>
                                                                                <div class="attn" id="viewattn">
                                                                                
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="form-group skin skin-square">
                                                                                <fieldset>
                                                                                    <span id="viewshowteam"></span>
                                                                                    <label for="showteam">Show to Team Members</label>
                                                                                </fieldset>
                                                                            </div>
                                                                            
                                                                            <div class="form-group skin skin-square" id="attndetails" style="font-size: 12px;">
                                                                                
                                                                            </div>
                                                                
                                                                
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
            <!-- Attention required modal end -->
            
            
            <div class="modal fade text-left" id="archivemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title text-danger"><i class="ft-alert-triangle"></i> All Attentions on Project</h4>                                                                    
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="post"> 
                                                                <div class="modal-body" id="loadarchive">
                                                                  
                                                                         
                                                                
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
<?php 
include('footer.php');
?>