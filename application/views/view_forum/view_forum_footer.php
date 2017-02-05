    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?php echo base_url();?>js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url();?>js/plugins/morris/raphael.min.js"></script>
    <script src="<?php echo base_url();?>js/plugins/morris/morris.min.js"></script>
    <script src="<?php echo base_url();?>js/plugins/morris/morris-data.js"></script>

    <!-- socket.io -->
    <script src="<?php echo base_url_port(); ?>socket.io/socket.io.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
    <script>
        var socket = io.connect("http://127.0.0.1:3000/");
        var subject = "<?php echo $subject; ?>";

        socket.on('connect', function() {
            // Connected, let's sign-up for to receive messages for this room
            socket.emit('room', subject);
        });

        socket.on('chat message', function(data) {
            $('#main-chat-view').append($('<div class="thread-message" id="main-chat-view-msg">').text(data));
        });

        $('#messages-input').submit(function(){
            socket.emit('chat message', $('#main-chat-input-area').val());
            $('#main-chat-input-area').val('');
            return false;
        });

        /*
        var socket = io.connect("<?php echo base_url_port(); ?>");
        var subject = "<?php echo $subject; ?>";

        $('form').submit(function(){
            socket.emit('chat message', $('#m').val());
            $('#m').val('');
            return false;
        });

        socket.on('chat message', function(msg){
            $('#messages').append($('<li>').text(msg));
        })
        */
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
    $("#main-chat-input-area").keyup(function(e) {
        e = e || event;
        if (e.keyCode === 13) {
            $("#messages-input").submit();
        }
    });
    </script>

</body>

</html>