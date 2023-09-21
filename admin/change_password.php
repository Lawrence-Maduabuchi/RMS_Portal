<?php 
session_start();
$group = "asecurity";
$menu = "change_password";
$title = "Change Password";
include('header.php');

if(!$authupdate)
{
    echo '<script>window.location="index"</script>';
}
?>

<script>
function SaveUpdate()
{
	$('#msg').html('<img src="img/loading.gif"/>');
	
	var datastring = $("#pwdform").serialize();

	$.blockUI({ css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
    } });
	
		
	$.ajax({
	            type: "POST",
	            url: "../include/update_ajax.php",
	            data: datastring,
	            dataType: 'json',
	            cache: false,
	            success: function(data) {
	            	$('html,body').animate({ scrollTop: 0 }, 'fast');
	            	$.unblockUI();
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
</script>

<section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Change Password</h4>
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
                                        <form class="form" action="change_password" method="post" id="pwdform">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <div id="msg"></div>
                                                        </div>
                                                        
                                                        <div class="row row-pad">
                                                            <div class="col-md-3">
                                                                <label for="code">Old Password</label>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <input type="password" name="oldpassword" class="form-control" required/>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row row-pad">
                                                            <div class="col-md-3">
                                                                <label for="code">New Password</label>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <input type="password" name="newpassword" class="form-control" required/>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row row-pad">
                                                            <div class="col-md-3">
                                                                <label for="code">Repeat Password</label>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <input type="password" name="repassword" class="form-control" required/>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="row row-pad">
                                                            <div class="col-md-3">
                                                                
                                                            </div>
                                                            <div class="col-md-7">
                                                                <input type="hidden" name="update" value="change_password"/>
                                                                <input type="button" name="save" class="btn btn-info" value="Change" onclick="SaveUpdate()"/>
                                                            </div>
                                                        </div>
                                                    </div>
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