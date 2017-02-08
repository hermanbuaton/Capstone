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
        var socket = io.connect("http://127.0.0.1:3000/");
        var subject = "<?= $subject; ?>";

        socket.on('connect', function() {
            // Connected, let's sign-up for to receive messages for this room
            socket.emit('room', subject);
        });

        socket.on('chat message', function(data) {
            $('#main-chat-view').append($('<div class="thread-message" id="main-chat-view-msg">').text(data));
        });
        
        $("#chat-message-body").keydown(function(e) {
            e = e || event;
            if (e.keyCode === 13) {
                if (!e.shiftKey && !e.ctrlKey) {
                    e.preventDefault();
                    submitInput2();
                }
            }
        });
        
        $('#messages-input').submit(function(){
            submitInput2();
            return false;
        });

        $('#main-chat-cancel-btn').click(function(){
            cancelInput();
            return false;
        });
        
        function submitInput() {
            
            // validate head
            var hv = $('#chat-message-head').val();
            var ht = hv.trim();
            // validate body
            var bv = $('#chat-message-body').val();
            var bt = bv.trim();
            
            // if ALL fields have content
            if (ht.length > 0 && bt.length > 0)
            {
                // send to:
                // 1. socket server
                // 2. database
                
                // to socket server
                // only HEAD part, i.e. the question
                socket.emit('thread', {
                                        room: subject,
                                        data: $('#messages-input')
                                      }
                           );
                
                // to database
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url("Chat/message"); ?>",
                    data: $('#messages-input').serialize(),
                    
                    success: function(data) {
                        // do something
                        console.log(data);
                    }
                });
            } 
            // if ONLY EITHER ONE field have content
            else if (ht.length > 0 || bt.length > 0)
            {
                // return before content clear
                return false;
            }
            
            cancelInput();
            return false;
            
        }
        
        function submitInput2() {
            
            // validate head
            var hv = $('#chat-message-head').val();
            var ht = hv.trim();
            // validate body
            var bv = $('#chat-message-body').val();
            var bt = bv.trim();
            
            // if ALL fields have content
            if (ht.length > 0 && bt.length > 0)
            {
                // send to:
                // 1. socket server
                // 2. database
                
                // to socket server
                // only HEAD part, i.e. the question
                socket.emit('chat message', hv);
                
                // to database
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url("Chat/message"); ?>",
                    data: $('#messages-input').serialize(),
                    
                    success: function(data) {
                        // do something
                        console.log(data);
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
        
        function cancelInput() {
            $('#chat-message-head').val().replace(/\n/g, '');
            $('#chat-message-head').val('');
            $('#chat-message-body').val().replace(/\n/g, '');
            $('#chat-message-body').val('');
            return false;
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