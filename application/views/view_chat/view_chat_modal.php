<!-- Start of Modal -->
<div class="modal respond-modal col-xs-12 col-sm-12 col-md-12 col-lg-12 fade " id="thread-full" config="{backdrop: false, keyboard: false}" tabindex="-1" role="dialog" >
    <div class="modal-dialog">

    <!-- Modal content START -->
    <div class="modal-content">
        
        <div class="modal-header">
            <button type="button" class="close" id="thread-respond-close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Question</h4>
        </div>
        

        <div class="modal-body">
            
            <div id="thread-full-view">
                <!-- Display Thread Body by js -->
            </div>
            
            <!-- Title of Reply Form -->
            <div class="thread-reply-head" id="thread-reply-head-view">
                <div class="" id="">
                    <h5>Have your say</h5>
                </div>
            </div>
            <div>
            <!-- Input area -->
            <form class="" id="thread-quick-reply" action="">
                <div class="pull-left" id="thread-quick-reply-data-view">
                    
                    <!-- Thread Body -->
                    <textarea class="form-control thread-quick-reply-control" name="input-message-body" id="thread-quick-input-body" placeholder="Reply" autocomplete="off" ></textarea>
                    
                    <!-- Other fields -->
                    <!-- HIDDEN: AUTO COMPLETE BY JS / PHP -->
                    <!-- message id -->
                    <input class="form-control" type="hidden" name="input-message-id" id="thread-quick-input-id" value="" autocomplete="off"></input>

                </div>

                <div class="pull-right" id="forum-quick-input-control-view">
                    <button type="submit" class="btn btn-primary forum-quick-input-control" id="thread-quick-input-submit">
                        Send
                    </button>
                    <button type="reset" class="btn btn-danger forum-quick-input-control" id="thread-quick-input-cancel">
                        Cancel
                    </button>
                </div>
            </form>
            </div>
            
        </div>
        
        <!--
        <div class="modal-footer">
            <div id="thread-social-control">
            <div class="pull-right">    
                <button type="button" class="btn btn-danger" id="respond-cancel" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        -->
        
    </div>
    <!-- Modal content END -->
        
    </div>
</div>
<!-- End of Modal -->