        </div>
        <!-- /#container-fluid -->
    </div>
    <!-- /#page-content-wrapper -->


    </div>
    <!-- /#wrapper -->
    
    

    <!-- socket.io -->
    <script src="<?php echo base_url_port(); ?>socket.io/socket.io.js"></script>
    
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <!--<script src="http://code.jquery.com/jquery-1.11.1.js"></script>-->
    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url(); ?>js/plugins/morris/raphael.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/morris/morris.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/morris/morris-data.js"></script>
    
    <script>
        
        
        /** ========================================
        *   onload
        *   see view_chat_footer.php
        *   ======================================== */
        
        $(window).load(function() {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url("Dashboard/load"); ?>",
                
                success: function(data) {
                    $('#dashboard-class-list').html(data);
                }
            });
        });
        
        
        
        /** ========================================
        *   Class Create
        *   ======================================== */
        
        //  form submit
        $('#class-create-form').submit(function(){
            classCreate();
            return false;
        });
        
        //  submit button clicked
        $('#class-create-submit').click(function(){
            $('#class-create-form').submit();
            return false;
        });
        
        //  cancel button clicked
        $('#class-create-cancel').click(function(){
            resetForm($('#class-create-form'));
            $('#class-create-modal').modal('toggle');
            return false;
        });
        
        
        
        /** ========================================
        *   Lect Create
        *   ======================================== */
        
        //  open modal
        $(document).on('submit', '.lect-create-toggle', function(e){
            e.preventDefault();
            $('#class_id').val($(this).children('#lect-create-id').val());
            $('#class_name').val($(this).children('#lect-create-name').val());
            $('#lect-create-modal').modal('toggle');
        });
        
        //  form submit
        $('#lect-create-form').submit(function(){
            lectCreate();
            return false;
        });
        
        //  submit button clicked
        $('#lect-create-submit').click(function(){
            $('#lect-create-form').submit();
            return false;
        });
        
        //  cancel button clicked
        $('#lect-create-cancel').click(function(){
            resetForm($('#lect-create-form'));
            $('#lect-create-modal').modal('toggle');
            return false;
        });
        
        
        
        /** ========================================
        *   Real Work
        *   ======================================== */
        
        //  Create CLASS
        function classCreate() {
            
            // validation
            var co = $("#course_code").val();
            var cl = $("#class_code").val();
            var se = $("#semester").val();
            
            // if ALL fields have content
            if (co.length > 0 && cl.length > 0 && se > 0)
            {
                // (1) to database
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url("Dashboard/class_create"); ?>",
                    data: $('#class-create-form').serialize(),
                    
                    success: function(data) {
                        // display on dashboard
                        $('#dashboard-class-list').html(data);
                    }
                });
                
            }
            // if ONLY EITHER ONE field have content
            else
            {
                // do something
                console.log("something not yet inputted");
                return false;
            }
            
            resetForm($('#class-create-form'));
            $('#class-create-modal').modal('toggle');
            return false;
            
        }
        
        
        //  Create LECTURE
        function lectCreate() {
            
            // validation
            var id = $("#class_id").val();
            var cl = $("#class_name").val();
            var le = $("#lect_name").val();
            var yy = $("#start_year").val();
            var mm = $("#start_month").val();
            var dd = $("#start_day").val();
            var hh = $("#start_hour").val();
            var ii = $("#start_min").val();
            
            // if ALL fields have content
            if (id.length > 0 && cl.length > 0 && le.length > 0
               && yy.length > 0 && mm.length > 0 && dd.length > 0
               && hh.length > 0 && ii.length > 0)
            {
                // (1) to database
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url("Dashboard/lect_create"); ?>",
                    data: $('#lect-create-form').serialize(),
                    
                    success: function(data) {
                        
                        // display on dashboard
                        $('#dashboard-class-list').html(data);
                        
                        // show panel
                        var s = 'dashboard-class-panel-' + id;
                        var d = document.getElementById(s);
                        $(d).toggle();
                        
                    }
                });
                
            } 
            // if ONLY EITHER ONE field have content
            else
            {
                // do something
                console.log("something not yet inputted");
                return false;
            }
            
            resetForm($('#lect-create-form'));
            $('#lect-create-modal').modal('toggle');
            return false;
            
        }
        
        
        
        //  clear message <form>
        function resetForm(form) {
            form.trigger('reset');
            return false;
        }
        
        
    </script>

</body>

</html>