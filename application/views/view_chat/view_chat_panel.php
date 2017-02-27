<!-- Start of Panel -->
<div class="panel panel-default forum-panel col-xs-12 col-sm-5 col-md-4 col-lg-4 pull-right" id="forum-panel-view">
    
    <!-- ============================================================================ -->
    <!-- Panel Heading -->
    <!-- ============================================================================ -->
    <div class="panel-heading">
        <h3 class="panel-title">Question Bank</h3>
        
        <div class="pull-right">
            <button type="button" class="btn btn-info btn-lg" id="poll-create-toggle" data-toggle="modal" data-target="#poll-input">Start a Poll</button>
        </div>
    </div>

    <!-- ============================================================================ -->
    <!-- Panel Body -->
    <!-- ============================================================================ -->
    <div class="panel-body">

        <!-- Messages -->
        <div class="forum-list" id="forum-list-view">
            <!-- ** Messages here ** -->
            <!-- ** Change div CLASS & ID in view_chat_footer script ** -->
            <!-- ** Change layout in view_chat_message ** -->
        </div>

        <!-- Input area -->
        <form class="" id="forum-quick-input" action="">
            <div class="pull-bottom-left" id="forum-quick-input-data-view">

                <!-- Thread Head -->
                <textarea class="form-control" name="input-message-head" id="input-message-head" placeholder="Question" autocomplete="off" ></textarea>

                <!-- Thread Body -->
                <textarea class="form-control" name="input-message-body" id="input-message-body" placeholder="Furtherer Explanation" autocomplete="off" ></textarea>

                <!-- Other fields -->
                <!-- HIDDEN: AUTO COMPLETE BY JS / PHP -->
                <!-- class id -->
                <input class="form-control" type="hidden" name="input-message-class" id="input-message-class" value="<?php echo $subject; ?>" autocomplete="off"></input>
                <!-- lect id -->
                <input class="form-control" type="hidden" name="input-message-lect" id="input-message-lect" value="<?php /* TODO: lect id here */ ?>" autocomplete="off"></input>

            </div>

            <div class="pull-bottom-right" id="forum-quick-input-control-view">
                <button class="btn btn-primary forum-quick-input-control" id="forum-quick-input-submit">
                    Send
                </button>
                <button class="btn btn-danger forum-quick-input-control" id="forum-quick-input-cancel">
                    Cancel
                </button>
            </div>

            </div>
        </form>

    </div>

</div>
<!-- End of Panel -->