<!-- BEGIN PAGE HEADER-->
<div class="page-bar" >
 
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="#dashboard">Home</a><i class="fa fa-circle"></i>
    </li>

    <li class="active">
        Profile
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!--    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                Actions <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <li>
                    <a href="#">
                        <i class="icon-user"></i> New User </a>
                </li>
                <li>
                    <a href="#">
                        <i class="icon-present"></i> New Event <span class="badge badge-success">4</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="icon-basket"></i> New order </a>
                </li>
                <li class="divider">
                </li>
                <li>
                    <a href="#">
                        <i class="icon-flag"></i> Pending Orders <span class="badge badge-danger">4</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="icon-users"></i> Pending Users <span class="badge badge-warning">12</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>-->
</div>
<h3 class="page-title">
    <?php echo ucwords($this->session->userdata('username')); ?>
</h3>
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet" style="padding-top: 0px !important;">
                <!-- SIDEBAR USERPIC -->
<!--                <div class="profile-userpic">
                    <img src="<?php //echo base_url();?>assets/admin/pages/media/profile/avatar9.jpg" class="img-responsive" alt="">
                </div>-->
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
<!--                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        Ayush Biyani
                    </div>
                    <div class="profile-usertitle-job">
                        Developer
                    </div>
                </div>-->
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
<!--                <div class="profile-userbuttons">
                    <button type="button" class="btn btn-circle green-haze btn-sm">Follow</button>
                    <button type="button" class="btn btn-circle btn-danger btn-sm">Message</button>
                </div>-->
                <!-- END SIDEBAR BUTTONS -->
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu">
                    <ul class="nav">
                        <?php if ($this->permisson->has_permission('profile', array('change_profile'), 1)) { ?>
                        <li ng-class="{active: $state.includes('profile.changeprofile')}">
                            <a ui-sref="profile.changeprofile">
                                <i class="icon-home"></i>
                                Profile </a>
                        </li>
                        <?php } ?>
                        <?php if ($this->permisson->has_permission('profile', array('manage_account'), 1)) { ?>
                        <li ng-class="{active: $state.includes('profile.manageaccount')}">
                            <a ui-sref="profile.manageaccount">
                                <i class="icon-settings"></i>
                                Account Details </a>
                        </li>
                        <?php } ?>
                        <?php if ($this->permisson->has_permission('profile', array('user_management'), 1)) { ?>
                        <li ng-class="{active: $state.includes('profile.usermanagement')}">
                            <a ui-sref="profile.usermanagement">
                                <i class="icon-settings"></i>
                                User Management </a>
                        </li>
                        <?php } ?>
<!--                        <li>
                            <a href="#/todo">
                                <i class="icon-check"></i>
                                User Management </a>
                        </li>-->
                        <?php if ($this->permisson->has_permission('profile', array('manage_devices'), 1)) { ?>
                        <li ng-class="{active: $state.includes('profile.devicemanagement')}">
                            <a ui-sref="profile.devicemanagement">
                                <i class="icon-info"></i>
                                Device Management </a>
                        </li>
                        <?php } ?>
<!--                         <li ng-class="{active: $state.includes('profile.help')}">
                            <a ui-sref="profile.help">
                                <i class="icon-info"></i>
                                Payments </a>
                        </li>-->
                        <?php if ($this->permisson->has_permission('profile', array('export_data'), 1)) { ?>
                         <li ng-class="{active: $state.includes('profile.exportdata')}">
                            <a ui-sref="profile.exportdata">
                                <i class="icon-info"></i>
                                Export  Data </a>
                        </li>
                        <?php } ?>
                        <?php if ($this->permisson->has_permission('profile', array('deactivate_account'), 1)) { ?>
                         <li ng-class="{active: $state.includes('profile.deactivateaccount')}">
                            <a ui-sref="profile.deactivateaccount">
                                <i class="icon-info"></i>
                                Deactivate Account </a>
                        </li>
                        <?php } ?>
                        <?php if ($this->permisson->has_permission('profile', array('contact_information'), 1)) { ?>
                         <li ng-class="{active: $state.includes('profile.contactinformation')}">
                            <a ui-sref="profile.contactinformation">
                                <i class="icon-info"></i>
                                Contact Information </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <!-- END MENU -->
            </div>
            <!-- END PORTLET MAIN -->
            <!-- PORTLET MAIN -->
<!--            <div class="portlet light">
                 STAT 
                <div class="row list-separated profile-stat">
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title">
                            37
                        </div>
                        <div class="uppercase profile-stat-text">
                            Projects
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title">
                            51
                        </div>
                        <div class="uppercase profile-stat-text">
                            Tasks
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title">
                            61
                        </div>
                        <div class="uppercase profile-stat-text">
                            Uploads
                        </div>
                    </div>
                </div>
                 END STAT 
                <div>
                    <h4 class="profile-desc-title">About Marcus Doe</h4>
                    <span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore. </span>
                    <div class="margin-top-20 profile-desc-link">
                        <i class="fa fa-globe"></i>
                        <a href="http://www.keenthemes.com">www.keenthemes.com</a>
                    </div>
                    <div class="margin-top-20 profile-desc-link">
                        <i class="fa fa-twitter"></i>
                        <a href="http://www.twitter.com/keenthemes/">@keenthemes</a>
                    </div>
                    <div class="margin-top-20 profile-desc-link">
                        <i class="fa fa-facebook"></i>
                        <a href="http://www.facebook.com/keenthemes/">keenthemes</a>
                    </div>
                </div>
            </div>-->
            <!-- END PORTLET MAIN -->
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->
        <!-- BEGIN PROFILE CONTENT -->
        <div ui-view class="profile-content fade-in-up"> 
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>
<!-- END PAGE CONTENT-->