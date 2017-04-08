<!-- Start of Modal -->
<div class="modal fade poll-modal col-xs-12 col-sm-12 col-md-12 col-lg-12 fade " id="poll-result" config="{backdrop: false, keyboard: false}" tabindex="-1" role="dialog" >
    <div class="modal-dialog">

    <!-- Modal content START -->
    <div class="modal-content">
        
        
        <div class="modal-header">
            <button type="button" class="close" id="poll-vote-close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Polling</h4>
        </div>
        
        
        <div class="modal-body">
            
            <div class="alert alert-danger hidden" id="poll-result-error">
                <!-- Display Body by js -->
            </div>
            
            <div class="hidden" id="poll-result-id" value="-1">
                <!-- Display Body by js -->
            </div>
            
            <div id="poll-result-body">
                <!-- Display Body by js -->
            </div>
            
            <div class="hidden" id="poll-result-count">
                <!-- Display Body by js -->
            </div>

            <!-- TODO: Graphical Representation -->
            <div id="poll-result-chart">
            </div>
            
        </div>
        
        
        <?php 
            if ($this->session->userdata('user_type') == USER_TYPE_INSTRUCTOR):
        ?>
            <div class="modal-footer">
                <!-- Start / End Polling -->
                <div class="pull-left">
                    <button type="button" class="btn btn-danger poll-instructor-control hidden" id="poll-result-start" value="-1">
                        Start Polling
                    </button>
                    <button type="button" class="btn btn-danger poll-instructor-control" id="poll-result-stop" value="-1">
                        End Polling
                    </button>
                </div>

                <!-- View Result -->
                <div class="pull-right">
                    <button type="button" class="btn btn-link poll-instructor-control" id="poll-result-switch" value="-1">
                        &nbsp; Vote &nbsp;<i class="fa fa-arrow-right"></i>
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