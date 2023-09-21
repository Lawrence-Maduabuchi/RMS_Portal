<?php 
session_start();
include('../include/connection.php');

$title = "";
$jtitle = "";
$authors = "";
$year = "";
$vol = "";
$issue = "";
$pageno = "";
$quality = "";
if(isset($_GET['id']))
{
    $sql = "select * from journal where id=:id";
    $q = $con->select_query($sql,array(':id'=>$_GET['id']));
    foreach($q as $r)
    {
        $title = $r['title'];
        $jtitle = $r['journal_title'];
        $authors = $r['authors'];
        $year = $r['year'];
        $vol = $r['vol'];
        $issue = $r['issue'];
        $pageno = $r['page_no'];
        $quality = $r['quality'];
    }
}
?>
<div class="form-group col-md-6">
    <label for="projectinput1">Title</label>
    <input type="text" class="form-control" value="<?php echo $title?>" name="title">
</div>

<div class="form-group col-md-6">
    <label for="projectinput1">Journal Title</label>
    <input type="text" class="form-control" value="<?php echo $jtitle?>" name="jtitle">
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
    <label for="projectinput1">vol.</label>
    <input type="text" class="form-control" value="<?php echo $vol?>" name="vol">
</div>

<div class="form-group col-md-6">
    <label for="projectinput1">Issue</label>
    <input type="text" class="form-control" value="<?php echo $issue?>" name="issue">
</div>

<div class="form-group col-md-6">
    <label for="projectinput1">Page Number</label>
    <input type="text" class="form-control" value="<?php echo $pageno?>" name="pageno">
</div>

<div class="form-group col-md-6">
    <label for="projectinput1">Journal Quality</label>
    <select name="quality" id="jquality" class="form-control">
        <option>Q1</option>
        <option>Q2</option>
        <option>Q3</option>
        <option>Q4</option>
    </select>
    <?php 
    if(!empty($quality))
    {
        echo '<script>document.getElementById("jquality").value="'.$quality.'"</script>';
    }
    ?>
</div>
