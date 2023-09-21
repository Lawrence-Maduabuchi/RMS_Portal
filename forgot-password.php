<?php 
session_start();
$title = "Forgot Password";
$menu = "login";
include('header.php');
?>
                <section class="flexbox-container" style="margin-bottom: 30px;">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-6 col-md-8 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <div class="p-1"><img src="app-assets/images/logo/logo.png" style="max-width: 200px" alt="branding logo"></div>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>AFIT Research Management System</span></h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form-horizontal form-simple" method="post" action="forgot-password">
                                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                                <?php 
                            						include('utility/forgotpassword.php');
                            				    ?>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                                <input type="text" class="form-control" name="email" placeholder="Enter your email" required/>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>
                                            <div style="height: 20px"></div>
                                            <input type="hidden" value="reset" name="resetpassword"/>
                                            <button type="submit" class="btn btn-info btn-block"><i class="ft-unlock"></i> Login</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

           <?php include('footer.php');?>