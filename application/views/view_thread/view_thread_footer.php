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
                url: "<?php echo site_url("Chat/load/".$thread); ?>",
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
            var m_str = "/" + m_id;
            
            $.ajax({
                type: "GET",
                // TODO: put message id into URL
                url: "<?php echo site_url("Thread/load/"); ?>" + m_str,
                // data: $('#messages-input').serialize(),

                success: function(data) {
                    
                    // set content
                    $('#thread-content').html(data);
                    $('#input-message-id').val(m_id);
                    
                    // interface: make div scrollable & hide forum-panel
                    $("#main-ui").removeClass("main-ui");
                    $("#main-ui").addClass("main-ui-scrollable");
                    $("#forum-panel-view").addClass("hidden-xs");
                    $("#thread-main").removeClass("hidden-xs");
                }
            });
        });
        
        
        
        /** ========================================
        *   Message Submit
        *   ======================================== */
        
        //  press enter to submit message
        $("#input-message-body").keydown(function(e) {
            e = e || event;
            if (e.keyCode === 13) {
                if (!e.shiftKey && !e.ctrlKey) {
                    e.preventDefault();
                    $('#thread-quick-reply').submit();
                }
            }
        });
        
        //  submit message
        $('#thread-quick-reply').submit(function(){
            submitInput2();
            return false;
        });

        //  clear message <form>
        $('#thread-quick-reply-cancel').click(function(){
            cancelInput();
            return false;
        });
        
        
        
        /** ========================================
        *   Real Work
        *   ======================================== */
        
        //  submit message
        function submitInput2() {
            
            // for m_body validation
            var bv = $('#input-message-body').val();
            var bt = bv.trim();
            
            // if ALL fields have content
            if (bt.length > 0)
            {
                // (1) to database
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url("Thread/message"); ?>",
                    data: $('#thread-quick-reply').serialize(),
                    
                    success: function(data) {
                        // do nothing
                        console.log(data);
                    }
                });
                
            }
            
            cancelInput();
            return false;
            
        }
        
        
        //  clear message <form>
        function cancelInput() {
            $('#input-message-body').val().replace(/\n/g, '');
            $('#input-message-body').val('');
            
            return false;
        }
        
        
        
    </script>

</body>

</html>