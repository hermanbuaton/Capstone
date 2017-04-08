<!-- Start of Modal -->
<div class="modal poll-modal col-xs-12 col-sm-12 col-md-12 col-lg-12 fade " id="poll-vote" config="{backdrop: false, keyboard: false}" tabindex="-1" role="dialog" >
    <div class="modal-dialog">

    <!-- Modal content START -->
    <div class="modal-content">
        
        
        <div class="modal-header">
            <button type="button" class="close" id="poll-vote-close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Polling</h4>
        </div>
        
        
        <div class="modal-body">
            
            <form id="poll-vote-form">
                <div id="poll-vote-body">
                    <!-- Display Body by js -->
                </div>

                <div id="poll-vote-opt">
                    <!-- Display Option by js -->
                </div>
            </form>
            
        </div>
        
        
        <?php 
            if ($this->session->userdata('user_type') == USER_TYPE_INSTRUCTOR):
        ?>
            <div class="modal-footer">
                
                <!-- Start / End Polling -->
                <div class="pull-left">
                    <button type="button" class="btn btn-danger poll-instructor-control hidden" id="poll-vote-start" value="-1">
                        Start Polling
                    </button>
                    <button type="button" class="btn btn-danger poll-instructor-control" id="poll-vote-stop" value="-1">
                        End Polling
                    </button>
                </div>

                <!-- View Result -->
                <div class="pull-right">
                    <button type="button" class="btn btn-link poll-instructor-control" id="poll-vote-switch" value="-1">
                        &nbsp; View Result &nbsp;<i class="fa fa-arrow-right"></i>
                    </button>
                </div>

            </div>
        <?php
            endif;
        ?>
        
        
    </div>
    <!-- Modal content END -->
        
    </div>
</div>
<!-- End of Modal -->