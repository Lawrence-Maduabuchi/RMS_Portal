<?php 
session_start();
$group = "cv";
$menu = "amembers";
$title = "Members";
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


function loadMembers(showloading) {
	if(showloading == 1)		
	document.getElementById('load').innerHTML='<img src="../app-assets/images/loading.gif"/>';
	var searchkey = document.getElementById('searchkey').value;
	var status =  document.getElementById('status').value;
	var department =  document.getElementById('department').value;
	var strURL="../load/load_members.php?searchkey="+searchkey+"&status="+status+"&department="+department;

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
	loadMembers(1);
	$('.filter').change(function(){
		loadMembers(1);
	})
})

function Delete(id)
{
	if(confirm("Delete Member?"))
	{
    	var datastring = {'id':id,'delete':'member_list'};
    	$.ajax({
    	            type: "POST",
    	            url: "../include/delete_ajax.php",
    	            data: datastring,
    	            dataType: 'json',
    	            cache: false,
    	            success: function(data) {
    	            	if(data.success == 1)
    	            	{       
    	            		loadMembers(0);    		
    	            		setTimeout(function() {
    	                        toastr.options = {
    	                            closeButton: true,
    	                            progressBar: true,
    	                            memberClass: "toast-top-full-width",
    	                            showMethod: 'slideDown',
    	                            timeOut: 4000
    	                        };
    	                        toastr.success('Member deleted successfully');
    	                        
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

function SaveId(id, fullname, email)
{
	$('#userid').val(id);
	$('.userfullname').html(fullname);
	$('#useremail').val(email);
}

function ResetPassword()
{
    var datastring = $('#resetform').serialize();
    document.getElementById('msg').innerHTML='<img src="../pics/loading.gif"/>';
    $.ajax({
        cache: false,
        type: "POST",
        url: "../utility/resetpassword.php",
        data: datastring,
        dataType: 'html',
        success: function (data) {
        	$('#msg').html(data);
        
    },
    error: function (xhr, ajaxOptions, thrownError) {
    }
});



}
</script>

<section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Members</h4>
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
                                                    <option value="1">Active</option>
                                                    <option value="0">In-active</option>
                                                </select>
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
                                                <a href="member_setup" class="btn btn-success pull-right">Add New</a>
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
                                                            <th>Photo</th>
                                                            <th>Full Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Category</th>
                                                            <th>Status</th>                                                            
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
               
               
               <!-- Reset Password Modal start -->

              <div class="modal fade text-left" id="resetmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Reset Password - <strong class="userfullname"></strong></h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="post" id="resetform"> 
                                                                <div class="modal-body">
                                                                     
                                                                            <div class="row row-pad">
                                                                                <div class="col-md-12" id="msg"></div>
                                                                            </div>   
                                                                          <div class="row row-pad">
                                                                                <div class="form-group col-md-12">
                                                                                    <label class="control-label required">New Password</label>
                                                                                    <input type="password" name="newpassword" class="form-control"/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row row-pad">
                                                                                <div class="col-md-12">
                                                                                    <label class="control-label required">Repeat Password</label>
                                                                                    <input type="password" name="repeatpassword" class="form-control"/>
                                                                                </div>
                                                                            </div>
                                                                
                                                                
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="hidden" name="userid" id="userid"/>
                                                                    <input type="hidden" name="useremail" id="useremail"/>
                                                                    <input type="hidden" name="update" value="resetpassword"/>
                                                                    <input type="button" onclick="ResetPassword()" class="btn btn-success" name="resetbtn" value="Reset"/>
                                                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Reset Password Modal end -->
<?php 
include('footer.php');
?>