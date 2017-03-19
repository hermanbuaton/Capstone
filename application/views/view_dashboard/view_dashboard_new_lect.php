<!-- Start of Modal -->
<div class="modal dashboard-modal col-xs-12 col-sm-12 col-md-12 col-lg-12 fade " id="lect-create-modal" config="{backdrop: false, keyboard: false}" tabindex="-1" role="dialog" >
    <div class="modal-dialog">

    <!-- Modal content START -->
    <div class="modal-content">
        

        <div class="modal-header">
            <button type="button" class="close" id="lect-create-close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">New Lecture</h4>
        </div>
        

        <div class="modal-body">
            
            <div id="lect-create-head">
                <!-- Display Thread Body by js -->
            </div>

            <form id="lect-create-form">
                
                <!-- Form Input -->
                <div id="lect-create-input">
                    
                    <!-- HIDDEN: User ID -->
                    <input class="form-control dashboard-control" type="hidden" name="user_id" id="user_id" value="<?= $this->session->userdata('user_id'); ?>" autocomplete="off"></input>
                    
                    <!-- HIDDEN: Class ID -->
                    <input class="form-control dashboard-control" type="hidden" name="class_id" id="class_id" value="" autocomplete="off"></input>
                    
                    <!-- Class Name -->
                    Class: <br/>
                    <input class="form-control dashboard-control" type="text" name="class_name" id="class_name" value="" placeholder="Class" autocomplete="off" disabled></input>
                    
                    <!-- Lect Name -->
                    Lecture Name: <br/>
                    <input class="form-control dashboard-control" type="text" name="lect_name" id="lect_name" value="" placeholder="Lecture Topic" autocomplete="off"></input>
                    
                    <!-- DATETIME: Year -->
                    Scheduled Start Time: <br/>
                    <input class="form-control form-date-control dashboard-control" type="text" name="start_year" id="start_year" value="" placeholder="YYYY" autocomplete="off"></input>
                    <div class="form-datetime-span">/</div>
                    <!-- DATETIME: Month -->
                    <input class="form-control form-date-control dashboard-control" type="text" name="start_month" id="start_month" value="" placeholder="MM" autocomplete="off"></input>
                    <div class="form-datetime-span">/</div>
                    <!-- DATETIME: Day -->
                    <input class="form-control form-date-control dashboard-control" type="text" name="start_day" id="start_day" value="" placeholder="DD" autocomplete="off"></input>
                    <div class="form-datetime-span">&nbsp;&nbsp;&nbsp;</div>
                    <!-- DATETIME: Hour -->
                    <input class="form-control form-time-control dashboard-control" type="text" name="start_hour" id="start_hour" value="" placeholder="HH" autocomplete="off"></input>
                    <div class="form-datetime-span">:</div>
                    <!-- DATETIME: Minutes -->
                    <input class="form-control form-time-control dashboard-control" type="text" name="start_min" id="start_min" value="" placeholder="MM" autocomplete="off"></input>
                    
                </div>
            
                <!-- Form button -->
                <div class="dashboard-modal-footer-control">
                <div class="pull-right">    
                    <button type="button" class="btn btn-primary respond-control" id="lect-create-submit" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-danger respond-control" id="lect-create-cancel" data-dismiss="modal">Cancel</button>
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