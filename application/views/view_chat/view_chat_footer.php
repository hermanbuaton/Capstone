            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

    <!-- socket.io -->
    <script src="<?php echo base_url_port(); ?>socket.io/socket.io.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
    <script>
        var socket = io.connect("http://127.0.0.1:3000/");
        var room = "<?php echo $room; ?>";

        socket.on('connect', function() {
            // Connected, let's sign-up for to receive messages for this room
            socket.emit('room', room);
            console.log(room);
        });

        socket.on('chat message', function(data) {
            $('#messages').append($('<li>').text(data));
        });

        $('form').submit(function(){
            socket.emit('chat message', $('#m').val());
            $('#m').val('');
            return false;
        });

        /*
        var socket = io.connect("<?php echo base_url_port(); ?>");
        var room = "<?php echo $room; ?>";

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

</body>

</html>
