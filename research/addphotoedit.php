<?php
$count = $_GET['count'];
?>

<div class="col-md-4">
    <div class="bordered">
        <input type="text" class="form-control" name="photocaption<?php echo $count?>" placeholder="caption" style="margin-bottom: 5px;"/>
                                                                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                                              <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                                                                   <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                                                                              </div>
                                                                                              <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                                                              <div>
                                                                                               <span class="btn btn-white btn-file">
                                                                                               <span class="fileupload-new"><i class="icon-paper-clip"></i> Select image</span>
                                                                                               <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                                                               <input type="file" id="photoedit<?php echo $count?>" name="photoedit<?php echo $count?>" class="default" />
                                                                                               </span>
                                                                                                  <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="icon-trash"></i> Remove</a>
                                                                                              </div>
                                                                                          </div>
                                                                                        </div>
                                                                                  </div>
