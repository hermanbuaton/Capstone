<!-- Start of Modal -->
<div class="modal dashboard-modal col-xs-12 col-sm-12 col-md-12 col-lg-12 fade " id="class-create-modal" config="{backdrop: false, keyboard: false}" tabindex="-1" role="dialog" >
    <div class="modal-dialog">

    <!-- Modal content START -->
    <div class="modal-content">
        

        <div class="modal-header">
            <button type="button" class="close" id="class-create-close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">New Class</h4>
        </div>
        

        <div class="modal-body">
            
            <div id="class-create-head">
                <!-- Display Thread Body by js -->
            </div>

            <form id="class-create-form">
                
                <!-- Form Input -->
                <div id="class-create-input">
                    
                    <!-- User ID -->
                    <input class="form-control respond-control" type="hidden" name="user_id" id="user_id" value="<?= $this->session->userdata('user_id'); ?>" autocomplete="off"></input>
                    
                    <!-- Course Code -->
                    <input class="form-control respond-control" type="text" name="course_code" id="course_code" value="" placeholder="Course Code" autocomplete="off"></input>
                    
                    <!-- Class Code -->
                    <input class="form-control respond-control" type="text" name="class_code" id="class_code" value="" placeholder="Class Code" autocomplete="off"></input>
                    
                    <!-- Semester ID -->
                    <select class="form-control respond-control" type="hidden" name="semester" id="semester" placeholder="Semester" autocomplete="off">
                        
                        <option selected value disabled>
                            Semester
                        </option>
                        
                        <!-- Display semester loaded from db -->
                        <?php
                            foreach ($semester as $s) {
                        ?>
                        <option value="<?= $s['sem_id']; ?>">
                            <?= $s['sem_code'] . ' - ' . $s['sem_name']; ?>
                        </option>
                        <?php
                            }
                        ?>
                        
                    </select>
                    
                </div>
            
                <!-- Form button -->
                <div class="dashboard-modal-footer-control">
                <div class="pull-right">    
                    <button type="button" class="btn btn-primary respond-control" id="class-create-submit" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-danger respond-control" id="class-create-cancel" data-dismiss="modal">Cancel</button>
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