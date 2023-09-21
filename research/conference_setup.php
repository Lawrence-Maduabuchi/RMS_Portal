<?php 
session_start();
include('../include/connection.php');

$title = "";
$ctitle = "";
$authors = "";
$year = "";
$location = "";
$pageno = "";
if(isset($_GET['id']))
{
    $sql = "select * from conference where id=:id";
    $q = $con->select_query($sql,array(':id'=>$_GET['id']));
    foreach($q as $r)
    {
        $title = $r['title'];
        $ctitle = $r['conference_title'];
        $authors = $r['authors'];
        $year = $r['year'];
        $location = $r['location'];
        $pageno = $r['page_no'];
    }
}
?>
<div class="form-group col-md-6">
    <label for="projectinput1">Title</label>
    <input type="text" class="form-control" value="<?php echo $title?>" name="title">
</div>

<div class="form-group col-md-6">
    <label for="projectinput1">Conference Title</label>
    <input type="text" class="form-control" value="<?php echo $ctitle?>" name="ctitle">
</div>

<div class="form-group col-md-6">
    <label for="projectinput1">Authors</label>
    <input type="text" class="form-control" value="<?php echo $authors?>" name="authors">
</div>

<div class="form-group col-md-6">
    <label for="projectinput1">Year</label>
    <input type="text" class="form-control" value="<?php echo $year?>" name="year">
</div>

<div class="form-group col-md-6">
    <label for="projectinput1">Location</label>
    <input type="text" class="form-control" placeholder="City, Country" value="<?php echo $location?>" name="location">
</div>

<div class="form-group col-md-6">
    <label for="projectinput1">Page Number</label>
    <input type="text" class="form-control" value="<?php echo $pageno?>" name="pageno">
</div>
