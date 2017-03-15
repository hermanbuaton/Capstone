<!-- Start of Modal -->
<div class="modal respond-modal col-xs-12 col-sm-12 col-md-12 col-lg-12 fade " id="thread-respond" config="{backdrop: false, keyboard: false}" tabindex="-1" role="dialog" >
    <div class="modal-dialog">

    <!-- Modal content START -->
    <div class="modal-content">
        

        <div class="modal-header">
            <button type="button" class="close" id="thread-respond-close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Question from Audience</h4>
        </div>
        

        <div class="modal-body">
            
            <div id="thread-question-head">
                <!-- Display Thread Body by js -->
            </div>

            <form id="respond-form">
                
                <!-- Speech Input -->
                <div id="thread-respond-input">
                    <input class="form-control respond-control" type="hidden" name="respond-id" id="respond-id" value="" autocomplete="off"></input>
                    <input class="form-control respond-control" type="hidden" name="respond-body" id="respond-body" value="" autocomplete="off"></input>
                    <textarea class="form-control respond-control" name="respond-textarea" id="respond-textarea" placeholder="Respond" autocomplete="off" ></textarea>
                </div>
            
                <!-- Form button -->
                <div id="thread-respond-control">
                <div class="pull-right">    
                    <button type="button" class="btn btn-primary respond-control" id="respond-submit" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-danger respond-control" id="respond-cancel" data-dismiss="modal">Cancel</button>
                </div>
                </div>
                
            </form>
            
        </div>
        
        
        <!--
        <div class="modal-footer">
            <button type="button" class="btn btn-default" id="respond-submit" data-dismiss="modal">Save</button>
        </div>
        -->
        
        
    </div>
    <!-- Modal content END -->
        
    </div>
</div>
<!-- End of Modal -->