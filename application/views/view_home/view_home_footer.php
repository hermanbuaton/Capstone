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
        
        $(window).load(function() {
            var name = getCookie('username');
            $('#username').val(name);
        });
        
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
            studentLogin();
            return false;
        });
        
        $("#tab-teacher").click(function(e) {
            e.preventDefault();
            teacherLogin();
            return false;
        });
        
        $("#login-form").on("submit", function(e) {
            setCookie('username', $('#username').val(), 365, false);
            console.log("setcookie");
        });
        
        function studentLogin() {
            
            $("#home-login-teacher").addClass("hidden");
            $("#tab-teacher").removeClass("active");
            
            $("#home-login-student").removeClass("hidden");
            $("#tab-student").addClass("active");
            
        }
        
        function teacherLogin() {
            
            $("#home-login-student").addClass("hidden");
            $("#tab-student").removeClass("active");
            
            $("#home-login-teacher").removeClass("hidden");
            $("#tab-teacher").addClass("active");
            
        }
        
        function setCookie(name, value, expires_in_days, cross_domain) {
            cross_domain = typeof cross_domain !== 'undefined' ? true : false;
            var d = new Date();
            d.setTime(d.getTime() + (expires_in_days*24*60*60*1000));
            var expires = "expires="+d.toUTCString();
            var cookie_string = name + "=" + value + ";" +
                expires +
                (cross_domain === true ? ";domain=<?php echo $this->config->item('domain');?>" : "") +
                ";path=/" +
                (location.protocol === "https:" ? ";secure" : "") ;
            document.cookie = cookie_string;
        }
        
        function getCookie(name) {
            var ca = document.cookie;
            var start = ca.indexOf(" " + name + "=");

            if (start==-1) {
                start = ca.indexOf(name + "=");
            }

            if (start==-1) {
                ca = null;
            } else {
                start = ca.indexOf("=",start) + 1;
                var end = ca.indexOf(";",start);

                if (end==-1) end=ca.length;
                ca = decodeURI(ca.substring(start,end));
            }

            return ca;
        }
        
    </script>

</body>

</html>