<!-- Start of Modal -->
<div class="modal poll-modal col-xs-12 col-sm-12 col-md-12 col-lg-12 fade " id="poll-input" role="dialog" >
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
                <input class="form-control" type="hidden" name="input-message-class" id="input-message-class" value="<?php echo $subject; ?>" autocomplete="off"></input>
                <!-- lect id -->
                <input class="form-control" type="hidden" name="input-message-lect" id="input-message-lect" value="<?php /* TODO: lect id here */ ?>" autocomplete="off"></input>


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