<?php 
session_start();
$title = "Login";
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
                                        <form class="form-horizontal form-simple" method="post" action="index">
                                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                                <?php 
                            						//$user->register("admin", "afitadmin@22", "afitadmin@22", "", 1, SUPER_ADMIN_USER_KEY, "Admin", "");
                            						include('utility/logincode.php')
                            				    ?>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                                <input type="text" class="form-control" name="username" placeholder="Your Email" required/>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>
                                            <div style="height: 20px"></div>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control" name="password" placeholder="Enter Password" required/>
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-sm-6 col-12 text-center text-sm-left">
                                                    <fieldset>
                                                        <input type="checkbox" id="remember-me" class="chk-remember">
                                                        <label for="remember-me"> Remember Me</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-sm-6 col-12 text-center text-sm-right"><a href="forgot-password" class="card-link">Forgot Password?</a></div>
                                            </div>
                                            <input type="hidden" name="login" value="login"/>
                                            <button type="submit" class="btn btn-info btn-block"><i class="ft-unlock"></i> Login</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="">
                                        <p class="float-xl-left text-center m-0"><a href="forgot-password" class="card-link">Recover password</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

           <?php include('footer.php');?>