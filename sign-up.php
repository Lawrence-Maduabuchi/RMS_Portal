<?php 
session_start();
$title = "Sign Up";
$menu = "login";
include('header.php');
?>
                <section class="flexbox-container" style="margin-bottom: 30px;">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-6 col-md-8 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <div class="p-1"><img src="app-assets/images/logo/logo.png" style="max-width: 200px" alt="branding logo"></div>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Create Account</span></h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form-horizontal form-simple" action="sign-up" method="post">
                                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                                <?php                             						
                            						include('include/insert.php')
                            				    ?>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left mb-1">
                                                <input type="text" class="form-control form-control-lg input-lg" name="firstname" placeholder="First Name">
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left mb-1">
                                                <input type="text" class="form-control form-control-lg input-lg" name="lastname" placeholder="Last Name">
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left mb-1">
                                                <input type="email" class="form-control form-control-lg input-lg" name="email" placeholder="Email" required>
                                                <div class="form-control-position">
                                                    <i class="ft-mail"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control form-control-lg input-lg" name="password" placeholder="Enter Password" required>
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control form-control-lg input-lg" name="repassword" placeholder="Re-enter Password" required>
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>
                                            </fieldset>
                                            <input type="hidden" name="insert" value="sign-up"/>
                                            <button type="submit" class="btn btn-info btn-lg btn-block"><i class="ft-unlock"></i> Register</button>
                                        </form>
                                    </div>
                                    <p class="text-center">Already have an account ? <a href="login" class="card-link">Login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

           <?php include('footer.php');?>