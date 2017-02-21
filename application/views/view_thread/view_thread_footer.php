        </div>
        <!-- /#container-fluid -->
    </div>
    <!-- /#page-content-wrapper -->


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

    <!-- socket.io -->
    <script src="<?php echo base_url_port(); ?>socket.io/socket.io.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
    <script>
        
        var socket = io.connect("<?php echo base_url_port(); ?>");
        var subject = "<?= $subject; ?>";
        var thread = "<?= $thread; ?>";
        
        
        
        /** ========================================
        *   onload
        *   ======================================== */
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url("Thread/load/".$thread); ?>",
                // data: $('#messages-input').serialize(),

                success: function(data) {
                    $('#main-chat-view').append(data);
                    // $('#main-chat-view').append($('<div class="thread-message" id="main-chat-view-msg">').html(data));
                }
            });
        });
        
        
        
        /** ========================================
        *   sidebar
        *   ======================================== */
        
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
        $("#menu-toggle-2").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
        
        
        
        
        
    </script>

</body>

</html>