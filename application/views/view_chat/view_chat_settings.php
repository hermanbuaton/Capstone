<!-- Start of Modal -->
<div class="modal settings-modal col-xs-12 col-sm-12 col-md-12 col-lg-12 fade " id="settings-show" config="{backdrop: false, keyboard: false}" tabindex="-1" role="dialog" >
    <div class="modal-dialog">

    <!-- Modal content START -->
    <div class="modal-content">
        
        <div class="modal-header">
            <button type="button" class="close" id="thread-respond-close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Settings</h4>
        </div>
        

        <div class="modal-body">
            
            <div id="settings-view">
                
                <div class="settings-item-view" id="set-anonymous-view">
                    <label>
                        <input class="form-check-input" type="checkbox" name="set-anonymous" id="set-anonymous" value="" autocomplete="off"></input>
                        <span class="settings-item-text">
                            Allow students ask anonymously
                        </span>
                    </label>
                </div>
                
                <div class="settings-item-view" id="set-discussion-view">
                    <label>
                        <input class="form-check-input" type="checkbox" name="set-discussion" id="set-discussion" value="" autocomplete="off"></input>
                        <span class="settings-item-text">
                            Allow students discuss online during lecture
                        </span>
                    </label>
                </div>
                
            </div>
            
        </div>
        
        <div class="modal-footer">
            <!-- Form button -->
            <div id="thread-social-control">
            <div class="pull-right">    
                <button type="button" class="btn btn-danger" id="respond-cancel" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        
    </div>
    <!-- Modal content END -->
        
    </div>
</div>
<!-- End of Modal -->