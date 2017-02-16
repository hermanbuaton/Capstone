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
        
        
        
        /** ========================================
        *   socket
        *   ======================================== */
        
        //  connect to session
        socket.on('connect', function() {
            // Connected, let's sign-up for to receive messages for this room
            socket.emit('room', subject);
        });
        
        //  receive message
        socket.on('chat message', function(data) {
            $('#main-chat-view').append($('<div class="thread-message" id="main-chat-view-msg">').html(data));
        });
        
        //  update vote
        socket.on('chat message', function(data) {
            // TODO
        });
        
        
        
        /** ========================================
        *   Message Submit
        *   ======================================== */
        
        //  press enter to submit message
        $("#chat-message-body").keydown(function(e) {
            e = e || event;
            if (e.keyCode === 13) {
                if (!e.shiftKey && !e.ctrlKey) {
                    e.preventDefault();
                    $('#messages-input').submit();
                }
            }
        });
        
        //  submit message
        $('#messages-input').submit(function(){
            submitInput2();
            return false;
        });

        //  clear message <form>
        $('#main-chat-cancel-btn').click(function(){
            cancelInput();
            return false;
        });
        
        
        
        /** ========================================
        *   Message Vote
        *   ======================================== */
        
        //  submit vote
        $("#main-chat-view").on("submit", ".thread-message-vote-form", function() {
            submitVote2($(this));
            return false;
        });
        
        
        
        /** ========================================
        *   Real Work
        *   ======================================== */
        
        //  submit message
        function submitInput2() {
            
            // for m_head validation
            var hv = $('#chat-message-head').val();
            var ht = hv.trim();
            // for m_body validation
            var bv = $('#chat-message-body').val();
            var bt = bv.trim();
            
            // if ALL fields have content
            if (ht.length > 0 && bt.length > 0)
            {
                // (1) to database
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url("Chat/message"); ?>",
                    data: $('#messages-input').serialize(),
                    
                    success: function(data) {
                        // (2) to socket server
                        socket.emit('chat message', data);
                    }
                });
                
            } 
            // if ONLY EITHER ONE field have content
            else if (ht.length > 0 || bt.length > 0)
            {
                // do something
                return false;
            }
            
            cancelInput();
            return false;
            
        }
        
        
        //  clear message <form>
        function cancelInput() {
            $('#chat-message-head').val().replace(/\n/g, '');
            $('#chat-message-head').val('');
            $('#chat-message-body').val().replace(/\n/g, '');
            $('#chat-message-body').val('');
            return false;
        }
        
        
        //  submit vote
        function submitVote2(form) {
            
            console.log(form.attr('id'));
            
            /* get input */
            var input = form.children(".thread-message-vote-btn");
            var field = form.children(".thread-message-vote-val");
            
            /* get counter */
            var counter = form.children(".thread-message-vote-count");
            var count = parseInt(counter.text());
            
            // set VALUE field
            // if found "+", set to +1, else to -1
            field.val( 
                input.text().indexOf("+") >= 0 ? 1 : -1 
            );
            
            // (1) to database
            $.ajax({
                type: "POST",
                url: "<?php echo site_url("Chat/vote"); ?>",
                data: $(form).serialize(),

                success: function(data) {
                    // (2) to socket server
                    socket.emit('vote', data);
                }
            });
            
            // set vote button & vote counter
            input.text(
                (field.val() == 1) ? "-" : "+" 
            );
            counter.text( 
                (field.val() == 1) ? (count+1) : (count-1) 
            );
        }
        
    </script>

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
    </script>

</body>

</html>