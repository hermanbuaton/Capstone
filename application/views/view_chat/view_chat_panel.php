<!-- Start of Panel -->
<div class="panel panel-default forum-panel col-xs-12 col-sm-5 col-md-4 col-lg-4 pull-right" id="forum-panel-view">
    
    <!-- ============================================================================ -->
    <!-- Panel Heading -->
    <!-- ============================================================================ -->
    <div class="panel-heading">
        
        <div class="pull-left">
            <h3 class="panel-title">Question Bank</h3>
        </div>
        
        <div class="btn-group panel-dropdown pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                Menu
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" id="panel-dropdown">
                
                <!-- ======================================== -->
                <!-- Message order
                <!-- ======================================== -->
                <li class="disabled"><a>Sort by:</a></li>
                <li class="forum-panel-dropdown-subli">
                    <a href="#" class="forum-panel-order-control " id="forum-panel-order-chrono" value="<?= MESSAGE_SHOW_CHRONO; ?>">
                        Chronological
                    </a>
                </li>
                <li class="forum-panel-dropdown-subli">
                    <a href="#" class="forum-panel-order-control " id="forum-panel-order-vote" value="<?= MESSAGE_SHOW_VOTE; ?>">
                        Popularity
                    </a>
                </li>
                <li class="forum-panel-dropdown-subli">
                    <a href="#" class="forum-panel-order-control " id="forum-panel-order-label" value="<?= MESSAGE_SHOW_LABEL; ?>">
                        Labels
                    </a>
                </li>
                <li class="divider"></li>
                
                <!-- ======================================== -->
                <!-- Poll
                <!-- ======================================== -->
                <?php 
                    if ($this->session->userdata('user_type') == USER_TYPE_INSTRUCTOR) :
                ?>
                    <li>
                        <a href="#" id="poll-create-toggle" data-toggle="modal" data-target="#poll-input">
                            Start a Poll
                        </a>
                    </li>
                    <li class="divider"></li>
                <?php
                    endif;
                ?>
                
                <!-- ======================================== -->
                <!-- Others
                <!-- ======================================== -->
                <?php 
                    if ($this->session->userdata('user_type') == USER_TYPE_INSTRUCTOR) :
                ?>
                    <li>
                        <a href="#" id="settings-show-toggle" data-toggle="modal" data-target="#settings-show">
                            Settings
                        </a>
                    </li>
                <?php 
                    endif;
                ?>
                <li>
                    <a href="#" id="login-show-toggle" data-toggle="modal" data-target="#login-show">
                        Show QR Code
                    </a>
                </li>
                
            </ul>
        </div>
        
    </div>

    <!-- ============================================================================ -->
    <!-- Panel Body -->
    <!-- ============================================================================ -->
    <div class="panel-body">

        <!-- Messages -->
        <div class="forum-list" id="forum-list-view">
            <!-- ** Messages here ** -->
            <!-- ** Change div CLASS & ID in view_chat_footer script ** -->
            <!-- ** Change layout in view_chat_message ** -->
        </div>

        <!-- Input area -->
        <div class="pull-bottom-left" id="forum-quick-input-data-view">
            <textarea class="form-control" name="input-message-body" id="input-message-toggle" placeholder="Question" data-toggle="modal" data-target="#input-full" autocomplete="off" ></textarea>
        </div>
        
        <!--
        <div class="pull-bottom-right" id="forum-quick-input-control-view">
            <button class="btn btn-primary forum-quick-input-control" id="forum-quick-input-submit">
                Send
            </button>
            <button class="btn btn-danger forum-quick-input-control" id="forum-quick-input-cancel">
                Cancel
            </button>
        </div>
        -->

        </div>

    </div>

</div>
<!-- End of Panel -->