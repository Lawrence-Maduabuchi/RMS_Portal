<?php session_start();
$group="security";
$menu="authorize";
$title="Authorize";
$menuid="authorize";
$submenu="";

include('../admin/header.php'); 
if(!$authorize)
{
    echo '<script>window.location="index"</script>';
}
$_SESSION['isEdit']=false;

if(isset($_POST['roleid']))
{
    $_SESSION['roleid']=$_POST['roleid'];
}
$sql="select id,Name from roles where id=:id";
$field=array(':id'=>$_SESSION['roleid']);
$q=$con->select_query($sql,$field);
if($q)
{
    foreach ($q as $r)
    {
        $_SESSION['rolename']=$r['Name'];
    }
}

function GetGroupCode($menucode,$con)
{
    $groupcode="";
    $sql="select GroupCode from menuitem where Code=:code";
    $q=$con->select_query($sql,array(':code'=>$menucode));
    if($q)
    {
        foreach($q as $r)
        {
            $groupcode=$r['GroupCode'];
        }
    }
    return $groupcode;
}
$selectedgroup = "";
if(isset($_POST['groupcode']))
{
    $selectedgroup = $_POST['groupcode'];
}
?>
<script language="javascript" type="text/javascript">
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
	
	function loadAuthorize() {		

		var groupcode = ""; 
		var strURL="../load/loadauthorize.php?groupcode="+groupcode;
		document.getElementById('loadauth').innerHTML="<img src='../pics/loading.gif'/>";
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('loadauth').innerHTML=req.responseText;						
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
<script>
function confirmDelete()
{
	if(!confirm("Are you sure you want to delete this Role?"))
	{
		return false;
	}
	return true;
}

$(document).ready(function(){
	loadAuthorize();
    //for view
	$(".allowview").click(function() {
		$("#allview").prop("checked", false);
	});
	
	$('#allview' ).change(function() {
		$(".allowview").prop("checked", $("#allview").prop("checked"))
	});
	

	//for new
	$(".allownew").click(function() {
		$("#allnew").prop("checked", false);
	});
	
	$('#allnew' ).change(function() {
		$(".allownew").prop("checked", $("#allnew").prop("checked"))
	});


	//for delete
	$(".allowdelete").click(function() {
		$("#alldelete").prop("checked", false);
	});
	
	$('#alldelete' ).change(function() {
		$(".allowdelete").prop("checked", $("#alldelete").prop("checked"))
	});


	//for update
	$(".allowupdate").click(function() {
		$("#allupdate").prop("checked", false);
	});
	
	$('#allupdate' ).change(function() {
		$(".allowupdate").prop("checked", $("#allupdate").prop("checked"))
	});


	//for authorize
	$(".allowauth").click(function() {
		$("#allauthorize").prop("checked", false);
	});
	
	$('#allauthorize' ).change(function() {
		$(".allowauth").prop("checked", $("#allauthorize").prop("checked"))
	});
});
</script>
 
 <style>
.all-access
{
	background:#51b9ff!important;
	color:#fff;
}
</style>
<link rel="stylesheet" type="text/css" href="../css/libs/font-awesome.css"/>
 
<link rel="stylesheet" type="text/css" href="../css/compiled/theme_styles.css"/>

<section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Authorize : <span class='badge badge-success'><?php echo $_SESSION['rolename'];?></span></h4>
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
                                            <div class="col-md-12 table-responsive">
                                                <form method="post" action="authorize">
                                                    <?php include('../include/insert.php'); ?>
                                                        <div class="row row-pad">
                                                            <!-- <div class="col-md-3">
                                                                <input type="text" id="searchmenu" class="form-control" placeholder="search by group/item name"/>
                                                            </div> -->
                                                            <div class="col-md-12">
                                                                <input type="submit" name="save" value="Save" style="margin-left:10px;" class="btn btn-success pull-right"/>
                                                                <a class="btn btn-warning pull-right" href="role_list">Back</a>
                                                            </div>
                                                        </div>
                                                        <div class="row row-pad">
                                                            <div class="col-md-12" style="overflow: auto">
                                                                <table class="table table-striped table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>S/N</th>
                                                                            <th>Menu Group</th>
                                                                            <th>Menu Item</th>
                                                                            <th>View
                                                                                <div class="checkbox-nice">
                                                                                     <input type="checkbox" id="allview"/>
                                                                                     <label for="allview"></label>
                                                                                </div>
                                                                            </th>
                                                                            <th>Add New
                                                                                <div class="checkbox-nice">
                                                                                     <input type="checkbox" id="allnew"/>
                                                                                     <label for="allnew"></label>
                                                                                </div>
                                                                            </th>
                                                                            <th>Delete
                                                                                <div class="checkbox-nice">
                                                                                     <input type="checkbox" id="alldelete"/>
                                                                                     <label for="alldelete"></label>
                                                                                </div>
                                                                            </th>
                                                                            <th>Update
                                                                                <div class="checkbox-nice">
                                                                                     <input type="checkbox" id="allupdate"/>
                                                                                     <label for="allupdate"></label>
                                                                                </div>
                                                                            </th>
                                                                            <th>Authorize
                                                                                <div class="checkbox-nice">
                                                                                     <input type="checkbox" id="allauthorize"/>
                                                                                     <label for="allauthorize"></label>
                                                                                </div>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="loadauth">
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="insert" value="authorize"/>
                                                        </form>
                                           </div>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>
               </section>

 
<?php  
include('../include/delete.php');
include('footer.php'); ?>