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
        <div class="panel-heading" id="home-login-heading">
            
            <!-- Tab Navigation -->
            <ul class="nav nav-tabs">
                <li class="nav-two-items active" id="tab-student">
                    <a href="#">Student Login</a>
                </li>
                <li class="nav-two-items" id="tab-teacher">
                    <a href="#">Instructor Login</a>
                </li>
            </ul>
            
        </div>
        
        <!-- ======================================================== -->
        <!-- Panel Body -->
        <!-- ======================================================== -->
        <div class="panel-body">

            <div class="" id="home-login-student">
                <!-- Input area -->
                <form id="login-form" method="POST" action="<?php echo site_url('User/login'); ?>">
                    
                    <br/>
                    
                    Username:
                    <input class="form-control" type="text" name="username" id="username" placeholder="Username"></input>
                    <br/>
                    
                    <!--
                    Password:
                    <input class="form-control" type="password" name="password" id="password" placeholder="Password"></input>
                    <br/>
                    -->
                    
                    Course:
                    <input class="form-control" type="text" name="course" id="course" value="<?= $lecture; ?>" placeholder="Course Code"></input>
                    <br/>
                    
                    <!-- user type -->
                    <input class="form-control" type="hidden" name="usertype" id="usertype" value="<?= USER_TYPE_STUDENT; ?>" placeholder="Username"></input>
                    <br/>
                    
                    <div id="login-submit">
                        <button class="btn btn-primary" type="submit" id="login-submit-btn">Login</button>
                    </div>
                    <br/>
                </form>
            </div>
            
            <div class="hidden" id="home-login-teacher">
                <br/>
                <!-- Input area -->
                <form id="login-form" method="POST" action="<?php echo site_url('User/login'); ?>">

                    Username:
                    <input class="form-control" type="text" name="username" id="username" placeholder="Username"></input>
                    <br/>

                    Password:
                    <input class="form-control" type="password" name="password" id="password" placeholder="Password"></input>
                    <br/>
                    
                    <!-- user type -->
                    <input class="form-control" type="hidden" name="usertype" id="usertype" value="<?= USER_TYPE_INSTRUCTOR; ?>" placeholder="Username"></input>
                    <br/>
                    
                    <div id="login-submit">
                        <button class="btn btn-primary" type="submit" id="login-submit-btn">Login</button>
                    </div>
                    
                    <div style="padding-top: 10px; text-align: center;">
                        <a href="<?php echo site_url('User/create'); ?>">
                            <small>Create Account</small>
                        </a>
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