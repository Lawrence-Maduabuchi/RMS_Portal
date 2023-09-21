<?php 
session_start();

include('../include/connection.php');

$title = "";
$authors = "";
$year = "";
$patentno = "";
if(isset($_GET['id']))
{
    $sql = "select * from patent where id=:id";
    $q = $con->select_query($sql,array(':id'=>$_GET['id']));
    foreach($q as $r)
    {
        $title = $r['title'];
        $authors = $r['authors'];
        $year = $r['year'];
        $patentno = $r['patent_no'];
    }
}
?>
<div class="form-group col-md-6">
    <label for="projectinput1">Title</label>
    <input type="text" class="form-control" value="<?php echo $title?>" name="title">
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
    <label for="projectinput1">Patent Number</label>
    <input type="text" class="form-control" value="<?php echo $patentno?>" name="patentno">
</div>
