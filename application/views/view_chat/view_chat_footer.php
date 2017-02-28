        </div>
        <!-- /#container-fluid -->
    </div>
    <!-- /#page-content-wrapper -->


    </div>
    <!-- /#wrapper -->
    
    

    <!-- socket.io -->
    <script src="<?php echo base_url_port(); ?>socket.io/socket.io.js"></script>
    
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <!--<script src="http://code.jquery.com/jquery-1.11.1.js"></script>-->
    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url(); ?>js/plugins/morris/raphael.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/morris/morris.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/morris/morris-data.js"></script>
    
    <script>
        
        var socket = io.connect("<?php echo base_url_port(); ?>");
        var subject = "<?= $subject; ?>";
        
        
        
        /** ========================================
        *   onload
        *   ======================================== */
        
        /** ========================================
        *   *** NOTES ***
        *
        *   Date:   27 Feb 2017
        *   Use $(window).load() instead of 
        *       $(document).ready() because it seems
        *       that jQuery only load in between
        *       the 2 function.
        *   
        *   $(window).load() is running after 
        *       $(document).ready()
        *
        *   REFERENCE: 
        *   http://stackoverflow.com/questions/3008696/
        *   ======================================== */
        
        $(window).load(function() {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url("Chat/load/".$subject); ?>",
                
                success: function(data) {
                    // $('#forum-list-view').append($('<div class="thread-message" id="main-chat-view-msg">').html(data));
                    $('#forum-list-view').append(data);
                    $("#forum-list-view").animate({ scrollTop: $('#forum-list-view').prop("scrollHeight")}, 1000);
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
        *   socket
        *   ======================================== */
        
        //  connect to session
        socket.on('connect', function() {
            // Connected, let's sign-up for to receive messages for this room
            socket.emit('room', subject);
        });
        
        //  receive message
        socket.on('thread', function(data) {
            $('#forum-list-view').append(data);
            $("#forum-list-view").animate({ scrollTop: $('#forum-list-view').prop("scrollHeight")}, 1000);
        });
        
        //  update vote
        socket.on('vote', function(data) {
            
            // extract json
            var vote = JSON.parse(data);
            var m = parseInt(vote['m']);
            var v = parseInt(vote['v']);
            
            // get DOM element
            var control = 'vote-count[' + m + ']';
            var count = parseInt(document.getElementById(control).innerHTML);
            
            // set counter
            document.getElementById(control).innerHTML = count + v;
            
        });
        
        //  poll happening
        socket.on('poll start', function(data) {
            promptPoll(data);
        });
        
        //  poll vote
        socket.on('poll vote', function(data) {
            // TODO: update poll result
        });
        
        //  system message
        socket.on('system broadcasting', function(data) {
            $('#forum-list-view').append($('<div class="thread-message" id="main-chat-view-msg">').html(data));
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
                    $('#forum-quick-input').submit();
                }
            }
        });
        
        //  submit message
        $('#forum-quick-input').submit(function(){
            submitInput2();
            return false;
        });

        //  clear message <form>
        $('#forum-quick-input-cancel').click(function(){
            cancelInput();
            return false;
        });
        
        
        
        /** ========================================
        *   Message Vote
        *   ======================================== */
        
        //  submit vote
        $("#forum-list-view").on("submit", ".forum-thread-vote-form", function() {
            submitVote2($(this));
            return false;
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
        });
        
        
        
        /** ========================================
        *   Poll Create
        *   ======================================== */
        
        //  submit message
        $('#poll-create').submit(function(){
            createPoll(this);
            return false;
        });

        //  clear <form>
        $('#poll-create-cancel').click(function(e){
            e.preventDefault();
            cancelPoll();
            return false;
        });
        
        
        
        /** ========================================
        *   Poll Vote
        *   ======================================== */
        
        //  submit vote
        $("#poll-vote-form").on("click", ".poll-vote-input", function() {
            console.log(this.value);
            respondPoll(this.value);
            return false;
        });
        
        
        
        /** ========================================
        *   Real Work
        *   ======================================== */
        
        //  submit message
        function submitInput2() {
            
            // for m_head validation
            var hv = $('#input-message-head').val();
            var ht = hv.trim();
            // for m_body validation
            var bv = $('#input-message-body').val();
            var bt = bv.trim();
            
            // if ALL fields have content
            if (ht.length > 0 && bt.length > 0)
            {
                // (1) to database
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url("Chat/message"); ?>",
                    data: $('#forum-quick-input').serialize(),
                    
                    success: function(data) {
                        // (2) to socket server
                        var out = {"room": subject, "html": data};
                        socket.emit('thread', out);
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
            $('#input-message-head').val().replace(/\n/g, '');
            $('#input-message-head').val('');
            $('#input-message-body').val().replace(/\n/g, '');
            $('#input-message-body').val('');
            
            return false;
        }
        
        
        //  submit vote
        function submitVote2(form) {
            
            /* get input */
            var field = form.children(".forum-thread-vote-value");
            var input = form.children(".forum-thread-vote-input");
            
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
                    
                    // set vote button
                    input.text(
                        (field.val() == 1) ? "-" : "+" 
                    );
                }
            });
            
        }
        
        
        //  submit poll
        function createPoll(form) {
            
            /* get input */
            console.log($(form).serialize());
            
            // (1) to database
            $.ajax({
                type: "POST",
                url: "<?php echo site_url("Chat/poll_create"); ?>",
                data: $(form).serialize(),

                success: function(data) {
                    // (2) to socket server
                    var out = {"room": subject, "data": data};
                    socket.emit('poll start', out);
                }
            });
            
            cancelPoll();
            return false;
        }
        
        
        //  clear poll <form> & close modal
        function cancelPoll() {
            $('#poll-create').trigger('reset');
            $('#poll-input').modal('hide');
            
            return false;
        }
        
        
        //  prompt poll screen
        function promptPoll(d) {
            
            var data = $.parseJSON(d);
            var opt = data.opt;
            var count = 1;
            
            // clear previous poll data
            $('#poll-vote-body').html('');
            $('#poll-vote-opt').html('');
            
            // set text on screen
            $('#poll-vote-body').append($('<h2/>').text(data.body));
            
            opt.forEach(function(row) {
                count++;
                var b = $('<button/>', {
                            class: "form-control poll-vote-input",
                            id: "poll-vote-input[" + count + "]",
                            value: row.opt_id
                        });
                b.text(row.opt_txt);
                $("#poll-vote-opt").append(b);
            });
            
            // open modal
            $('#poll-vote').modal('toggle');
            
        }
        
        
        //  respond to poll
        function respondPoll(opt) {
            
            // (1) to database
            $.ajax({
                type: "POST",
                url: "<?php echo site_url("Chat/poll_vote"); ?>",
                data: {"opt": opt},

                success: function(data) {
                    // (2) to socket server
                    // var out = {"room": subject, "data": data};
                    // socket.emit('poll vote', data);
                    
                    console.log(data);
                }
            });
            
        }
        
        
    </script>

</body>

</html>