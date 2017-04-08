<!-- Start of Modal -->
<div class="modal fade poll-modal col-xs-12 col-sm-12 col-md-12 col-lg-12 " id="poll-input" config="{backdrop: false, keyboard: false}" tabindex="-1" role="dialog" >
    <div class="modal-dialog">

    <!-- Modal content START -->
    <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" id="poll-create-close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Start a Poll</h4>
        </div>

        <div class="modal-body">
            <form id="poll-create">

                <!-- Thread Head -->
                <!--
                <textarea class="form-control" name="input-message-head" id="input-message-head" placeholder="Question" autocomplete="off" ></textarea>
                -->

                <!-- Thread Body -->
                <textarea class="form-control" name="input-message-body" id="input-message-body" placeholder="Poll Question" autocomplete="off" ></textarea>
                <br/>
                
                
                <div>
                    <!-- Poll Option -->
                    <!-- (1) -->
                    <input class="form-control input-poll-opt" type="text" name="input-poll-opt[]" id="input-poll-opt-1" placeholder="Option #1" autocomplete="off"></input>
                    <!-- (2) -->
                    <input class="form-control input-poll-opt" type="text" name="input-poll-opt[]" id="input-poll-opt-2" placeholder="Option #2" autocomplete="off"></input>
                    <!-- (3) -->
                    <input class="form-control input-poll-opt" type="text" name="input-poll-opt[]" id="input-poll-opt-3" placeholder="Option #3" autocomplete="off"></input>
                    <!-- (4) -->
                    <input class="form-control input-poll-opt" type="text" name="input-poll-opt[]" id="input-poll-opt-4" placeholder="Option #4" autocomplete="off"></input>
                </div>
                
                
                <!-- Other fields -->
                <!-- HIDDEN: AUTO COMPLETE BY JS / PHP -->
                <!-- class id -->
                <input class="form-control" type="hidden" name="input-message-class" id="input-message-class" value="<?= /* TODO: NEED REVIEW: Class ID here. */ $subject; ?>" autocomplete="off"></input>
                <!-- lect id -->
                <input class="form-control" type="hidden" name="input-message-lect" id="input-message-lect" value="<?= $subject; ?>" autocomplete="off"></input>
                
                <!-- Start Time -->
                <div style="height: 50px; padding-top: 15px; padding-bottom: 15px;">
                    <!-- Anonymous -->
                    <label class="col-xs-4 col-sm-3 col-md-2 col-lg-2" style="padding-left: 5px;">
                        <!-- Start NOW -->
                        <input type="radio" class="form-check-input" name="input-poll-type" id="input-poll-start" value="<?= MESSAGE_TYPE_POLL_START; ?>" autocomplete="off" checked></input>
                        <span>
                            Start Now
                        </span>
                    </label>
                    <!-- Anonymous -->
                    <label class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <!-- Start NOW -->
                        <input type="radio" class="form-check-input" name="input-poll-type" id="input-poll-save" value="<?= MESSAGE_TYPE_POLL_SAVE; ?>" autocomplete="off"></input>
                        <span>
                            Save &amp; Start Later
                        </span>
                    </label>
                </div>
                <br/>
                
                
                <div>
                    <button class="btn btn-primary forum-quick-input-control" id="poll-create-submit">
                        Create
                    </button>
                    <button class="btn btn-danger forum-quick-input-control" id="poll-create-cancel">
                        Cancel
                    </button>
                </div>

            </form>
        </div>

        <!--
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        -->

    </div>
    <!-- Modal content END -->
        
    </div>
</div>
<!-- End of Modal -->