<?php 
session_start();
include('../include/connection.php');
include('../include/app_config.php');
require_once '../lib/dbconfig.php';
include('../lib/app_stat.php');
?>

<div class="row row-pad">
    <div class="col-md-12">
        <table class="table table-hover smaller">
             <thead>
                 <tr>
                   <th>SN</th>
                   <th>Title</th>
                   <th>Authors</th>
                   <th>Year</th>
                   <th>Location</th>
                   <th>Page No.</th>
                   <th>Date Created</th>
                   <?php 
                   if(!isset($_GET['page']))
                   {
                   ?>
                   <th colspan="2">Actions</th>
                   <?php 
                   }
                   ?>
                </tr>
            </thead>
            <tbody>
                  <?php 
                  $sql = "select * from conference";
                  
                  $conditions = array();
                  $fields=array();
                  
                  $conditions[] = "project_id=:id";
                  $fields[':id'] = $_GET['project_id'];
                  
                  if(isset($_GET['searchkey']) && $_GET['searchkey'] !="") {
                      $conditions[] = "(title like :searchkey OR conference_title like :searchkey OR authors like :searchkey OR year like :searchkey OR page_no like :searchkey)";
                      $keyword = '%'.$_GET['searchkey'].'%';
                      $fields[':searchkey'] = $keyword;
                  }
                  
                  if (count($conditions) > 0) {
                      $sql .= " WHERE " . implode(' AND ', $conditions);
                  }
                  
                  $sql .= " order by `title`";
                  $r=$con->select_query($sql,$fields);
                  $sn=1;
                  foreach($r as $value)
                  {
                      echo '<tr>
                        <td style="font-size:12px;">'.$sn.'</td>
                        <td><strong>'.$value['title'].'</strong><br/>'.$value['conference_title'].'</td>
                        <td>'.$value['authors'].'</td>
                        <td>'.$value['year'].'</td>
                        <td>'.$value['location'].'</td>
                        <td>'.$value['page_no'].'</td>
                        <td>'.$value['date_created'].'</td>';
                      if(!isset($_GET['page']))
                      {
                        echo '<td><a href="publication_setup?id='.$value['id'].'&type='.CONFERENCE.'" class="btn btn-warning btn-sm">Edit</a></td>
                        <td><button onclick="Delete('.$value['id'].',\'conference_list\')" class="btn btn-danger btn-sm">Delete</button></td>';
                      }
                      echo '</tr>';
                      $sn++;
                  
                  }
                  
                  ?>
            </tbody>
        </table>
    </div>
</div>