<!-- Page Content -->
<div id="page-content-wrapper">
    <div class="container-fluid">
        
    <?php if ($error != null): ?>
        <div class="alert alert-danger col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" id="home-login-error">
            <div id="login-error-msg">
                <?php echo $error; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Start of Panel -->
    <div class="panel panel-default col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" id="home-login">

        <!-- ======================================================== -->
        <!-- Panel Heading -->
        <!-- ======================================================== -->
        <!--
        <div class="panel-heading" id="home-login-heading">
        </div>
        -->
        
        <!-- ======================================================== -->
        <!-- Panel Body -->
        <!-- ======================================================== -->
        <div class="panel-body">

            <div class="">
                <!-- Input area -->
                <form id="login-form" method="POST" action="<?php echo site_url('User/create'); ?>">

                    Username:
                    <input class="form-control" type="text" name="username" id="username" placeholder="Username"></input>
                    <br/>

                    Nickname (As displayed during discussion):
                    <input class="form-control" type="text" name="nickname" id="nickname" placeholder="Nickname"></input>
                    <br/>

                    Password:
                    <input class="form-control" type="password" name="password" id="password" placeholder="Password"></input>
                    <br/>

                    Name of Institution (Optional):
                    <input class="form-control" type="text" name="school" id="school" placeholder="Institution"></input>
                    <br/>

                    <div id="login-submit">
                        <button class="btn btn-primary" type="submit" id="login-submit-btn">Login</button>
                    </div>
                </form>
            </div>
            
        </div>

    </div>
    <!-- End of Panel -->
    
    
    </div>
    <!-- /#container-fluid -->
</div>
<!-- /#page-content-wrapper -->