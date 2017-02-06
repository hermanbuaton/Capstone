<!-- Page Content -->
<div id="page-content-wrapper">
    <div class="container-fluid">
        
    <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" id="home-login-error">
        <div id="login-error-msg"></div>
    </div>
    
    <!-- Start of Panel -->
    <div class="panel panel-default col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" id="home-login">

        <!-- ============================================================================ -->
        <!-- Panel Heading -->
        <!-- ============================================================================ -->
        <!--
        <div class="panel-heading">
            <h3 class="panel-title">User Login</h3>
        </div>
        -->
        
        <!-- ============================================================================ -->
        <!-- Panel Body -->
        <!-- ============================================================================ -->
        <div class="panel-body">

            <!-- Input area -->
            <form id="login-form" method="POST" action="<?php echo site_url('User/login'); ?>">
                
                Username:
                <input class="form-control" type="text" name="username" id="username" placeholder="Username"></input>
                <br/>
                
                Password:
                <input class="form-control" type="password" name="password" id="password" placeholder="Password"></input>
                <br/>
                
                Course:
                <input class="form-control" type="course" name="course" id="course" placeholder="Course Code"></input>
                <br/>
                
                <div id="login-submit">
                    <button class="btn btn-primary" type="submit" id="login-submit-btn">User Login</button>
                </div>
            </form>
            
        </div>

    </div>
    <!-- End of Panel -->
    
    
    </div>
    <!-- /#container-fluid -->
</div>
<!-- /#page-content-wrapper -->