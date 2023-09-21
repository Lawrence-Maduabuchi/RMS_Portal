<?php 
session_start();
$group="security";
$menu="";
$menuid="";
$submenu="";

$title="Menu Item Setup";
include('../admin/header.php'); 

$code="";
$text="";
$url="";
$hasmenu="";
$topmenu="";
$order="";
$status = 0;
$readonly="";

if(!isset($_SESSION['isEdit']))
{
    $_SESSION['isEdit']=false;
}
if(isset($_POST['menucode']))
{
    
   $readonly="readonly";
   $sql="select * from menuitem where Code=:code";
   $value=array(':code'=>$_POST['menucode']);
   $r=$con->select_query($sql,$value);
   foreach($r as $value)
   {
       $_SESSION["menucode"]=$_POST['menucode'];
       $code=$value['Code'];
       $text=$value['Text'];
       $url=$value['Url'];
       $hasmenu=$value['HasMenuItems'];
       $order=$value['MenuItemOrder'];
       $topmenu=$value['TopMenuCode'];
       $status = $value['status'];
       $_SESSION['isEdit']=true;
       
   }
}
?>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
            <header class="panel-heading">
                              Menu Item Setup
                   </header>
            <div class="panel-body">
            <form method="post" action="menu_item_setup">
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
                    <label for="code">Group Code</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="groupcode" class="form-control" maxlength="20" value="<?php echo $_SESSION['groupcode'];?>" readonly required/>
                </div>
            </div>
            <div class="row row-pad">
                <div class="col-md-2">
                    <label for="code">Code</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="code" class="form-control" maxlength="20" value="<?php echo $code;?>" <?php echo $readonly; ?> required/>
                </div>
            </div>
            <div class="row row-pad">
                <div class="col-md-2">
                    <label for="name">Text</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="text" class="form-control" maxlength="255" required value="<?php echo $text;?>"/>
                </div>
            </div>
            <div class="row row-pad">
                <div class="col-md-2">
                    <label for="capacity">Top Menu Code</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="topmenu" class="form-control" value="<?php echo $topmenu;?>"/>
                </div>
            </div>
            <div class="row row-pad">
                <div class="col-md-2">
                    <label for="capacity">URL</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="url" class="form-control" value="<?php echo $url;?>"/>
                </div>
            </div>
            <div class="row row-pad">
                <div class="col-md-2">
                    <label for="capacity">Menu Item Order</label>
                </div>
                <div class="col-md-6">
                    <input type="number" name="order" class="form-control" value="<?php echo $order;?>" required/>
                </div>
            </div>
            <div class="row row-pad">
                <div class="col-md-2">
                    
                </div>
                <div class="col-md-6">
                    <input type="checkbox" name="hasmenu" <?php echo ($hasmenu==1 ? "checked" : "")?>/> Has Menu Items
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
                        <input type="hidden" name="update" value="menu_item_setup"/>
                        <input type="submit" name="save" class="btn btn-info" value="Save"/>';

                    } else {
                        echo '
                        <input type="hidden" name="insert" value="menu_item_setup"/>
                        <input type="submit" name="save" class="btn btn-info" value="save"/>
                        <input type="submit" name="savecontinue" class="btn btn-info" value="Save and Continue"/>';

                    }
                ?>
                    <a href="menu_item_list?groupcode=<?php echo $_SESSION['groupcode'];?>" class="btn btn-warning">Cancel</a>
                </div>
            </div>
            </form>
        </div>
        </section>
     </div>
  </div>
<?php 
include('../admin/footer.php'); ?>