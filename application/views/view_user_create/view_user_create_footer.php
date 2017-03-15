    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url(); ?>js/plugins/morris/raphael.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/morris/morris.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/morris/morris-data.js"></script>

    <!-- Menu Toggle Script -->
    <script>
        
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
        
        $("#menu-toggle-2").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
        
        $("#login-form").keydown(function(e) {
            e = e || event;
            if (e.keyCode === 13) {
                $("#login-form").submit();
            }
        });
        
        $("#tab-student").click(function(e) {
            e.preventDefault();
            
            $("#home-login-teacher").addClass("hidden");
            $("#tab-teacher").removeClass("active");
            
            $("#home-login-student").removeClass("hidden");
            $("#tab-student").addClass("active");
            
            return false;
        });
        
        $("#tab-teacher").click(function(e) {
            e.preventDefault();
            
            $("#home-login-student").addClass("hidden");
            $("#tab-student").removeClass("active");
            
            $("#home-login-teacher").removeClass("hidden");
            $("#tab-teacher").addClass("active");
            
            return false;
        });
        
    </script>

</body>

</html>