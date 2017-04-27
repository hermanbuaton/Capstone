<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>css/bootstrap.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="<?php echo base_url(); ?>css/sb-admin.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/simple-sidebar.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>css/custom.css" rel="stylesheet">
    
    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url(); ?>css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
    
<!--
<body class="<?php // echo ($page == "Chat" ? "main-ui" : "main-ui-scroll"); ?>">
-->
<body class="main-ui" id="main-ui">

    <div id="wrapper">
        
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            
            
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">

            <?php 
                if ($page == "Chat"
                    || $page == "Dashboard") : 
            ?>
                <button type="button" href="#menu-toggle" class="navbar-toggle pull-left" id="menu-toggle" >
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            <?php 
                endif; 
            ?>
                
                <a class="navbar-brand <?php if ($page == "Chat") echo "chat-brand"; ?> disabled" href=""><?= $title; ?></a>
                
                
                <button type="button" class="navbar-toggle pull-right" id="navbar-toggle-right" data-toggle="collapse" data-target=".navbar-ex1-collapse" style="width:44px;height:36px;">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="fa fa-caret-down" style="color:#fff; top:-50px;"></span>
                    <!--
                    <span class="icon-envelope"></span>
                    <b class="caret" style="color:#fff;"></b>
                    -->
                </button>
            
            </div>
            
            
            <!-- Top Menu Items -->
            <?php 
                if ($this->session->userdata('user_name')) : 
            ?>
                <ul class="nav navbar-right top-nav navbar-collapse navbar-ex1-collapse collapse" id="navbar-right">
                    
                    
                    <!-- hiding for reference -->
                    <!--
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i>
                            John Smith
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">
                                    <i class="fa fa-fw fa-user"></i>
                                    Profile
                                </a>
                            </li>
                        </ul>
                    </li>
                    -->
                    <!-- hiding for reference -->
                    
                    
                    <!-- DASHBOARD start here -->
                    <li class="dropdown headbar-dropdown">
                        <a href="<?php echo site_url("/Dashboard"); ?>">
                            <i class="fa fa-dashboard"></i>
                            Dashboard
                        </a>
                    </li>
                    <!-- DASHBOARD end here -->
                    
                    
                    <!-- LOGOUT start here -->
                    <li class="dropdown headbar-dropdown">
                        <a href="<?php echo site_url("/User/logout"); ?>">
                            <i class="fa fa-sign-out"></i>
                            Logout
                        </a>
                    </li>
                    <!-- LOGOUT end here -->
                    
                    
                </ul>
                <!-- /.navbar-collapse -->
            <?php endif; ?>
            
            
        </nav>