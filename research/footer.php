            </div>
       </div>
    </div>
    <!-- END: Content--> 
<div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light navbar-border navbar-shadow hideprint">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2019 <a class="text-bold-800 grey darken-2" href="#" target="_blank">AFIT</a></span><span id="scroll-top"></span></span></p>
    </footer>
    <!-- END: Footer-->

<!-- BEGIN: Page Vendor JS-->
    <script src="../app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <!-- END: Page Vendor JS-->
    
   <!-- BEGIN: Page Vendor JS-->
    <script src="../app-assets/vendors/js/charts/chart.min.js"></script>
    <!-- END: Page Vendor JS-->
    
    

    <!-- BEGIN: Theme JS-->
    <script src="../app-assets/js/core/app-menu.js"></script>
    <script src="../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../app-assets/js/scripts/charts/chartjs/pie-doughnut/pie.js"></script>
    <script src="../app-assets/js/scripts/charts/chartjs/pie-doughnut/pie-simple.js"></script>
    <script src="../app-assets/js/scripts/charts/chartjs/pie-doughnut/doughnut.js"></script>
    <script src="../app-assets/js/scripts/charts/chartjs/pie-doughnut/doughnut-simple.js"></script>
    <!-- END: Page JS-->
    
    <!-- Toastr -->
    <script src="../app-assets/js/toastr.min.js"></script>
    
    <!-- BEGIN: Page JS-->
    <script src="../app-assets/js/scripts/forms/select/form-select2.js"></script>
    
    <script type="text/javascript" src="../assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>

    
    
    <script>
    $(document).ready(function(){
        $('.form-control').change(function(){
            $('#msg').html('');
        });

        $(".select2").select2();
    });    
    </script>
    
    <!-- BEGIN: Page Vendor JS-->
    <script src="../app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
    <!-- END: Page Vendor JS-->

     <!-- BEGIN: Page Vendor JS-->
    <script src="../app-assets/vendors/js/extensions/toastr.min.js"></script>
    <!-- END: Page Vendor JS-->
    
    <!-- BEGIN: Page JS-->
    <script src="../app-assets/js/scripts/extensions/toastr.js"></script>
    <!-- END: Page JS-->
    
    <!-- BEGIN: Page JS-->
    <script src="../app-assets/js/scripts/pages/dashboard-crypto.js"></script>
    <!-- END: Page JS-->
    
    <!-- blueimp gallery -->
    <script src="../app-assets/js/blueimp/jquery.blueimp-gallery.min.js"></script>
    
    

    <script type="text/javascript">
        $(document).ready(function(){
            var _group = '<?php echo $group; ?>';
            var _menu = '<?php echo $menu; ?>';
            
            
            $('#' + _group).addClass('active');
            $('#' + _menu).addClass('active');
        });
</script>
    <script>
        function logout()
        {
        	$(document).ready(function(){
        		var datastring = {'id' : 1};
        		$.ajax({
        		            type: "POST",
        		            url: "../utility/logout.php",
        		            data: datastring,
        		            cache: false,
        		            success: function(data) {
        		                window.location.href="../index";
        		                //alert(data);
        		            },
        		            error: function(){
        		                  alert('error handling here');
        		            }
        		        });
        		
        	});
        }
    </script>
    
    
    
    <script>
    $(".datepicker").datepicker( {
        format: "dd-mm-yyyy"
    });
    </script>
    
   <script src="../js/project-charts.js"></script>
 
</body>
<!-- END: Body-->

</html>