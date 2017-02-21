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
                    $('#forum-list-view').append(data);
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
        
        
        
        /** ========================================
        *   Message Expand
        *   ======================================== */
        
        //  submit vote
        $("#forum-list-view").on("click", ".forum-message", function(e) {
            
            // if click on VOTE button
            if($(e.target).is('.forum-thread-vote-input')){
                // do nothing
                return;
            }
            
            var m_id = $(this).attr('value');
            console.log(m_id);
            
            $.ajax({
                type: "GET",
                // TODO: put message id into URL
                url: "<?php echo site_url("Thread/load/1234567"); ?>",
                // data: $('#messages-input').serialize(),

                success: function(data) {
                    
                    // set content
                    $('#thread-content').html(data);
                    
                    // interface: hide forum-panel
                    // TODO: make div scrollable
                    $("#forum-panel-view").addClass('hidden-xs');
                }
            });
        });
        
        
        
    </script>

</body>

</html>