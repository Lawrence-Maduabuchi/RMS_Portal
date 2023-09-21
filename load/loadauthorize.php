<?php 
session_start();
include('../include/app_config.php');
include('../include/connection.php');
unset($_SESSION['menuitem']);
                                    $sql="select mn.*,mg.Text AS GroupText from menuitem mn left outer join menugroup mg on mn.GroupCode=mg.Code WHERE mg.status=1 AND mn.status=1";
                                    $fields = array();
                                    if($_GET['groupcode'] != "")
                                    {
                                        $sql.=" AND mg.Code=:groupcode";
                                        $fields[':groupcode'] = $_GET['groupcode'];
                                    }
                                    $sql.=" order by mg.Code, mn.Code";
                                    $r=$con->select_query($sql, $fields);
                                    $sn=1;
                                    $i=0;
                                    
                                    $statusnew="";
                                    $statusup="";
                                    $statusdel="";
                                    $statusview="";
                                    $statusauth="";
                                   
                                    foreach($r as $value)
                                    {   
                                        $_SESSION['menuitem'][$i]=$value['Code'];
                                        $query="select * from roleauth where menucode=:menucode AND roleid=:roleid";
                                        $fieldsq=array(':menucode'=>$value['Code'],':roleid'=>$_SESSION['roleid']);
                                        $qr=$con->select_query($query,$fieldsq);
                                        if($qr)
                                        {
                                            
                                            foreach($qr as $val)
                                            { 
                                                $statusnew="";
                                                $statusup="";
                                                $statusdel="";
                                                $statusview="";
                                                $statusauth="";
                                                if($val['allow_new']==1)
                                                {
                                                    $statusnew="checked";
                                                }
                                                if($val['allow_update']=='1')
                                                {
                                                    $statusup="checked";
                                                }
                                                if($val['allow_delete']=='1')
                                                {
                                                    $statusdel="checked";
                                                }
                                                if($val['allow_view']=='1')
                                                {
                                                    $statusview="checked";
                                                }
                                                if($val['allow_auth']=='1')
                                                {
                                                    $statusauth="checked";
                                                }
                                            }
                                            
                                            echo '<tr>
                                                <td style="font-size:12px;">'.$sn.'</td>
                                                <td>'.$value['GroupText'].'</td>
                                                <td>'.$value['Text'].'</td>
                                                <td>
                                                        <div class="checkbox-nice">
                                                        <input type="checkbox" id="allowview'.$value['Code'].'" name="view'.$value['Code'].'" '.$statusview.' class="allowview"/>
                                                            <label for="allowview'.$value['Code'].'"></label>
                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="checkbox-nice">
                                                        <input type="checkbox" id="allownew'.$value['Code'].'" name="new'.$value['Code'].'" '.$statusnew.' class="allownew"/>
                                                            <label for="allownew'.$value['Code'].'"></label>
                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="checkbox-nice">
                                                        <input type="checkbox" id="allowdelete'.$value['Code'].'" name="delete'.$value['Code'].'" '.$statusdel.' class="allowdelete"/>
                                                        <label for="allowdelete'.$value['Code'].'"></label>
                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="checkbox-nice">
                                                        <input type="checkbox" id="allowupdate'.$value['Code'].'" name="update'.$value['Code'].'" '.$statusup.' class="allowupdate"/>
                                                        <label for="allowupdate'.$value['Code'].'"></label>
                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="checkbox-nice">
                                                        <input type="checkbox" id="allowauth'.$value['Code'].'" name="auth'.$value['Code'].'" '.$statusauth.' class="allowauth"/>
                                                        <label for="allowauth'.$value['Code'].'"></label>
                                                        </div>
                                                </td>
                                            </tr>';
                                            $sn++;
                                            $i++;
                                        }
                                        else 
                                        {
                                            echo '<tr>
                                                <td style="font-size:12px;">'.$sn.'</td>
                                                <td>'.$value['GroupText'].'</td>
                                                <td>'.$value['Text'].'</td>
                                                <td>
                                                        <div class="checkbox-nice">
                                                        <input type="checkbox" id="allowview'.$value['Code'].'" name="view'.$value['Code'].'" class="allowview"/>
                                                            <label for="allowview'.$value['Code'].'"></label>
                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="checkbox-nice">
                                                        <input type="checkbox" id="allownew'.$value['Code'].'" name="new'.$value['Code'].'" class="allownew"/>
                                                            <label for="allownew'.$value['Code'].'"></label>
                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="checkbox-nice">
                                                        <input type="checkbox" id="allowdelete'.$value['Code'].'" name="delete'.$value['Code'].'" class="allowdelete"/>
                                                        <label for="allowdelete'.$value['Code'].'"></label>
                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="checkbox-nice">
                                                        <input type="checkbox" id="allowupdate'.$value['Code'].'" name="update'.$value['Code'].'" class="allowupdate"/>
                                                        <label for="allowupdate'.$value['Code'].'"></label>
                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="checkbox-nice">
                                                        <input type="checkbox" id="allowauth'.$value['Code'].'" name="auth'.$value['Code'].'" class="allowauth"/>
                                                        <label for="allowauth'.$value['Code'].'"></label>
                                                        </div>
                                                </td>
                                            </tr>';
                                            $sn++;
                                            $i++;
                                        }
                                    } 
                                ?>