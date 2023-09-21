<?php 
session_start();
$group = "aprojects";
$menu = "aprojects";
$title = "Projects";
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
	var strURL="../load/load_projects.php?searchkey="+searchkey+"&status="+status+"&department="+department;

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

$(document).ready(function(){
	loadProjects(1);
	$('.filter').change(function(){
		loadProjects(1);
	})
})

function Delete(id)
{
	if(confirm("Delete Project?"))
	{
    	var datastring = {'id':id,'delete':'project_list'};
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
    	            		setTimeout(function() {
    	                        toastr.options = {
    	                            closeButton: true,
    	                            progressBar: true,
    	                            projectClass: "toast-top-full-width",
    	                            showMethod: 'slideDown',
    	                            timeOut: 4000
    	                        };
    	                        toastr.success('Project deleted successfully');
    	                        
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
    	                            timeOut: 4000
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
</script>

<section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Projects</h4>
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
                                            <?php 
                                            if($authaddnew)
                                            {
                                            ?>
                                            <div class="col-md-3">
                                                <a href="project_setup" class="btn btn-success pull-right">Add New</a>
                                            </div>
                                            <?php 
                                            }
                                            ?>
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
                                                            <th>Principal Investigator</th>
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

<?php 
include('footer.php');
?>