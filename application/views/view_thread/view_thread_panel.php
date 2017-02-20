<!-- Start of Panel -->
<div class="panel panel-default chat-panel col-xs-12 col-sm-5 col-md-4 col-lg-4 pull-right" id="main-chat">

    <!-- ============================================================================ -->
    <!-- Panel Heading -->
    <!-- ============================================================================ -->
    <div class="panel-heading">
        <h3 class="panel-title">Question Bank</h3>
    </div>

    <!-- ============================================================================ -->
    <!-- Panel Body -->
    <!-- ============================================================================ -->
    <div class="panel-body">

        <!-- Messages -->
        <form id="messages-vote" action="">
            <div class="thread-view" id="main-chat-view">
                <!-- ** Messages here ** -->
                <!-- ** Change div CLASS & ID in view_chat_footer script ** -->
                <!-- ** Change layout in view_chat_message ** -->
            </div>
        </form>

        <!-- Input area -->
        <form id="messages-input" action="">
            <div class="pull-bottom-left" id="main-chat-input">

                <!-- Thread Head -->
                <textarea class="form-control" name="chat-message-head" id="chat-message-head" placeholder="Question" autocomplete="off" ></textarea>

                <!-- Thread Body -->
                <textarea class="form-control" name="chat-message-body" id="chat-message-body" placeholder="Furtherer Explanation" autocomplete="off" ></textarea>

                <!-- Other fields -->
                <!-- HIDDEN: AUTO COMPLETE BY JS / PHP -->
                <!-- class id -->
                <input class="form-control" type="hidden" name="chat-message-class" id="chat-message-class" value="<?php echo $subject; ?>" autocomplete="off"></input>
                <!-- lect id -->
                <input class="form-control" type="hidden" name="chat-message-lect" id="chat-message-lect" value="<?php /* TODO: lect id here */ ?>" autocomplete="off"></input>

            </div>

            <div class="pull-bottom-right main-chat-control">
                <button class="btn btn-primary main-chat-control-btn" id="main-chat-submit-btn">Send</button>
                <button class="btn btn-danger main-chat-control-btn" id="main-chat-cancel-btn">Cancel</button>
            </div>

            </div>
        </form>

    </div>

</div>
<!-- End of Panel -->