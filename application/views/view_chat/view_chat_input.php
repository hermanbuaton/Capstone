<!-- Start of Modal -->
<div class="modal input-modal col-xs-12 col-sm-12 col-md-12 col-lg-12 fade " id="input-full" config="{backdrop: false, keyboard: false}" tabindex="-1" role="dialog" >
    <div class="modal-dialog">

    <!-- Modal content START -->
    <div class="modal-content">
        
        <div class="modal-header">
            <button type="button" class="close" id="thread-respond-close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Question</h4>
        </div>
        

        <!-- Input area -->
        <form class="" id="forum-quick-input" action="">
        <div class="modal-body">
            
            <div id="input-full-view">
                
                <!-- Input area -->
                <div class="" id="input-modal-data-view">

                    <!-- Thread Head -->
                    <textarea class="form-control" name="input-message-head" id="input-message-head" placeholder="Question" autocomplete="off" ></textarea>

                    <!-- Thread Body -->
                    <textarea class="form-control" name="input-message-body" id="input-message-body" placeholder="Furtherer Explanation" autocomplete="off" ></textarea>

                    <!-- Other fields -->
                    <!-- HIDDEN: AUTO COMPLETE BY JS / PHP -->
                    <!-- class id -->
                    <input class="form-control" type="hidden" name="input-message-class" id="input-message-class" value="<?= /* TODO: NEED REVIEW: Class ID here. */ $subject; ?>" autocomplete="off"></input>
                    <!-- lect id -->
                    <input class="form-control" type="hidden" name="input-message-lect" id="input-message-lect" value="<?= $subject; ?>" autocomplete="off"></input>

                </div>
                
            </div>
            
        </div>
        
        
        <div class="modal-footer">
            
            <div class="pull-left" id="input-modal-control-view">
                <!-- Anonymous -->
                <label>
                    <!-- Checkbox -->
                    <input type="checkbox" class="form-check-input" name="input-anonymous" id="input-anonymous" value="" autocomplete="off"></input>
                    <!-- Hidden: set using jQuery -->
                    <input class="form-control" type="hidden" name="input-message-anonymous" id="input-message-anonymous" value="" autocomplete="off"></input>
                    <span>
                        Ask as anonymous
                    </span>
                </label>
            </div>


            <div class="pull-right" id="input-modal-control-view">
                <button type="submit" class="btn btn-primary forum-quick-input-control" id="forum-quick-input-submit">
                    Send
                </button>
                <button type="reset" class="btn btn-danger forum-quick-input-control" id="forum-quick-input-cancel">
                    Reset
                </button>
            </div>
            
        </div>
        </form>
        
    </div>
    <!-- Modal content END -->
        
    </div>
</div>
<!-- End of Modal -->