
<!-- BEGIN MAIN CONTENT -->
<div ng-controller="DashboardController" class="margin-top-10">	
    <div class="row" style="height: 800px;">
        <div class="col-md-12 col-sm-12" style="padding-bottom:50px;">
            <h2><?php echo ucfirst($this->session->userdata('username')); ?> - Dashboard  </h2>
            <div class="dashboard_blocks">
                <div class="dashboard_top_one">
                    <div class="dash_status_cont" >
                        <h4 class="dash_head">Warranties</h4>
                        <div class="status_cont">
                            <div class="status_left">
                                Expired
                            </div>
                            <div class="status_right_one">
                                {{ warranty.warranty_expired}}
                            </div>
                        </div>
                        <div class="status_cont">
                            <div class="status_left">
                                Expiring
                            </div>
                            <div class="status_right_two">
                                {{ warranty.warranty_expiring}}
                            </div>
                        </div>
                        <div class="status_cont">
                            <div class="status_left">
                                Active
                            </div>
                            <div class="status_right_three">
                                {{ warranty.warranty_active}}
                            </div>P
                        </div>
                    </div>						
                </div>
                <div class="dashboard_blocks_one_icn">

                </div>
            </div>


            <div class="dashboard_blocks">
                <div class="dashboard_top_two">
                    <div class="dash_status_cont" >
                        <h4 class="dash_head">Licenses</h4>
                        <div class="status_cont">
                            <div class="status_left">
                                Expired
                            </div>
                            <div class="status_right_one">
                                {{ licenses.licenses_expired}}
                            </div>
                        </div>
                        <div class="status_cont">
                            <div class="status_left">
                                Expiring
                            </div>
                            <div class="status_right_two">
                                {{ licenses.licenses_expiring}}
                            </div>
                        </div>
                        <div class="status_cont">
                            <div class="status_left">
                                Active
                            </div>
                            <div class="status_right_three">
                                {{ licenses.licenses_active}}
                            </div>
                        </div>
                    </div>						
                </div>
                <div class="dashboard_blocks_two_icn">

                </div>
            </div>


            <div class="dashboard_blocks">
                <div class="dashboard_top_three">
                    <div class="dash_status_cont" >
                        <h4 class="dash_head">Documents</h4>
                        <div class="status_cont">
                            <div class="status_left">
                                Expired
                            </div>
                            <div class="status_right_one">
                                100
                            </div>
                        </div>
                        <div class="status_cont">
                            <div class="status_left">
                                Expiring
                            </div>
                            <div class="status_right_two">
                                100
                            </div>
                        </div>
                        <div class="status_cont">
                            <div class="status_left">
                                Active
                            </div>
                            <div class="status_right_three">
                                100
                            </div>
                        </div>
                    </div>						
                </div>
                <div class="dashboard_blocks_three_icn">

                </div>
            </div>


            <div class="dashboard_blocks">
                <div class="dashboard_top_four">
                    <div class="dash_status_cont" >
                        <h4 class="dash_head">AMCs</h4>
                        <div class="status_cont">
                            <div class="status_left">
                                Expired
                            </div>
                            <div class="status_right_one">
                                {{ amc.amc_expired}}
                            </div>
                        </div>
                        <div class="status_cont">
                            <div class="status_left">
                                Expiring
                            </div>
                            <div class="status_right_two">
                                {{ amc.amc_expiring}}
                            </div>
                        </div>
                        <div class="status_cont">
                            <div class="status_left">
                                Active
                            </div>
                            <div class="status_right_three">
                                {{ amc.amc_active}}
                            </div>
                        </div>
                    </div>						
                </div>
                <div class="dashboard_blocks_four_icn">

                </div>
            </div>

            <div class="dashboard_block_big">
                <div class="dashboard_top_five">
                    <div class="dash_status_cont" >
                        <h4 class="dash_head">Service Schedule</h4>				

                    </div>	
                </div>
                <div class="dashboard_date_cont">
                    <div class="dashboard_date_left">
                        <div style="display:inline-block; min-height:230px; background-color:#fff;">
                            <datepicker ng-model="dt" min-date="minDate" show-weeks="false" class="well2"></datepicker>
                        </div>
                    </div>
                    <div class="dashboard_date_right">
                        <div class="scroller" style="height: 230px; overflow:auto;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                            <div class="general-item-list">
                                <div class="item">
                                    <div class="item-head">
                                        <div class="item-details">
                                            <a href="" class="item-name primary-link">April 9</a>
                                        </div>											
                                    </div>
                                    <div class="item-body">
                                        AC
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="item-head">
                                        <div class="item-details">
                                            <a href="" class="item-name primary-link">April 15</a>
                                        </div>											
                                    </div>
                                    <div class="item-body">
                                        Fridge
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="item-head">
                                        <div class="item-details">
                                            <a href="" class="item-name primary-link">April 15</a>
                                        </div>											
                                    </div>
                                    <div class="item-body">
                                        Fridge
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="item-head">
                                        <div class="item-details">
                                            <a href="" class="item-name primary-link">April 15</a>
                                        </div>											
                                    </div>
                                    <div class="item-body">
                                        Fridge
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="item-head">
                                        <div class="item-details">
                                            <a href="" class="item-name primary-link">April 15</a>
                                        </div>											
                                    </div>
                                    <div class="item-body">
                                        Fridge
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard_blocks_five_icn">

                </div>	

            </div>

            <div class="dashboard_block_small" >
                <div  class="scroller" style="height: 270px; overflow:auto;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                    <div class="top_icn">
                        <img src="assets/admin/layout/img/Tips-Icon.png"/>
                    </div>
                    <div class="pill_cont">
                        <span class="pull-left pill_left">An eos constituto disputando, sit iusto causae fuisset ex.  eos amet tritani nominavi ex </span>
                        <span class="pull-right" style="padding-top:10%;"><img src="assets/admin/layout/img/Tips-Close-Icon.png"/></span>
                    </div>

                    <div class="pill_cont">
                        <span class="pull-left pill_left">An eos constituto disputando, sit iusto causae fuisset ex.  eos amet tritani nominavi ex </span>
                        <span class="pull-right" style="padding-top:10%;"><img src="assets/admin/layout/img/Tips-Close-Icon.png"/></span>
                    </div>

                    <div class="pill_cont">
                        <span class="pull-left pill_left">An eos constituto disputando, sit iusto causae fuisset ex.  eos amet tritani nominavi ex </span>
                        <span class="pull-right" style="padding-top:10%;"><img src="assets/admin/layout/img/Tips-Close-Icon.png"/></span>
                    </div>

                    <div class="pill_cont">
                        <span class="pull-left pill_left">An eos constituto disputando, sit iusto causae fuisset ex.  eos amet tritani nominavi ex </span>
                        <span class="pull-right" style="padding-top:10%;"><img src="assets/admin/layout/img/Tips-Close-Icon.png"/></span>
                    </div>


                </div>
            </div>

        </div>	
    </div>
    <!-- END MAIN CONTENT -->
