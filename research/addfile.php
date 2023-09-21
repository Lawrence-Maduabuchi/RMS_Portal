<?php
$count = $_GET['count'];
?>

<div class="col-md-4">
    <div class="upload-file">
                                                                                            <input type="text" class="form-control" placeholder="Caption*" name="caption<?php echo $count?>">
                                                                                            <div class="fileupload fileupload-new" data-provides="fileupload" style="margin-top: 10px">
                                                                                                <span class="btn btn-white btn-file">
                                                                                                <span class="fileupload-new"><i class="icon-paper-clip"></i> Select file</span>
                                                                                                <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                                                                <input type="file" class="default" name="uploadfile<?php echo $count?>" id="uploadfile<?php echo $count?>"/>
                                                                                                </span>
                                                                                                  <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                                                                  <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                                                              </div>
                                                                                           </div>
</div>