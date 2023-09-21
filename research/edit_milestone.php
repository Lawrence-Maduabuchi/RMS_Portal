<?php 
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');

$desc = "";
$percentage = "";

if($_GET['type'] == "task")
{
    $sql = "select * from task_milestones where id=:id";
    $q = $con->select_query($sql,array(':id'=>$_GET['milestone_id']));
    foreach($q as $r)
    {
        $desc = $r['description'];
        $percentage = $r['percentage'];        
    }
}
else if($_GET['type'] == "project")
{
    $sql = "select * from project_milestones where id=:id";
    $q = $con->select_query($sql,array(':id'=>$_GET['milestone_id']));
    foreach($q as $r)
    {
        $desc = $r['description'];
        $percentage = $r['percentage'];
    }
}

?>
<form method="post" id="editmilestoneform"> 
                                                                <div class="modal-body">
                                                                     
                                                                            <div class="row row-pad">
                                                                                <div class="col-md-12" id="msguploadedit"></div>
                                                                            </div>   
                                                                          <div class="row row-pad">
                                                                                <div class="form-group col-md-12">
                                                                                    <label class="control-label required">Description</label>
                                                                                    <textarea class="form-control" name="description"><?php echo $desc?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row row-pad">
                                                                                <div class="form-group col-md-6">
                                                                                    <label class="control-label required">Current Progress Percentage*</label>
                                                                                    <div class="input-group">
                                                                                        <input type="text" class="form-control" name="percentage" placeholder="Progress Percentage" value="<?php echo $percentage?>" aria-describedby="basic-addon4">
                                                                                        <div class="input-group-append">
                                                                                            <span class="input-group-text"><i class="ft-percent"></i></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <?php 
                                                                            if($_GET['type'] == "task")
                                                                            {
                                                                                $sql = "select * from task_uploads where task_milestone_id=:id";
                                                                            }
                                                                            else if($_GET['type'] == "project")
                                                                            {
                                                                                $sql = "select * from project_uploads where project_milestone_id=:id";
                                                                            }
                                                                            $q = $con->select_query($sql,array(':id'=>$_GET['milestone_id']));
                                                                            if(count($q) > 0)
                                                                            {
                                                                                echo "<div class='row row-pad'>
                                                                                        <div class='col-md-12'><h5>Milestone Uploads</h5></div>";
                                                                            
                                                                                foreach($q as $r)
                                                                                {
                                                                                    echo "<div class='col-md-6 upload-item' id='taskupload".$r['id']."'><i class='ft-trash-2' title='Delete File' onclick='DeleteFile(".$r['id'].",\"".$r['file']."\")'></i><a href='".UPLOADS_FOLDER.$r['file']."' class='upload-link' target='_blank'>".$r['caption']."</a></div>";
                                                                                }
                                                                                
                                                                                echo '</div>';
                                                                            }
                                                                            ?>
                                                                            
                                                                            <div class="row row-pad">
                                                                                <div class="form-group col-md-12">
                                                                                    <span class="text-danger">Each upload cannot exceed 10MB</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row row-pad">
                                                                                <div class="form-group col-md-12">
                                                                                    <label class="control-label required">Upload Supporting Documents</label>
                                                                                    <div class="row" id="uploaddivedit">
                                                                                        <div class="col-md-4">
                                                                                            <div class="upload-file">
                                                                                                <input type="text" class="form-control" placeholder="Caption*" name="caption1">
                                                                                                <div class="fileupload fileupload-new" data-provides="fileupload" style="margin-top: 10px">
                                                                                                    <span class="btn btn-white btn-file">
                                                                                                    <span class="fileupload-new"><i class="icon-paper-clip"></i> Select file</span>
                                                                                                    <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                                                                    <input type="file" class="default" name="uploadfileedit1" id="uploadfileedit1"/>
                                                                                                    </span>
                                                                                                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                                                                      <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                                                                  </div>
                                                                                           </div>
                                                                                        </div>                                                                                         
                                                                                    </div>
                                                                                    <input type="hidden" name="count" id="uploadCountEdit" value="1"/>
                                                                                    <a href="javascript:;" class="add-file" onclick="addFileEdit()"><i class="ft-plus"></i> Add File</a>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <?php 
                                                                            if($_GET['type'] == "task")
                                                                            {
                                                                                $sql = "select * from task_photos where task_milestone_id=:id";
                                                                            }
                                                                            else if($_GET['type'] == "project")
                                                                            {
                                                                                $sql = "select * from project_photos where project_milestone_id=:id";
                                                                            }
                                                                            $q = $con->select_query($sql,array(':id'=>$_GET['milestone_id']));
                                                                            if(count($q) > 0)
                                                                            {
                                                                                echo "<div class='row row-pad'>
                                                                                        <div class='col-md-12'><h5>Task Photos</h5></div>";
                                                                            
                                                                                foreach($q as $r)
                                                                                {
                                                                                    echo "<div class='col-md-3 upload-item' id='taskphoto".$r['id']."'><i class='ft-trash-2' title='Delete Photo' onclick='DeletePhoto(".$r['id'].",\"".$r['photo']."\")'></i><img src='".UPLOADS_FOLDER.$r['photo']."' class='thumbnail' style='width: 100%'/><span>".$r['caption']."</span></div>";
                                                                                }
                                                                                
                                                                                echo '</div>';
                                                                            }
                                                                            ?>
                                                                            <hr/>
                                                                            <div class="row row-pad">
                                                                                <div class="form-group col-md-12">
                                                                                    <label class="control-label required">Upload Task Photos</label>
                                                                                    <div class="row" id="photouploaddivedit">
                                                                                        <div class="col-md-4">
                                                                                            <div class="bordered">
                                                                                                <input type="text" class="form-control" name="photocaption1" placeholder="caption" style="margin-bottom: 5px;"/>
                                                                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                                                      <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                                                                           <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                                                                                      </div>
                                                                                                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                                                                      <div>
                                                                                                       <span class="btn btn-white btn-file">
                                                                                                       <span class="fileupload-new"><i class="icon-paper-clip"></i> Select image</span>
                                                                                                       <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                                                                       <input type="file" id="photoedit1" name="photoedit1" class="default" />
                                                                                                       </span>
                                                                                                          <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="icon-trash"></i> Remove</a>
                                                                                                      </div>
                                                                                               </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <input type="hidden" name="photocount" id="uploadPhotoCountEdit" value="1"/>
                                                                                    <a href="javascript:;" class="add-file" onclick="addPhotoEdit()"><i class="ft-plus"></i> Add Photo</a>
                                                                                </div>
                                                                            </div>
                                                                
                                                                
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="hidden" name="project_id" id="milestonetaskid"/>
                                                                    <input type="hidden" name="id" value="<?php echo $_GET['milestone_id']?>"/>
                                                                    <input type="hidden" name="type" value="<?php echo $_GET['type']?>"/>
                                                                    <input type="hidden" name="update" value="milestone"/>
                                                                    <input type="button" onclick="editMileStone()" class="btn btn-success" name="resetbtn" value="Save Milestone"/>
                                                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                                </form>