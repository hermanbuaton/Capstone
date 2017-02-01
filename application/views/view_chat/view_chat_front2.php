
<div class="col-lg-6 row pull-right">
    
    <!-- Start of Panel -->
    <div class="panel-primary">
        
        <!-- ============================================================================ -->
        <!-- Panel Heading -->
        <!-- ============================================================================ -->
        <div class="panel-heading">
            <h3 class="panel-title">Question Bank</h3>
        </div>
    
        <!-- ============================================================================ -->
        <!-- Panel Body -->
        <!-- ============================================================================ -->
        <div class="panel-body">
        
            <!-- Messages -->
            <ul id="messages"></ul>

            <!-- Input area -->
            <form id="messages_input" action="">
                <input id="m" autocomplete="off" /><button id="send">Send</button>
            </form>

            <!-- Testing Line -->
            <?php echo base_url_port() . "socket.io/socket.io.js"; ?>
        
        </div>
    
    </div>
    <!-- End of Panel -->

</div>