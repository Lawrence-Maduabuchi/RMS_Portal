<?php 
session_start();
include('../include/app_config.php');

include('../include/connection.php');

$title = "";
$authors = "";
$year = "";
$publisher = "";
$chapterno = "";
$pageno = "";
if(isset($_GET['id']))
{
    $sql = "select * from book where id=:id";
    $q = $con->select_query($sql,array(':id'=>$_GET['id']));
    foreach($q as $r)
    {
        $title = $r['title'];
        $authors = $r['authors'];
        $year = $r['year'];
        $publisher = $r['publisher'];
        $chapterno = $r['chapter_no'];
        $pageno = $r['page_no'];
    }
}
?>
<div class="form-group col-md-6">
    <label for="projectinput1">Title</label>
    <input type="text" class="form-control" value="<?php echo $title?>" name="title">
</div>

<div class="form-group col-md-6">
    <label for="projectinput1">Publisher</label>
    <input type="text" class="form-control" value="<?php echo $publisher?>" name="publisher">
</div>

<div class="form-group col-md-6">
    <label for="projectinput1">Authors</label>
    <input type="text" class="form-control" value="<?php echo $authors?>" name="authors">
</div>

<div class="form-group col-md-6">
    <label for="projectinput1">Year</label>
    <input type="text" class="form-control" value="<?php echo $year?>" name="year">
</div>
<?php 
if($_GET['type'] == BOOK_CHAPTER)
{
?>
<div class="form-group col-md-6">
    <label for="projectinput1">Page Number</label>
    <input type="text" class="form-control" value="<?php echo $pageno?>" name="pageno">
</div>


<div class="form-group col-md-6">
    <label for="projectinput1">Book Chapter Number</label>
    <input type="text" class="form-control" value="<?php echo $chapterno?>" name="chapterno">
</div>
<?php 
}
?>
