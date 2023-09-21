<?php 
session_start();
$title = "Activate Account";
$menu = "login";
include('header.php');
?>
                <section class="flexbox-container" style="margin-bottom: 30px;">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-9 col-md-8 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <div class="p-1"><img src="app-assets/images/logo/logo.png" style="max-width: 200px" alt="branding logo"></div>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Activate Account</span></h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <img src="app-assets/images/user-active.png" style="max-width: 100%; margin-bottom: 50px;" alt="branding logo"/>
                                                <?php 
                                        	       if(isset($_GET['key']))
                                        	       {
                                        	           $sql = "select id from users where reset_key=:key";
                                        	           $q = $con->select_query($sql, array(':key'=>$_GET['key']));
                                        	           if(count($q) > 0)
                                        	           {
                                        	               $sql = "update users set is_active=1, reset_key=:empty where reset_key=:key";
                                        	               $a = $con->update_query($sql, array(':key'=>$_GET['key'],':empty'=>""));
                                        	               if($a)
                                        	               {
                                        	                   echo '<h2 style="text-align: center;">Account Activated successfully!</h2>';
                                        	               }
                                        	           }
                                        	           else 
                                        	           {
                                        	               echo '<div class="alert alert-danger">Invalid activation code.</div>';
                                        	           }
                                        	       }
                                        	       else
                                        	       {
                                        	           echo '<div class="alert alert-danger">Invalid activation code.</div>';
                                        	       }
                                        	    ?>
                                                
                                                <p class="text-center"><a href="login" class="btn btn-info btn-lg">Login</a></p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

           <?php include('footer.php');?>