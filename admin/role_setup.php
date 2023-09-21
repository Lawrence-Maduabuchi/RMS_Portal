<?php 
session_start();
$group="asecurity";
$menu="aroles";
$menuid="aroles";

$title="Role Setup";
include('header.php'); 

if(!$authupdate && !$authaddnew)
{
    echo '<script>window.location="index"</script>';
}

$status="";
$name="";
$code="";
$readonly="";
if(isset($_POST['roleid']))
{
    $_SESSION['roleid']=$_POST['roleid'];

   $sql="select * from roles where id=:id";
   $value=array(':id'=>$_SESSION['roleid']);
   $r=$con->select_query($sql,$value);
   foreach($r as $value)
   { 
       $status=$value['status'];
       $code=$value['code'];
       $name=$value['name'];
       $readonly="readonly";
       $_SESSION['isEdit']=true;  
   }
}
?>
  
  <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Role Setup</h4>
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
                                        <form method="post" action="role_setup">
                                        <div class="row row-pad">
                                            <div class="col-lg-12">
                                                <?php 
                                                if($_SESSION['isEdit']==true){
                                                    include('../include/update.php');
                                                } else {
                                                    include('../include/insert.php');
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row row-pad">
                                            <div class="col-md-2">
                                                <label for="name">Code</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="code" class="form-control" value="<?php echo $code;?>" <?php echo $readonly;?>/>
                                            </div>
                                        </div>
                                        
                                        <div class="row row-pad">
                                            <div class="col-md-2">
                                                <label for="name">Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="name" class="form-control" value="<?php echo $name;?>" required/>
                                            </div>
                                        </div>
                                                  
                                        <div class="row row-pad">
                                            <div class="col-md-2">
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <input type="checkbox" name="status" <?php echo ($status==1 ? "checked" : "")?>/> Active
                                            </div>
                                        </div>
                                       
                                        <div class="row row-pad">
                                            <div class="col-md-2">
                                                
                                            </div>
                                            <div class="col-md-6">
                                            <?php 
                                                if($_SESSION['isEdit']==true){
                                                    echo '
                                                    <input type="hidden" name="update" value="role_setup"/>
                                                    <input type="submit" name="save" class="btn btn-info" value="Save"/>';
                                                } else {
                                                    echo '
                                                    <input type="hidden" name="insert" value="role_setup"/>
                                                    <input type="submit" name="save" class="btn btn-info" value="save"/>
                                                    <input type="submit" name="savecontinue" class="btn btn-info" value="Save and Continue"/>';
                                                }
                                            ?>
                                                <a href="role_list" class="btn btn-warning">Cancel</a>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>
               </section>
<?php include('../admin/footer.php'); ?>