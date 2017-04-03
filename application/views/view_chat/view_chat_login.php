<!-- Start of Modal -->
<div class="modal login-modal col-xs-12 col-sm-12 col-md-12 col-lg-12 fade " id="login-show" config="{backdrop: false, keyboard: false}" tabindex="-1" role="dialog" >
    <div class="modal-dialog">

    <!-- Modal content START -->
    <div class="modal-content">
        
        <div class="modal-header">
            <button type="button" class="close" id="thread-respond-close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Login to lecture</h4>
        </div>
        

        <div class="modal-body">
            
            <div id="login-show-view" style="text-align: center;">
                
                <img src="<?php echo "https://chart.googleapis.com/chart?chs=350x350&cht=qr&chl=" . base_url("Chat/$subject"); ?>"/>
                
                <br/>
                
                <h5><a href="<?php echo base_url("Chat/$subject"); ?>">
                    <?php echo base_url("Chat/$subject"); ?>
                </a></h5>
                
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