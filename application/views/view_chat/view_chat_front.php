<!-- Page Content -->
<div id="page-content-wrapper">
    <div class="container-fluid">
        
    
    <!-- Start of Panel -->
    <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4 pull-left hidden-xs">

        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vel ipsum euismod, blandit ipsum vel, mattis nisl. Quisque consequat eleifend vestibulum. Integer eu pretium nulla. Duis velit lectus, placerat sed nunc vitae, posuere aliquet nunc. Nam quis nisl tempus, pulvinar justo nec, mollis ex. In diam sem, tempus vehicula quam sed, euismod tincidunt nisl. Aenean tempus dolor sit amet lorem interdum, a condimentum quam consequat. Nullam nec orci vel tellus sodales mattis. Vestibulum porttitor mi tincidunt arcu molestie porta. Suspendisse at lacus velit. Proin eget sapien efficitur, tempor quam ut, viverra lectus. Vivamus lobortis eros sem, a ultricies tortor ultricies a.

        Nam eget ligula vulputate, pretium lacus quis, pharetra leo. Donec lobortis maximus pulvinar. Duis a interdum nulla. Integer eget ligula ullamcorper, congue magna non, faucibus nulla. Praesent diam risus, pretium ac dui at, congue tincidunt orci. Maecenas eget mattis arcu. Duis et dolor quis est facilisis convallis. Praesent nec erat ac nulla eleifend semper quis vel sapien. Integer scelerisque consectetur ullamcorper. Fusce placerat, lorem quis vehicula ultrices, sapien lacus interdum ipsum, eu facilisis velit magna sit amet sapien. Donec lobortis tortor sit amet risus maximus finibus.

        Suspendisse pulvinar mi sed nisl eleifend lacinia. Morbi aliquam eget ante vel finibus. Duis eu lacus libero. Integer sed semper lorem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis eleifend dapibus massa in pretium. Vestibulum sollicitudin et ex non facilisis. Integer dignissim blandit nulla quis gravida. Vivamus magna sem, dapibus nec erat eu, accumsan gravida quam. Sed quis volutpat ligula, ut viverra turpis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer dignissim lobortis condimentum. Praesent quis justo sodales, molestie leo sit amet, dignissim tortor. Mauris augue erat, egestas vitae vehicula eu, pellentesque in tellus. Sed eget arcu nulla.

        Ut vestibulum mauris aliquam orci euismod, vel ornare purus condimentum. Donec vel pharetra diam. Nulla lacus leo, placerat sit amet est quis, accumsan iaculis dolor. Vivamus pellentesque lacus ac orci blandit, id iaculis arcu bibendum. Maecenas tempus euismod condimentum. Mauris sed nunc vel nulla eleifend venenatis vel ut enim. Donec a porttitor tortor. Praesent sed pharetra lorem. Nam eros neque, venenatis a erat sit amet, aliquam dignissim lacus. Aenean cursus tempus cursus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vestibulum sed auctor ligula, ut sodales urna. Sed aliquet risus ac placerat tempor.

        Nunc arcu mauris, interdum faucibus efficitur ac, ultricies sed ante. Mauris sed dolor ut est consequat posuere et rhoncus sapien. Fusce tincidunt laoreet tincidunt. Morbi quis risus consequat, pretium augue sed, efficitur justo. Phasellus accumsan mi vitae sapien consectetur tincidunt. Suspendisse sed sapien hendrerit augue hendrerit malesuada sed vel eros. Aliquam sed purus augue.

    </div>
    <!-- End of Panel -->

    <!-- Start of Panel -->
    <div class="panel panel-default chat-panel col-xs-12 col-sm-5 col-md-4 col-lg-4 pull-right" id="main-chat">

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
            <div class="thread-view" id="main-chat-view">
                <!-- ** Messages here ** -->
                <!-- ** Change div CLASS & ID in view_chat_footer script ** -->
                <!--
                <div class="thread-message" id="main-chat-view-msg">
                </div>
                -->
            </div>

            <!-- Input area -->
            <form id="messages-input" action="">
                <div class="pull-bottom-left" id="main-chat-input">
                    
                    <!-- Thread Head -->
                    <textarea class="form-control" name="chat-message-head" id="chat-message-head" placeholder="Question" autocomplete="off" ></textarea>
                    
                    <!-- Thread Body -->
                    <textarea class="form-control" name="chat-message-body" id="chat-message-body" placeholder="Furtherer Explanation" autocomplete="off" ></textarea>
                    
                    <!-- Other fields -->
                    <!-- HIDDEN: AUTO COMPLETE BY JS / PHP -->
                    <!-- class id -->
                    <input class="form-control" type="hidden" name="chat-message-class" id="chat-message-class" value="<?= $subject; ?>" autocomplete="off"></input>
                    <!-- lect id -->
                    <input class="form-control" type="hidden" name="chat-message-lect" id="chat-message-lect" value="<?= /* TODO: lect id here */ ?>" autocomplete="off"></input>
                    <!-- timestamp -->
                    <input class="form-control" type="hidden" name="chat-message-time" id="chat-message-time" value="" autocomplete="off"></input>
                    
                </div>
                
                <div class="pull-bottom-right main-chat-control">
                    <button class="btn btn-primary main-chat-control-btn" id="main-chat-submit-btn">Send</button>
                    <button class="btn btn-danger main-chat-control-btn" id="main-chat-cancel-btn">Cancel</button>
                </div>
                    
                </div>
            </form>
            
        </div>

    </div>
    <!-- End of Panel -->
    
    
    </div>
    <!-- /#container-fluid -->
</div>
<!-- /#page-content-wrapper -->

