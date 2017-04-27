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
            <div id="thread-question-body">
                <!-- Display Thread Body by js -->
            </div>
            <div id="thread-question-social">
                
                <!-- author -->
                <div class="forum-thread-author respond-modal-social-control" id="thread-question-author" >
                    <span class="forum-social-content" id="respond-modal-author-text">
                        <i class="fa fa-user"></i>
                    </span>
                    <span class="forum-thread-author-name forum-social-content" id="respond-modal-author-name">
                        <!-- set by js on toggle -->
                    </span>
                </div>
                
                <!-- vote button -->
                <button class="btn btn-default respond-modal-social-control disabled" id="thread-question-vote" >
                    <span class="forum-social-content" id="respond-modal-vote-text">
                        <i class="fa fa-plus-square"></i>
                    </span>
                    <span class="forum-thread-vote-count forum-social-content" id="respond-modal-vote-count">
                        <!-- set by js on toggle -->
                    </span>
                </button>
                
                <!-- raise hand button -->
                <button class="btn btn-default respond-modal-social-control" id="thread-question-hand" >
                    <span class="forum-social-content" id="respond-modal-hand-text">
                        <i class="fa fa-hand-paper-o"></i>
                    </span>
                    <span class="forum-thread-hand-count forum-social-content" id="respond-modal-hand-count">
                        <!-- set by js on toggle -->
                    </span>
                </button>
                
                <!-- Random Delegate -->
                <button class="btn btn-warning pull-right" id="thread-question-delegate" >
                    <span class="forum-social-content" id="respond-modal-hand-text">
                        <i class="fa fa-snapchat-ghost"></i>
                    </span>
                    <span class="forum-thread-delegate forum-social-content" id="respond-modal-delegate">
                        Random Delegate
                    </span>
                </button>
                
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
                <div class="pull-left">
                    <button type="button" class="btn btn-primary respond-control respond-control-wide hidden" id="respond-voice-start">
                        Start recording
                    </button>
                    <button type="button" class="btn btn-danger respond-control respond-control-wide" id="respond-voice-stop">
                        Stop recording
                    </button>
                </div>
                <div class="pull-right">    
                    <button type="button" class="btn btn-primary respond-control" id="respond-submit" data-dismiss="modal">
                        Save
                    </button>
                    <button type="button" class="btn btn-danger respond-control" id="respond-cancel" data-dismiss="modal">
                        Cancel
                    </button>
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