
<!-- BEGIN HEADER MENU -->
<div class="page-header-menu">
    <div class="container2">
	 <!-- BEGIN LOGO -->
        <div class="page_logo2">
            <a href="#/dashboard.html"><img src="<?php echo base_url('assets/admin/layout/img/Menu-Logo.png') ?>" alt="logo" ></a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN MEGA MENU -->
        <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
        <!-- DOC: Remove dropdown-menu-hover and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
        <div class="hor-menu">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="#/dashboard">Dashboard</a>
                </li>
                <li class="active">
                    <a href="#/warranties">Warranties</a>
                </li>
                <li class="active">
                    <a href="#/licenses">Licenses</a>
                </li>
                <li class="active">
                    <a href="#/documents">Documents</a>
                </li>
                <li class="active">
                    <a href="#/amc">AMC's &amp; Renewals</a>
                </li>                              
                <li class="active">
                    <a href="#/service">Service Schedule</a>
                </li>
                <li class="active">
                    <a href="#/profile/changeprofile">Settings</a>
                </li>                            
              

            </ul>
        </div>
        <!-- END MEGA MENU -->
		 <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">												
                
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <li class="dropdown dropdown-user dropdown-dark">
                    <a href="javascript:;" class="dropdown-toggle" dropdown-menu-hover data-toggle="dropdown" data-close-others="true">
					   <div class="name_main" style="float:left;" >
                        <?php if ($this->session->userdata('profile_image')) { ?>
                            <img src="<?php echo $this->session->userdata('profile_image'); ?>" alt="" class="img-circle" style='max-height:41px !important;' />
                        <?php } else { ?>
                            <div class="default-profile-image-small"><?php echo ucwords(substr($this->session->userdata('username'), 0, 1)); ?></div>    
                        <?php } ?>
						</div>
                        <div  class="username username-hide-mobile name_tag">Name <br/><?php echo $this->session->userdata('username'); ?></div>
						<div class="down_arrow" ><img  src="<?php echo base_url('assets/admin/layout/img/Dropdown-Arrow.png') ?>" alt="" /></div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="#/profile/changeprofile">
                                <i class="icon-user"></i> My Profile </a>
                        </li>                       
                        <li>
                            <a href="logout">
                                <i class="icon-key"></i> Log Out </a>
                        </li>
                    </ul>
                </li>
				<li>
				 <a href="#" class="fa fa-search search_right" ></a>
				</li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
</div>
<!-- END HEADER MENU -->