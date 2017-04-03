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
        
        /** ========================================
        *   Initialize
        *   ======================================== */
        
        var socket = io.connect("<?php echo base_url_port(); ?>");
        var subject = "<?= $subject; ?>";
        var order = "<?= MESSAGE_SHOW_CHRONO; ?>";
        var role = parseInt("<?= $this->session->userdata('user_type'); ?>");
        
        const user = "<?= $this->session->userdata('user_id'); ?>";
        const USER_ROLE_INSTRUCTOR = "<?= USER_TYPE_INSTRUCTOR; ?>";
        const USER_ROLE_STUDENT = "<?= USER_TYPE_STUDENT; ?>";
        
        if (window.hasOwnProperty('webkitSpeechRecognition')) {
            var recognition = new webkitSpeechRecognition();
        }
        
        
        
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
            load();
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
        *   speech recognition
        *   ======================================== */
        
        function startDictation() {

            if (window.hasOwnProperty('webkitSpeechRecognition')) {

                var final = '';
                
                //  CUSTOM: buttons to control dictation
                $('#respond-voice-start').addClass('hidden');
                $('#respond-voice-stop').removeClass('hidden');
                
                recognition.continuous = true;
                recognition.interimResults = true;

                recognition.lang = "en-US";
                recognition.start();
                
                recognition.onresult = function(e) {
                    var interim = '';
                    
                    if (typeof(event.results) == 'undefined') {
                        recognition.onend = null;
                        recognition.stop();
                        upgrade();
                        return;
                    }
                    
                    for (var i = e.resultIndex; i < e.results.length; ++i) {
                        
                        var show = $('#respond-body').val();
                        var hide = $('#respond-body').val();
                        
                        if (e.results[i].isFinal) {
                            final += e.results[i][0].transcript;
                            show = final;
                            hide = final;
                        } else {
                            interim += e.results[i][0].transcript;
                            if (i%4 == 0) show += interim;
                            hide += interim;
                        }
                        
                        console.log(hide);
                        
                        $('#respond-textarea').val(show);
                        $('#respond-body').val(hide);
                    }
                }

                recognition.onerror = function(e) {
                    recognition.stop();
                }

            }
        }
        
        function stopDictation() {
            recognition.stop();
            $('#respond-voice-stop').addClass('hidden');
            $('#respond-voice-start').removeClass('hidden');
        }
        
        
        
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
        
        //  thread respond
        socket.on('respond', function(data) {
            // TODO: on respond, add button to view respond
        });
        
        //  delegate respond
        socket.on('delegate respond', function(data) {
            if (parseInt(data['user']) == user)
                promptRespond(data);
            else
                return false;
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
        
        //  update vote
        socket.on('hand', function(data) {
            
            // extract json
            var vote = JSON.parse(data);
            var m = parseInt(vote['m']);
            var v = parseInt(vote['v']);
            
            // get DOM element
            var control = 'hand-count[' + m + ']';
            var count = parseInt(document.getElementById(control).innerHTML);
            
            // set counter
            document.getElementById(control).innerHTML = count + v;
            
        });
        
        //  poll happening
        socket.on('poll start', function(data) {
            promptPoll(data);
        });
        
        //  poll vote update
        socket.on('poll vote', function(data) {
            updatePoll(data);
        });
        
        //  system message
        socket.on('system broadcasting', function(data) {
            $('#forum-list-view').append($('<div class="thread-message" id="main-chat-view-msg">').html(data));
        });
        
        
        
        /** ========================================
        *   Change Message Display Order
        *   ======================================== */
        
        //  clear message <form>
        $('.forum-panel-order-control').click(function(){
            
            // set global variable
            order = $(this).attr('value');
            
            // load messages again
            load();
            
            $(':focus').blur();
            return false;
            
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
            $(':focus').blur();
            return false;
        });
        
        
        
        /** ========================================
        *   Message Raise Hand
        *   ======================================== */
        
        //  submit vote
        $("#forum-list-view").on("submit", ".forum-thread-hand-form", function() {
            submitHand2($(this));
            $(':focus').blur();
            return false;
        });
        
        
        
        /** ========================================
        *   Message Expand
        *   ======================================== */
        
        //  start respond on modal start
        $("#forum-list-view").on("click", ".forum-message", function(e) {
            
            // if click on VOTE button
            if ($(e.target).is('.forum-social-control')
              || $(e.target).is('.forum-social-control-fade')
              || $(e.target).is('.forum-social-content')) {
                return;     // do nothing
            }
            
            // if user is student
            if (role == USER_ROLE_STUDENT) {
                setThreadModal($(this).attr('value'));
                $('#thread-full').modal('toggle');
                return false;
            }
            
            // if user is instructor
            if (role == USER_ROLE_INSTRUCTOR) {
                
                // set modal
                setRespondModal(this);
                setSocialModal($(this).attr('value'));
                
                // open modal
                $('#thread-respond').modal('toggle');
                startDictation();
                
                // return
                return false;
                
            }
            
        });
        
        //  show hands up list
        $('#thread-question-hand').on("click", function(e) {
            stopDictation();
            $('#thread-social').modal('toggle');
        });
        
        //  select students to answer
        $("#thread-social").on("submit", ".social-item-select-form", function(e) {
            e.preventDefault();
            selectRespond($(this));
            $(':focus').blur();
            return false;
        });
        
        //  start recording btn
        $('#respond-voice-start').on("click", function(e) {
            startDictation();
        })
        
        //  stop recording btn
        $('#respond-voice-stop').on("click", function(e) {
            stopDictation();
        })
        
        //  end respond on modal close
        $('#thread-respond').on("hidden.bs.modal", function(e) {
            
            // stop speech recognition
            stopDictation();
            
            // if click on SUBMIT button
            if($(e.target).is('#respond-submit')){
                
                // get response
                var re = $('#respond-body').val();

                // submit if length > 0
                if (re.length > 0)
                    submitRespond();
                
            } else {
                return false;
            }
            
            return false;
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
        
        //  load
        function load() {
            
            var loadURL = "<?php echo site_url("Chat/load"); ?>";
            loadURL += "/" + subject;
            loadURL += "/" + order;
            
            $.ajax({
                type: "GET",
                url: loadURL,
                
                success: function(data) {
                    // $('#forum-list-view').append($('<div class="thread-message" id="main-chat-view-msg">').html(data));
                    console.log("loading from " + loadURL);
                    $('#forum-list-view').html(data);
                    $("#forum-list-view").animate({scrollTop: 0}, 10);
                    $("#forum-list-view").animate({scrollTop: $('#forum-list-view').prop("scrollHeight")}, 1000);
                }
            });
            
        }
        
        
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
                input.hasClass("forum-social-control-fade") ? 1 : -1 
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
                    if (field.val() == 1) {
                        input.removeClass("forum-social-control-fade");
                        input.addClass("forum-social-control");
                    } else {
                        input.removeClass("forum-social-control");
                        input.addClass("forum-social-control-fade");
                    }
                }
            });
            
        }
        
        
        //  submit vote
        function submitHand2(form) {
            
            /* get input */
            var field = form.children(".forum-thread-hand-value");
            var input = form.children(".forum-thread-hand-input");
            
            // set VALUE field
            // if found "+", set to +1, else to -1
            field.val( 
                input.hasClass("forum-social-control-fade") ? 1 : -1 
            );
            
            // (1) to database
            $.ajax({
                type: "POST",
                url: "<?php echo site_url("Chat/hand"); ?>",
                data: $(form).serialize(),

                success: function(data) {
                    // (2) to socket server
                    socket.emit('hand', data);
                    
                    // set vote button
                    if (field.val() == 1) {
                        input.removeClass("forum-social-control-fade");
                        input.addClass("forum-social-control");
                    } else {
                        input.removeClass("forum-social-control");
                        input.addClass("forum-social-control-fade");
                    }
                }
            });
            
        }
        
        
        //  set thread full modal
        function setThreadModal(m) {
            
            // set url
            var dest = "<?php echo site_url("Chat/thread"); ?>" + "/" + m;
            
            // (1) to database
            $.ajax({
                type: "GET",
                url: dest,

                success: function(data) {
                    $('#thread-full-view').html(data);
                }
            });
            
        }
        
        
        //  set respond modal
        function setRespondModal(control) {
            
            // clear previous message data
            $('#thread-question-head').html('');
            $('#thread-question-body').html('');
            $('#respond-body').val('');
            $('#respond-textarea').val('');
            $('#respond-voice-start').addClass('hidden');
            $('#respond-voice-stop').removeClass('hidden');


            // set text
            $('#thread-question-head').append(
                $('<h2/>').text($(control).find('.forum-thread-head').text())
            );
            $('#thread-question-body').append(
                $('<p/>').text($(control).find('.forum-thread-body').text())
            );
            $('#respond-modal-vote-count').text(
                $(control).find('.forum-thread-vote-count').text()
            );
            $('#respond-modal-hand-count').text(
                $(control).find('.forum-thread-hand-count').text()
            );
            $('#respond-id').val($(control).attr('value'));
            
        }
        
        
        //  get list of students raise their hands
        function setSocialModal(m) {
            
            // set url
            var dest = "<?php echo site_url("Chat/get_hands"); ?>" + "/" + m;
            
            // (1) to database
            $.ajax({
                type: "GET",
                url: dest,

                success: function(data) {
                    $('#thread-social-list').html(data);
                }
            });
            
        }
        
        
        //  select students to respond
        function selectRespond(form) {
            
            // get data
            var message = form.children('.social-item-select-message').val();
            var user = form.children('.social-item-select-user').val();
            
            // emit to socket
            var out = {"room": subject, "user": user, "message": message};
            socket.emit('delegate respond', out);
            
        }
        
        
        //  prompt modal to allow student respond to question
        function promptRespond(data) {
            
            // get message data
            var container = 
                document.getElementById('forum-message-view[' + data['message'] + ']');
            
            // set modal
            setRespondModal(container);
            setSocialModal($(container).attr('value'));
            
            // open modal
            $('#thread-respond').modal('toggle');
            startDictation();
            
            // return
            return false;
            
        }
        
        
        //  submit thread
        function submitRespond() {
            
            console.log("submit");
            
            $.ajax({
                type: "POST",
                url: "<?php echo site_url("Chat/respond"); ?>",
                data: $('#respond-form').serialize(),

                success: function(data) {
                    // (2) to socket server
                    // var out = {"room": subject, "html": data};
                    console.log(data);
                    
                    // TODO: on respond, add button to view respond
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
            
            $('#poll-vote').modal('hide');
            
            // (1) to database
            $.ajax({
                type: "POST",
                url: "<?php echo site_url("Chat/poll_vote"); ?>",
                data: {"opt": opt},

                success: function(data) {
                    // (2) to socket server
                    var d = $.parseJSON(data);
                    if (d.message=="Already Vote") { return false; }
                    
                    var out = {"room": subject, "data": d.opt};
                    socket.emit('poll vote', out);
                    
                    reviewPoll(data);
                }
            });
            
            return false;
            
        }
        
        
        //  update poll result
        function updatePoll(d) {
            console.log("update");
            console.log(d);
            
            d.forEach(function(row) {
                
                /**
                 *  NOTES:
                 *  for some reason jQuery not working here
                 *  *** use document.getElementbyId ***
                 */
                var c = 'poll-result-opt[' + row.opt_id + ']';
                var ct = document.getElementById(c);
                ct.innerHTML = row.opt_txt + "  Vote: " + row.vote;
                
            });
        }
        
        
        //  poll result
        function reviewPoll(d) {
            
            var id = parseInt(d) || -1;
            
            if (id != -1) {
                // TODO: ajax to get poll data
                console.log("no poll data yet");
                
                /*
                // TODO: retrieve from database
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url("Chat/poll_result"); ?>",
                    data: {"id": id},

                    success: function(data) {
                        // TODO: set interface
                    }
                });
                */
                
            } else {
                console.log("contains data");
            }
            
            var data = $.parseJSON(d);
            var poll = data.poll;
            var opt = data.opt;
            var count = 1;
            
            $('#poll-result-id').html('');
            $('#poll-result-body').html('');
            $('#poll-result-count').html('');
            
            // set text on screen
            $('#poll-result-body').append($('<h2/>').text(poll.m_body));
            
            opt.forEach(function(row) {
                count++;
                var b = $('<p/>', {
                            class: "poll-result-opt",
                            id: "poll-result-opt[" + row.opt_id + "]"
                        });
                b.text(row.opt_txt + "  Vote: " + row.vote);
                $("#poll-result-count").append(b);
            });
            
            // open modal
            $('#poll-result').modal('toggle');
            
        }
        
        
    </script>

</body>

</html>